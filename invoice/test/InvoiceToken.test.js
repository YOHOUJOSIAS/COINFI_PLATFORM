const { expect } = require("chai");
const { ethers } = require("hardhat");

describe("InvoiceToken Smart Contract", function () {
    let InvoiceToken, invoiceToken, Usdt, usdt, owner, admin, company, investor, client;
    const PERCENTAGE_BASE = ethers.BigNumber.from("1000000000000000000"); // 1e18

    // Deploy contracts before each test
    beforeEach(async function () {
        [owner, admin, company, investor, client] = await ethers.getSigners();

        // Deploy mock USDT token
        Usdt = await ethers.getContractFactory("Usdt");
        usdt = await Usdt.deploy(owner.address, owner.address);
        await usdt.deployed();

        // Mint some USDT for the investor
        await usdt.mint(investor.address, ethers.utils.parseUnits("10000", 6));

        // Deploy InvoiceToken
        InvoiceToken = await ethers.getContractFactory("InvoiceToken");
        invoiceToken = await ethers.getContractFactory("InvoiceToken").then(f => f.deploy());
        await invoiceToken.deployed();
        
        // Initialize the contract
        await invoiceToken.initialize(
            usdt.address,
            admin.address,
            owner.address, // feeTreasury
            100,  // entryFee: 1%
            1000, // performanceFee: 10%
            200,  // poolFee: 2%
            300   // issuanceFee: 3%
        );
    });

    describe("Deployment and Initialization", function () {
        it("Should set the correct admin and roles", async function () {
            const ADMIN_ROLE = await invoiceToken.ADMIN_ROLE();
            expect(await invoiceToken.hasRole(ADMIN_ROLE, admin.address)).to.be.true;
        });

        it("Should set the correct stablecoin address", async function () {
            expect(await invoiceToken.stablecoinToken()).to.equal(usdt.address);
        });
    });

    describe("Invoice Lifecycle", function () {
        const invoiceAmount = ethers.utils.parseUnits("5000", 6);
        const interestRate = 500; // 5%

        it("Should allow a company to create an invoice", async function () {
            const fundingDuration = 60 * 60 * 24 * 7; // 7 days
            const dueDate = Math.floor(Date.now() / 1000) + (60 * 60 * 24 * 30); // 30 days from now

            await expect(invoiceToken.createInvoice(
                invoiceAmount,
                fundingDuration,
                dueDate,
                interestRate,
                "ipfs://metadata",
                company.address,
                client.address,
                false // requireCollateral
            )).to.emit(invoiceToken, "InvoiceCreated").withArgs(0, company.address, invoiceAmount, dueDate, interestRate, "ipfs://metadata");

            const invoice = await invoiceToken.invoices(0);
            expect(invoice.details.company).to.equal(company.address);
            expect(invoice.details.amount).to.equal(invoiceAmount);
        });

        it("Should allow an investor to invest in an active invoice", async function () {
            // First, create an invoice
            const fundingDuration = 60 * 60 * 24 * 7;
            const dueDate = Math.floor(Date.now() / 1000) + (60 * 60 * 24 * 30);
            await invoiceToken.createInvoice(invoiceAmount, fundingDuration, dueDate, interestRate, "ipfs://metadata", company.address, client.address, false);

            const investmentAmount = ethers.utils.parseUnits("1000", 6);
            
            // Investor approves the InvoiceToken contract to spend their USDT
            await usdt.connect(investor).approve(invoiceToken.address, investmentAmount);

            // Investor invests
            await expect(invoiceToken.connect(investor).invest(0, investmentAmount, investor.address))
                .to.emit(invoiceToken, "Invested");
            
            const invoice = await invoiceToken.invoices(0);
            const investorShare = await invoiceToken.investorShares(0, investor.address);

            // Check if the collected amount is correct (minus entry fee)
            const entryFee = investmentAmount.mul(100).div(10000); // 1%
            const netInvestment = investmentAmount.sub(entryFee);
            expect(invoice.financials.collectedAmount).to.equal(netInvestment);

            // Check investor shares
            const expectedShares = netInvestment.mul(PERCENTAGE_BASE).div(invoiceAmount);
            expect(investorShare).to.equal(expectedShares);
        });
    });
});
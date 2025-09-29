const { ethers } = require("hardhat");
const fs = require("fs");
const path = require("path");

async function main() {
    // Get the deployer (signer)
    const [deployer] = await ethers.getSigners();
    const feeTreasury = deployer.address; // Or another address
    const admin = deployer.address; // Assigning deployer as admin for simplicity

    console.log("Deploying contracts with the account:", deployer.address);
    
    // Get deployer balance using provider
    const balance = await deployer.provider.getBalance(deployer.address);
    console.log("Account balance:", ethers.formatUnits(balance, 18), "ETH");

    // 1. Deploy the mock USDT contract
    const Usdt = await ethers.getContractFactory("Usdt");
    const usdt = await Usdt.deploy(deployer.address, deployer.address);
    console.log("Deploying USDT contract...");
    await usdt.waitForDeployment();
    const usdtAddress = await usdt.getAddress();
    console.log("USDT (stablecoin) contract deployed to:", usdtAddress);

    // 2. Deploy the InvoiceToken contract
    const InvoiceToken = await ethers.getContractFactory("InvoiceToken");
    const invoiceToken = await InvoiceToken.deploy();
    console.log("Deploying InvoiceToken contract...");
    await invoiceToken.waitForDeployment();
    const invoiceTokenAddress = await invoiceToken.getAddress();
    console.log("InvoiceToken contract deployed to:", invoiceTokenAddress);

    // 3. Initialize the InvoiceToken contract
    console.log("Initializing InvoiceToken...");
    const tx = await invoiceToken.initialize(
        usdtAddress,        // _stablecoinAddress
        admin,              // _admin
        feeTreasury,        // _feeTreasury
        100,                // _entryFee (1%)
        1000,               // _performanceFee (10%)
        200,                // _poolFee (2%)
        500                 // _issuanceFee (5%)
    );
    await tx.wait(); // Wait for the transaction to be mined
    console.log("InvoiceToken initialized successfully.");

    // Prepare deployment data to save
    const deploymentData = {
        network: network.name,
        timestamp: new Date().toISOString(),
        deployer: deployer.address,
        contracts: {
            USDT: usdtAddress,
            InvoiceToken: invoiceTokenAddress
        },
        configuration: {
            admin: admin,
            feeTreasury: feeTreasury,
            entryFee: 100,          // 1%
            performanceFee: 1000,   // 10%
            poolFee: 200,           // 2%
            issuanceFee: 500        // 5%
        }
    };

    // Save deployment data to JSON file
    const deploymentsDir = path.join(__dirname, "deployments");
    if (!fs.existsSync(deploymentsDir)) {
        fs.mkdirSync(deploymentsDir, { recursive: true });
    }

    const deploymentFile = path.join(deploymentsDir, `deployment-${Date.now()}.json`);
    fs.writeFileSync(deploymentFile, JSON.stringify(deploymentData, null, 2));
    
    console.log("Deployment data saved to:", deploymentFile);

    console.log("--- Deployment Summary ---");
    console.log("Stablecoin (USDT) Address:", usdtAddress);
    console.log("InvoiceToken Address:", invoiceTokenAddress);
    console.log("Admin Address:", admin);
    console.log("Fee Treasury Address:", feeTreasury);
}

main()
    .then(() => process.exit(0))
    .catch((error) => {
        console.error(error);
        process.exit(1);
    });
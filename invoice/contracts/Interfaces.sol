// SPDX-License-Identifier: MIT
pragma solidity ^0.8.27;


interface IInvoiceToken {

    /**
     * @notice Core metadata and timeline for invoices
     * @dev Contains immutable invoice parameters
     * @param invoiceId Unique identifier (1, 2, 3...)
     * @param company Address of invoice originator
     * @param client Address obligated to pay invoice
     * @param amount Total face value in stablecoin decimals
     * @param fundingEndDate Timestamp when funding period closes
     * @param dueDate Timestamp when payment is due
     * @param interestRate Annual rate in basis points (1 = 0.01%)
     * @param metadataURI IPFS/HTTPS link to JSON metadata
     * @param isActive Whether invoice accepts investments
     */
    struct InvoiceDetails {
        uint256 invoiceId;
        address company;
        address client;
        uint256 amount;
        uint256 fundingEndDate;
        uint256 dueDate;
        uint256 interestRate;
        string metadataURI;
        bool isActive;
    }

    /**
     * @notice Financial state and accounting for invoices
     * @dev Tracks evolving financial metrics
     * @param totalSupply Total investor shares (1e18 = 100%)
     * @param collectedAmount Actually funded amount
     * @param repaymentAmount Total repaid to contract
     * @param interestWithheld Platform's interest portion
     * @param isPaid Whether client repaid fully
     * @param fundsWithdrawn Whether company claimed funds
     */
    struct InvoiceFinancials {
        uint256 totalSupply;
        uint256 collectedAmount;
        uint256 repaymentAmount;
        uint256 interestWithheld;
        bool isPaid;
        bool fundsWithdrawn; 
    }
    
    /**
     * @notice External references for invoices
     * @dev Links to other contract entities
     * @param poolId Associated pool (0 = no pool)
     */
    struct InvoiceReferences {
        uint256 poolId;
    }

    /**
     * @notice Complete invoice representation
     * @dev Combines all invoice-related data
     * @param details Immutable parameters and metadata
     * @param financials Mutable financial state
     * @param references External associations
     */
    struct Invoice {
        InvoiceDetails details;
        InvoiceFinancials financials;
        InvoiceReferences references;
    }
    
    /**
     * @notice Collateral requirement rates
     * @dev Basis points (1 = 0.01%) of invoice amount
     * @param initialDepositRate Upfront collateral percentage
     * @param withheldRate Percentage withheld from payout
     */
    struct CollateralRates {
        uint256 initialDepositRate;
        uint256 withheldRate;
    }

    /**
     * @notice Collateral deposit tracking
     * @dev Manages security for underwritten invoices
     * @param initialDeposit Initial collateral amount
     * @param withheldAmount Funds held from company payout
     * @param totalAmount Sum of all collateral held
     * @param isStaked Whether collateral is earning yield
     * @param isReleased Whether collateral was returned
     * @param isWithdrawable If unstaked funds are available
     * @param stakingPlatform Address of yield platform
     * @param stakingContract External staking contract
     * @param stakedAmount Amount currently earning yield
     * @param rates Requirement percentages
     */
    struct Collateral {
        uint256 initialDeposit;
        uint256 withheldAmount;
        uint256 totalAmount;
        bool isStaked;
        bool isReleased;
        bool isWithdrawable;
        address stakingPlatform;
        address stakingContract;
        uint256 stakedAmount;
        CollateralRates rates;
    }

    /**
     * @notice Investment pool configuration
     * @dev Bundles invoices for diversified investing
     * @param poolId Unique identifier
     * @name Human-readable identifier
     * @param invoiceIds List of contained invoices
     * @param totalAmount Sum of all invoice amounts
     * @param minInvestment Minimum participation amount
     * @param creationDate Pool deployment timestamp
     * @param isActive Whether accepting investments
     * @param maxInvoiceCount Cap on contained invoices
     * @param maxPoolAmount Total funding cap
     * @param metadataURI IPFS/HTTPS link to pool metadata
     */
    struct Pool {
        uint256 poolId;
        string name;
        uint256[] invoiceIds;
        uint256 totalAmount;
        uint256 minInvestment;
        uint256 creationDate;
        bool isActive;
        uint256 maxInvoiceCount;
        uint256 maxPoolAmount;
        string metadataURI;
    }
   
    /**
     * @notice Fee schedule for platform services
     * @dev Basis points (1 = 0.01%) of relevant amounts
     * @param entryFee Charged when investing (0-100 = 0-1%)
     * @param performanceFee On interest earned (0-2000 = 0-20%)
     * @param poolFee Additional pool management fee (0-300 = 0-3%)
     * @param issuanceFee On invoice funding amount (0-500 = 0-5%)
     */
    struct CommissionRates {
        uint256 entryFee;
        uint256 performanceFee;
        uint256 poolFee;
        uint256 issuanceFee;
    }
}
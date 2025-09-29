// SPDX-License-Identifier: MIT
pragma solidity ^0.8.27;

import "@openzeppelin/contracts-upgradeable/token/ERC1155/ERC1155Upgradeable.sol";
import "@openzeppelin/contracts-upgradeable/access/AccessControlUpgradeable.sol";
import "@openzeppelin/contracts-upgradeable/security/ReentrancyGuardUpgradeable.sol";
import "@openzeppelin/contracts-upgradeable/proxy/utils/Initializable.sol";
import "@openzeppelin/contracts-upgradeable/token/ERC20/IERC20Upgradeable.sol";
import "@openzeppelin/contracts-upgradeable/utils/structs/EnumerableSetUpgradeable.sol";
import "@openzeppelin/contracts-upgradeable/token/ERC20/utils/SafeERC20Upgradeable.sol";
import "./Roles.sol";
import "./Interfaces.sol";
import "./Libraries.sol";
import "./Errors.sol";

/**
 * @title Math - Safe math utilities
 * @notice Library containing math operations with safety checks
 */
library InvoiceMath {
    /**
     * @notice Returns the minimum of two numbers
     * @dev Pure function with no side effects
     * @param a First number to compare
     * @param b Second number to compare
     * @return uint256 The smaller of the two input numbers
     * 
     * @dev Example:
     * ```solidity
     * InvoiceMath.min(5, 10) => returns 5
     * InvoiceMath.min(100, 100) => returns 100
     * ```
     */
    function min(uint256 a, uint256 b) internal pure returns (uint256) {
        return a < b ? a : b;
    }
}

/**
 * @title InvoiceToken - ERC1155-based Invoice Financing Platform
 * @notice A decentralized platform for invoice financing using ERC1155 tokens
 * @dev This contract allows companies to tokenize invoices, investors to fund them,
 * and handles the entire lifecycle including collateral management, repayments, and fees.
 * 
 * Key Features:
 * - Invoice tokenization as ERC1155 tokens
 * - Collateral management system
 * - Investment pools for diversified exposure
 * - Multi-tiered fee structure
 * - Time-locked administrative functions
 * - Compensation mechanism for defaulted invoices
 * 
 * Roles:
 * - DEFAULT_ADMIN_ROLE: Full administrative privileges
 * - ADMIN_ROLE: Can update critical parameters with timelock
 * - OPERATOR_ROLE: Manages pools and invoice listings
 * 
 * @custom:security-contact security@yourdomain.com
 */
contract InvoiceToken is Initializable,
    ERC1155Upgradeable, 
    AccessControlUpgradeable, 
    ReentrancyGuardUpgradeable  {
    using SafeERC20Upgradeable for IERC20Upgradeable;
    using EnumerableSetUpgradeable for EnumerableSetUpgradeable.UintSet;
    using EnumerableSetUpgradeable for EnumerableSetUpgradeable.AddressSet;
    using InvoiceCalculations for uint256;
    using PoolLib for IInvoiceToken.Pool; 

    // State Variables
    IERC20Upgradeable public stablecoinToken;
    // uint256 public constant TIMELOCK_DURATION = 2 days; // 48 heures
    uint256 public constant TIMELOCK_DURATION = 30 minutes; // 48 heures
    address public feeTreasury;
    uint256 public totalInvestedAmounts;
    uint256 public nextInvoiceId;
    uint256 public nextPoolId;
    bool private _paused;
    uint256 PERCENTAGE_BASE = 1e18;


    // Structures
    IInvoiceToken.CollateralRates public defaultCollateralRates = IInvoiceToken.CollateralRates({
        initialDepositRate: 2000, // 20%
        withheldRate: 1000        // 10%
    });

    IInvoiceToken.CommissionRates public commissionRates;
    
    // Mappings
    mapping(uint256 => IInvoiceToken.Invoice) public invoices;
    mapping(uint256 => IInvoiceToken.Pool) public pools;
    mapping(uint256 => IInvoiceToken.Collateral) public invoiceCollaterals;
    mapping(uint256 => mapping(address => uint256)) public investorShares;
    mapping(address => EnumerableSetUpgradeable.UintSet) private investorInvoices;
    mapping(address => EnumerableSetUpgradeable.UintSet) private companyInvoices;
    mapping(address => EnumerableSetUpgradeable.UintSet) private clientInvoices;
    mapping(uint256 => EnumerableSetUpgradeable.AddressSet) private invoiceInvestors;
    mapping(bytes32 => uint256) private _timelocks;

    // Events
    event InvoiceCreated(uint256 indexed invoiceId, address indexed company, uint256 amount, uint256 dueDate, uint256 interestRate, string metadataURI);
    event Invested(uint256 indexed invoiceId, address indexed investor, uint256 amount, uint256 fee);
    event Repaid(uint256 indexed invoiceId, uint256 totalAmount, uint256 feeAmount);
    event FundsClaimed(address indexed investor, uint256 amount);
    event CommissionsWithdrawn(address indexed admin, uint256 amount);
    event PartialCommissionsWithdrawn(address indexed admin, uint256 totalAmount, uint256[] invoiceIds);
    event CommissionRatesUpdated(uint256 entryFee, uint256 performanceFee, uint256 poolFee, uint256 issuanceFee);
    event CollateralDeposited(uint256 indexed invoiceId, uint256 amount);
    event CollateralReleased(uint256 indexed invoiceId, address indexed to, uint256 amount);
    event CollateralStaked(uint256 indexed invoiceId, address indexed platform);
    event PoolCreated(uint256 indexed poolId, string name, uint256 minInvestment, uint256 maxInvoiceCount, uint256 maxPoolAmount);
    event InvoiceAddedToPool(uint256 indexed invoiceId, uint256 indexed poolId);
    event PoolInvested(uint256 indexed poolId, address indexed investor, uint256 amount, uint256 totalFees);
    event PoolStatusChanged(uint256 indexed poolId, bool active);

    event CollateralUnstaked(uint256 indexed invoiceId);
    event InvestorsCompensated(uint256 indexed invoiceId, uint256 amount);
    event EmergencyWithdraw(uint256 indexed invoiceId, address newContract);
    event InvoiceActivated(uint256 indexed invoiceId);

    event Paused(address account);
    event Unpaused(address account);

    event TimelockStarted(bytes32 indexed operationId, uint256 scheduledTime);
    event TimelockExecuted(bytes32 indexed operationId);

    event StablecoinUpdated(address oldToken, address newToken);
    event ExcessAmountReturned(uint256 indexed invoiceId, address indexed investor, uint256 amount);

    event EmergencyFundsRecovery(address indexed admin, address indexed token, uint256 amount);

    event CompensationStarted(uint256 indexed invoiceId, uint256 collateralAmount);
    event InvestorCompensated(uint256 indexed invoiceId, address indexed investor, uint256 amount);
    event CompensationCompleted(uint256 indexed invoiceId, uint256 totalDistributed);

    /**
     * @notice Initializes the InvoiceToken contract
     * @dev Sets up roles, stablecoin, and initial fee structure
     * @param _stablecoinAddress Address of the stablecoin used for payments
     * @param _admin Address to be granted admin privileges
     * @param _feeTreasury Address where fees will be collected
     * @param _entryFee Initial entry fee (1e18 = 100%)
     * @param _performanceFee Initial performance fee (1e18 = 100%)
     * @param _poolFee Initial pool management fee (1e18 = 100%)
     * @param _issuanceFee Initial invoice issuance fee (1e18 = 100%)
     * @custom:reverts InvalidAddress if stablecoin address is zero
     */
    function initialize(
        address _stablecoinAddress,
        address _admin,
        address _feeTreasury,
        uint256 _entryFee,
        uint256 _performanceFee,
        uint256 _poolFee,
        uint256 _issuanceFee
    ) public initializer {
        __AccessControl_init();
        __ReentrancyGuard_init();

        if (_stablecoinAddress == address(0)) revert InvalidAddress();
        stablecoinToken = IERC20Upgradeable(_stablecoinAddress);
        feeTreasury = _feeTreasury;
        
        _grantRole(DEFAULT_ADMIN_ROLE, _admin);
        _grantRole(Roles.ADMIN_ROLE, _admin);
        _grantRole(Roles.OPERATOR_ROLE, _admin);
        _setRoleAdmin(Roles.OPERATOR_ROLE, DEFAULT_ADMIN_ROLE);
        
        commissionRates = IInvoiceToken.CommissionRates({
            entryFee: _entryFee,
            performanceFee: _performanceFee,
            poolFee: _poolFee,
            issuanceFee: _issuanceFee
        });
    }


   

    // ============ ADMIN FUNCTIONS ============

    /**
     * @notice Pauses all non-admin functionality
     * @dev Only callable by DEFAULT_ADMIN_ROLE
     * @custom:emits Paused
     */
    function pause() external onlyRole(DEFAULT_ADMIN_ROLE) {
        _paused = true;
        emit Paused(msg.sender);
    }

    /**
     * @notice Unpauses the contract
     * @dev Only callable by DEFAULT_ADMIN_ROLE
     * @custom:emits Unpaused
     */ 
    function unpause() external onlyRole(DEFAULT_ADMIN_ROLE) {
        _paused = false;
        emit Unpaused(msg.sender);
    }

    /**
    * @dev Modifier to check contract pause state
    * @notice Reverts if contract is paused
    * @custom:reverts "Contract is paused" if _paused is true
    */
    modifier whenNotPaused() {
        require(!_paused, "Contract is paused");
        _;
    }

    /**
     * @notice Initiates timelock to update commission rates
     * @dev Rates have maximum limits to prevent excessive fees
     * @param _entryFee New entry fee (max 1%)
     * @param _performanceFee New performance fee (max 20%)
     * @param _poolFee New pool fee (max 3%)
     * @param _issuanceFee New issuance fee (max 5%)
     * @custom:reverts InvalidAmount if any fee exceeds maximum
     * @custom:emits TimelockStarted
     */
    function startUpdateCommissionRates(
        uint256 _entryFee,
        uint256 _performanceFee,
        uint256 _poolFee,
        uint256 _issuanceFee
    ) external onlyRole(Roles.ADMIN_ROLE) {
        if (_entryFee > 100) revert InvalidAmount(); // Max 1%
        if (_performanceFee > 2000) revert InvalidAmount(); // Max 20%
        if (_poolFee > 300) revert InvalidAmount(); // Max 3%
        if (_issuanceFee > 500) revert InvalidAmount(); // Max 5%
        
        bytes32 operationId = keccak256(abi.encodePacked("commissionRates", _entryFee, _performanceFee, _poolFee, _issuanceFee));
        _startTimelock(operationId);
    }

    /**
     * @notice Updates commission rates after timelock expires
     * @dev Requires prior timelock initiation
     * @param _entryFee New entry fee
     * @param _performanceFee New performance fee
     * @param _poolFee New pool fee
     * @param _issuanceFee New issuance fee
     * @custom:reverts TimelockNotExpired if waiting period not over
     * @custom:emits CommissionRatesUpdated
     */
    function updateCommissionRates(
        uint256 _entryFee,
        uint256 _performanceFee,
        uint256 _poolFee,
        uint256 _issuanceFee
    ) external onlyRole(Roles.ADMIN_ROLE) {
        bytes32 operationId = keccak256(abi.encodePacked("commissionRates", _entryFee, _performanceFee, _poolFee, _issuanceFee));
    _checkTimelock(operationId);

        if (_entryFee > 100) revert InvalidAmount(); // Max 1%
        if (_performanceFee > 2000) revert InvalidAmount(); // Max 20%
        if (_poolFee > 300) revert InvalidAmount(); // Max 3%
        if (_issuanceFee > 500) revert InvalidAmount(); // Max 5%
        
        commissionRates = IInvoiceToken.CommissionRates({
            entryFee: _entryFee,
            performanceFee: _performanceFee,
            poolFee: _poolFee,
            issuanceFee: _issuanceFee
        });
        
        emit CommissionRatesUpdated(_entryFee, _performanceFee, _poolFee, _issuanceFee);
        delete _timelocks[operationId];
        emit TimelockExecuted(operationId);
    }
 
    /**
    * @notice Updates the fee treasury address
    * @dev Only callable by ADMIN_ROLE
    * @param _newTreasury New treasury address
    * @custom:reverts InvalidAddress if zero address provided
    */
    function updateFeeTreasury(address _newTreasury) external onlyRole(Roles.ADMIN_ROLE) {
        if (_newTreasury == address(0)) revert InvalidAddress();
        feeTreasury = _newTreasury;
    }
    
    /**
    * @notice Updates collateral rate parameters
    * @dev Rates are in basis points (1 = 0.01%)
    * @param initialRate New initial deposit rate (max 50%)
    * @param withheldRate New withheld rate (max 30%)
    * @custom:reverts InvalidAmount if rates exceed maximums
    */
    function updateCollateralRates(uint256 initialRate, uint256 withheldRate) external onlyRole(Roles.ADMIN_ROLE) {
        if (initialRate > 5000) revert InvalidAmount(); // Max 50%
        if (withheldRate > 3000) revert InvalidAmount(); // Max 30%
        
        defaultCollateralRates = IInvoiceToken.CollateralRates(initialRate, withheldRate);
     }


    /**
    * @notice Emergency recovery of funds (admin only)
    * @dev Bypasses timelock for emergency situations
    * @param tokenAddress Token to recover (address(0) for ETH)
    * @param amount Amount to recover (0 = full balance)
    * @custom:emits EmergencyFundsRecovery
    */
    function executeEmergencyRecoverFunds(address tokenAddress, uint256 amount) 
        external 
        onlyRole(DEFAULT_ADMIN_ROLE) 
        nonReentrant
    {
        
        if (tokenAddress == address(0)) {
            uint256 ethBalance = address(this).balance;
            if (amount == 0 || amount > ethBalance) {
                amount = ethBalance;
            }
            payable(msg.sender).transfer(amount);
        } else {
            IERC20Upgradeable token = IERC20Upgradeable(tokenAddress);
            uint256 tokenBalance = token.balanceOf(address(this));
            if (amount == 0 || amount > tokenBalance) {
                amount = tokenBalance;
            }
            token.safeTransfer(msg.sender, amount);
        }
        
        emit EmergencyFundsRecovery(msg.sender, tokenAddress, amount);
    }

    /**
    * @notice Updates the stablecoin contract address
    * @dev Performs basic ERC20 validation check
    * @param newToken Address of new stablecoin contract
    * @custom:reverts InvalidAddress if zero address
    * @custom:reverts SameToken if identical to current
    * @custom:reverts InvalidToken if not ERC20
    * @custom:emits StablecoinUpdated
    */
    function updateStablecoin(address newToken) external onlyRole(Roles.ADMIN_ROLE) {
        if (newToken == address(0)) revert InvalidAddress();
        if (newToken == address(stablecoinToken)) revert SameToken();
        
        (bool success, ) = newToken.call(abi.encodeWithSignature("balanceOf(address)", address(this)));
        if (!success) revert InvalidToken();
        
        emit StablecoinUpdated(address(stablecoinToken), newToken);
        
        stablecoinToken = IERC20Upgradeable(newToken);
    }
    

    // ============ INVOICE FUNCTIONS ============
    function createInvoice(
        uint256 amount,
        uint256 fundingDuration,
        uint256 dueDate,
        uint256 interestRate,
        string memory metadataURI,
        address companyAddress,
        address clientAddress,
        bool requireCollateral
    ) external whenNotPaused {
        if (fundingDuration == 0) revert InvalidAmount();
        if (dueDate <= block.timestamp + fundingDuration) revert DeadlinePassed();
        if (interestRate > 2000) revert InvalidAmount(); // Max 20%
        if (clientAddress == address(0)) revert InvalidAddress();

        uint256 invoiceId = nextInvoiceId++;
        
        invoices[invoiceId] = IInvoiceToken.Invoice({
            details: IInvoiceToken.InvoiceDetails({
                invoiceId: invoiceId,
                company: companyAddress,
                client: clientAddress,
                amount: amount,
                fundingEndDate: block.timestamp + fundingDuration,
                dueDate: dueDate,
                interestRate: interestRate,
                metadataURI: metadataURI,
                isActive: !requireCollateral
            }),
            financials: IInvoiceToken.InvoiceFinancials({
                totalSupply: 0,
                collectedAmount: 0,
                repaymentAmount: 0,
                interestWithheld: 0,
                isPaid: false,
                fundsWithdrawn: false
            }),
            references: IInvoiceToken.InvoiceReferences({
                poolId: 0
            })
        });

        if (requireCollateral) {
            invoiceCollaterals[invoiceId] = _initCollateral();
        }

        companyInvoices[companyAddress].add(invoiceId);
        clientInvoices[clientAddress].add(invoiceId);
        emit InvoiceCreated(invoiceId, companyAddress, amount, dueDate, interestRate, metadataURI);
    }

    // ============ INVESTOR FUNCTIONS ============

    /**
     * @notice Allows an investor to fund an invoice
     * @dev Calculates and deducts entry fee automatically
     * @param invoiceId ID of invoice to invest in
     * @param amount Amount to invest in stablecoin
     * @param investor Address of the investor
     * @custom:reverts InvoiceAlreadyPaid if invoice was repaid
     * @custom:reverts DeadlinePassed if funding period ended
     * @custom:reverts AlreadyFullyFunded if no more capacity
     * @custom:emits Invested
     */
    function invest(uint256 invoiceId, uint256 amount, address investor) external nonReentrant whenNotPaused{
        IInvoiceToken.Invoice storage invoice = invoices[invoiceId];
        if (invoice.financials.isPaid) revert InvoiceAlreadyPaid();
        if (block.timestamp >= invoice.details.dueDate) revert DeadlinePassed();
        if (amount == 0) revert InvalidAmount();
        if (invoice.financials.totalSupply >= invoice.details.amount) revert AlreadyFullyFunded();
        if (!invoice.details.isActive) revert InvoiceNotActive();

        uint256 allowance = stablecoinToken.allowance(investor, address(this));
        if (allowance < amount) revert InsufficientFunds();

        uint256 entryFee = amount.calculateFee(commissionRates.entryFee);
        uint256 netInvestment = amount - entryFee;

        uint256 newTotalSupply = invoice.financials.totalSupply + netInvestment;
        
        if (newTotalSupply > invoice.details.amount) {
            uint256 excessAmount = newTotalSupply - invoice.details.amount;
            netInvestment -= excessAmount;
            entryFee = netInvestment.calculateFee(commissionRates.entryFee);
            newTotalSupply = invoice.details.amount;
            stablecoinToken.safeTransferFrom(investor, investor, excessAmount);
            emit ExcessAmountReturned(invoiceId, investor, excessAmount);
        }

        uint256 allocationRatio = netInvestment.calculateShares(invoice.details.amount);
        totalInvestedAmounts += netInvestment;
        
        _mint(investor, invoiceId, allocationRatio, "");
        investorShares[invoiceId][investor] += allocationRatio;
        
        if (investorShares[invoiceId][investor] == allocationRatio) {
            investorInvoices[investor].add(invoiceId);
              
              invoiceInvestors[invoiceId].add(investor);
        }
        
        invoice.financials.totalSupply = newTotalSupply;
        invoice.financials.collectedAmount += netInvestment;
        
        stablecoinToken.safeTransferFrom(investor, address(this), netInvestment);
        if (entryFee > 0) {
            stablecoinToken.safeTransferFrom(investor, feeTreasury, entryFee);
        }
        
        emit Invested(invoiceId, investor, netInvestment, entryFee);
    }

    /**
     * @notice Allows investors to claim funds after repayment
     * @dev Burns investor's ERC1155 tokens upon claiming
     * @param invoiceId ID of paid invoice
     * @param investor Address to receive funds
     * @custom:reverts InvoiceNotActive if not yet repaid
     * @custom:reverts Unauthorized if no investment found
     * @custom:emits FundsClaimed
     */
    function claimFunds(uint256 invoiceId, address investor) external nonReentrant whenNotPaused {
        IInvoiceToken.Invoice storage invoice = invoices[invoiceId];
        if (!invoice.financials.isPaid) revert InvoiceNotActive();
        
        uint256 investorRatio = investorShares[invoiceId][investor];
        if (investorRatio == 0) revert Unauthorized();
        
        uint256 grossAmount = (invoice.financials.repaymentAmount * investorRatio) / PERCENTAGE_BASE;
        
        _burn(investor, invoiceId, investorRatio);
        investorShares[invoiceId][investor] = 0;
        investorInvoices[investor].remove(invoiceId);
        
        stablecoinToken.safeTransfer(investor, grossAmount);
        emit FundsClaimed(investor, grossAmount);
    }


    // ================== ClIENT FUNCTION ========

    /**
     * @notice Allows client to repay an invoice
     * @dev Handles surplus amounts and fee distribution
     * @param invoiceId ID of invoice to repay
     * @param client Address making the payment (must match invoice client)
     * @custom:reverts InvalidStatus if invoice not in repayable state
     * @custom:reverts Unauthorized if caller isn't the client
     * @custom:emits Repaid
     */
    function repayInvoice(uint256 invoiceId, address client) external nonReentrant whenNotPaused {
        IInvoiceToken.Invoice storage invoice = invoices[invoiceId];
        
        if (invoice.details.amount == 0) revert InvalidStatus();
        if (client != invoice.details.client) revert Unauthorized();
        if (invoice.financials.isPaid) revert InvoiceAlreadyPaid();
        if (!invoice.financials.fundsWithdrawn) revert InvalidStatus();

        uint256 totalAmount = invoice.details.amount;
        stablecoinToken.safeTransferFrom(client, address(this), totalAmount);

        uint256 surplus = totalAmount - invoice.financials.collectedAmount;
        
        if (surplus > 0) {
            stablecoinToken.safeTransfer(invoice.details.company, surplus);
        }

        uint256 interest = invoice.financials.interestWithheld;
        uint256 performanceFee = (interest * commissionRates.performanceFee) / 10000;
        uint256 investorPayment = totalAmount + (interest - performanceFee);

        stablecoinToken.safeTransfer(feeTreasury, performanceFee);

        invoice.financials.isPaid = true;
        invoice.financials.repaymentAmount = investorPayment;

        emit Repaid(invoiceId, investorPayment, performanceFee);
    }

    // ============ POOL FUNCTIONS ============

    /**
     * @notice Creates a new investment pool
     * @dev Pools allow diversified investment across multiple invoices
     * @param name Human-readable pool name
     * @param minInvestment Minimum investment amount
     * @param maxInvoiceCount Maximum invoices in pool (0 = unlimited)
     * @param maxPoolAmount Maximum total pool size (0 = unlimited)
     * @param metadataURI URI for pool metadata
     * @return poolId ID of newly created pool
     * @custom:emits PoolCreated
     */
    function createPool(
        string memory name,
        uint256 minInvestment,
        uint256 maxInvoiceCount,
        uint256 maxPoolAmount,
        string memory metadataURI
    ) external  onlyRole(Roles.OPERATOR_ROLE) returns (uint256) {
        uint256 poolId = nextPoolId++;
        
        pools[poolId] = IInvoiceToken.Pool({
            poolId: poolId,
            name: name,
            invoiceIds: new uint256[](0),
            totalAmount: 0,
            minInvestment: minInvestment,
            creationDate: block.timestamp,
            isActive: true,
            maxInvoiceCount: maxInvoiceCount,
            maxPoolAmount: maxPoolAmount,
            metadataURI: metadataURI
        });
        
        emit PoolCreated(poolId, name, minInvestment, maxInvoiceCount, maxPoolAmount);
        return poolId;
    }

    /**
    * @notice Adds an invoice to a pool
    * @dev Only callable by OPERATOR_ROLE
    * @param invoiceId Invoice to add
    * @param poolId Pool to receive invoice
    * @custom:reverts PoolNotActive if pool inactive
    * @custom:reverts InvoiceNotEligibleForPool if already in pool
    * @custom:reverts DeadlinePassed if funding period ended
    * @custom:reverts CollateralNotDeposited if required but missing
    * @custom:emits InvoiceAddedToPool
    */
    function addInvoiceToPool(uint256 invoiceId, uint256 poolId) external onlyRole(Roles.OPERATOR_ROLE)  {
        IInvoiceToken.Pool storage pool = pools[poolId];
        IInvoiceToken.Invoice storage invoice = invoices[invoiceId];
        
        if (!pool.isActive) revert PoolNotActive();
        if (invoice.references.poolId != 0) revert InvoiceNotEligibleForPool();
        if (invoice.financials.isPaid) revert InvoiceAlreadyPaid();
        if (block.timestamp >= invoice.details.fundingEndDate) revert DeadlinePassed();

        if (invoiceCollaterals[invoiceId].rates.initialDepositRate > 0 && !invoice.details.isActive) {
            revert CollateralNotDeposited();
        }

        if (pool.maxInvoiceCount > 0 && pool.invoiceIds.length >= pool.maxInvoiceCount) {
            revert PoolFull();
        }
        if (pool.maxPoolAmount > 0 && pool.totalAmount + invoice.details.amount > pool.maxPoolAmount) {
            revert PoolFull();
        }
        
        invoice.references.poolId = poolId;
        pool.invoiceIds.push(invoiceId);
        pool.totalAmount += invoice.details.amount;
        
        emit InvoiceAddedToPool(invoiceId, poolId);
    }

    /**
    * @notice Invests in a pool (distributes across invoices)
    * @dev Handles proportional allocation and excess refunds
    * @param poolId Pool to invest in
    * @param amount Total investment amount
    * @param investor Investor address
    * @custom:reverts PoolNotActive if pool inactive
    * @custom:reverts InvestmentTooSmall if below minimum
    * @custom:reverts InsufficientFunds if allowance too low
    * @custom:emits PoolInvested
    */
    function investInPool(uint256 poolId, uint256 amount, address investor) external nonReentrant whenNotPaused {
        IInvoiceToken.Pool storage pool = pools[poolId];
        
        if (!pool.isActive) revert PoolNotActive();
        if (amount < pool.minInvestment) revert InvestmentTooSmall();
        if (pool.invoiceIds.length == 0) revert PoolNotActive();
        if (stablecoinToken.allowance(investor, address(this)) < amount) revert InsufficientFunds();

        uint256 totalFees = amount.calculateFee(commissionRates.entryFee + commissionRates.poolFee);
        uint256 netInvestmentAmount = amount - totalFees;

        stablecoinToken.safeTransferFrom(investor, address(this), netInvestmentAmount);
        stablecoinToken.safeTransferFrom(investor, feeTreasury, totalFees);

        uint256 totalAvailable;
        for (uint256 i = 0; i < pool.invoiceIds.length; i++) {
            IInvoiceToken.Invoice storage invoice = invoices[pool.invoiceIds[i]];
            if (block.timestamp < invoice.details.fundingEndDate && 
                invoice.financials.totalSupply < invoice.details.amount) {
                totalAvailable += invoice.details.amount - invoice.financials.totalSupply;
            }
        }

        if (totalAvailable == 0) {
            stablecoinToken.safeTransfer(investor, netInvestmentAmount);
            revert InvestmentFailed();
        }

        uint256 totalInvested;
        uint256 remainingAmount = netInvestmentAmount;

        for (uint256 i = 0; i < pool.invoiceIds.length && remainingAmount > 0; i++) {
            IInvoiceToken.Invoice storage invoice = invoices[pool.invoiceIds[i]];
            uint256 available = invoice.details.amount - invoice.financials.totalSupply;
            if (available == 0) continue;

            uint256 toInvest = InvoiceMath.min(
                (netInvestmentAmount * available) / totalAvailable,
                remainingAmount
            );

            if (i == pool.invoiceIds.length - 1) {
                toInvest = remainingAmount;
            }

            toInvest = InvoiceMath.min(toInvest, available);

            if (toInvest > 0) {
                _processInvestment(pool.invoiceIds[i], toInvest, investor);
                totalInvested += toInvest;
                remainingAmount -= toInvest;
            }
        }

        if (remainingAmount > 0) {
            stablecoinToken.safeTransfer(investor, remainingAmount);
        }

        emit PoolInvested(poolId, investor, totalInvested, totalFees);
    }

    /**
    * @notice Toggles pool active status
    * @dev Only callable by OPERATOR_ROLE
    * @param poolId Pool to modify
    * @param active New active status
    * @custom:reverts InvalidStatus if pool doesn't exist
    * @custom:emits PoolStatusChanged
    */
    function setPoolActive(uint256 poolId, bool active) external onlyRole(Roles.OPERATOR_ROLE) {
        if (pools[poolId].poolId == 0) revert InvalidStatus();
        pools[poolId].isActive = active;
        emit PoolStatusChanged(poolId, active);
    }

    // ============ COLLATERAL FUNCTIONS ============

    /**
     * @notice Deposits collateral to activate an invoice
     * @dev Collateral amount calculated from initialDepositRate
     * @param invoiceId ID of invoice to collateralize
     * @param campagny Address making the deposit (must match invoice company)
     * @custom:reverts Unauthorized if caller isn't the company
     * @custom:reverts FundingPeriodEnded if funding window closed
     * @custom:emits CollateralDeposited
     * @custom:emits InvoiceActivated
     */
    function depositCollateral(uint256 invoiceId, address campagny) external nonReentrant whenNotPaused {
        IInvoiceToken.Invoice storage invoice = invoices[invoiceId];
        IInvoiceToken.Collateral storage collateral = invoiceCollaterals[invoiceId];
        
        if (campagny != invoice.details.company) revert Unauthorized();
        if (invoice.details.isActive) revert InvalidStatus();
        if (collateral.rates.initialDepositRate == 0) revert InvalidAmount();
        if (block.timestamp >= invoice.details.fundingEndDate) revert FundingPeriodEnded();

        uint256 depositAmount = (invoice.details.amount * collateral.rates.initialDepositRate) / 10000;
        stablecoinToken.safeTransferFrom(campagny, address(this), depositAmount);

        collateral.initialDeposit = depositAmount;
        collateral.totalAmount = depositAmount;
        invoice.details.isActive = true;

        emit CollateralDeposited(invoiceId, depositAmount);
        emit InvoiceActivated(invoiceId);
    }

    /**
    * @notice Compensates investors from collateral
    * @dev Only callable by ADMIN_ROLE
    * @param invoiceId Defaulted invoice ID
    * @custom:reverts InvalidStatus if invoice doesn't exist
    * @custom:reverts DeadlineNotPassed if not yet due
    * @custom:reverts InvoiceAlreadyPaid if already repaid
    * @custom:reverts NoCollateral if no collateral available
    * @custom:emits CompensationStarted
    * @custom:emits InvestorCompensated (per investor)
    * @custom:emits CompensationCompleted
    */
    function compensateInvestors(uint256 invoiceId) external onlyRole(Roles.ADMIN_ROLE) nonReentrant whenNotPaused {
    

        _validateCompensation(invoiceId);


        (uint256 amountDistributed, uint256 performanceFee) = _calculateDistribution(invoiceId);
        
        _distributeToInvestors(invoiceId, amountDistributed);
        
        _finalizeCompensation(invoiceId, amountDistributed, performanceFee);
        
    }

    /**
    * @notice Releases collateral to company after repayment
    * @dev Automatically unstakes if needed
    * @param invoiceId Paid invoice ID
    * @custom:reverts InvoiceNotActive if not repaid
    * @custom:reverts CollateralAlreadyReleased if already released
    * @custom:emits CollateralReleased
    */
    function releaseCollateral(uint256 invoiceId) external nonReentrant whenNotPaused {
        IInvoiceToken.Invoice storage invoice = invoices[invoiceId];
        IInvoiceToken.Collateral storage collateral = invoiceCollaterals[invoiceId];

        if (!invoice.financials.isPaid) revert InvoiceNotActive();
        if (collateral.isReleased) revert CollateralAlreadyReleased();

        stablecoinToken.safeTransfer(invoice.details.company, collateral.totalAmount);
        collateral.isReleased = true;

        emit CollateralReleased(invoiceId, invoice.details.company, collateral.totalAmount);
    }

    // ============= WITHDRAW FUNCTIONS ==========

    /**
    * @notice Allows company to withdraw collected funds
    * @dev Withholds portion for collateral if required
    * @param invoiceId ID of funded invoice
    * @param campagny Address requesting withdrawal
    * @custom:reverts InvoiceNotActive if not activated
    * @custom:reverts Unauthorized if not invoice company
    * @custom:reverts InvalidStatus if funds already withdrawn
    */
    function withdrawCollectedFunds(uint256 invoiceId, address campagny) external nonReentrant whenNotPaused{
        IInvoiceToken.Invoice storage invoice = invoices[invoiceId];
        IInvoiceToken.Collateral storage collateral = invoiceCollaterals[invoiceId];
        
        if (!invoice.details.isActive) revert InvoiceNotActive();
        if (campagny != invoice.details.company) revert Unauthorized();
        if (invoice.financials.fundsWithdrawn) revert InvalidStatus();

        uint256 interest = invoice.financials.collectedAmount * invoice.details.interestRate / 10000;
        uint256 platformFee = invoice.financials.collectedAmount * commissionRates.issuanceFee / 10000;
        uint256 netAmount = invoice.financials.collectedAmount - interest - platformFee;

        uint256 withheldAmount = 0;
        if (collateral.totalAmount > 0) {
            withheldAmount = netAmount * collateral.rates.withheldRate / 10000;
            collateral.withheldAmount = withheldAmount;
            collateral.totalAmount += withheldAmount;
        }


        stablecoinToken.safeTransfer(feeTreasury, platformFee);

        invoice.financials.interestWithheld = interest;
        invoice.financials.fundsWithdrawn = true;

        stablecoinToken.safeTransfer(invoice.details.company, netAmount - withheldAmount);
    }

    // ============ VIEW FUNCTIONS ============

    /**
     * @notice Returns complete details of all invoices
     * @dev May be gas-intensive with many invoices
     * @return allInvoices Array of all Invoice structs
     */
    function getAllInvoices() external view returns (IInvoiceToken.Invoice[] memory) {
        IInvoiceToken.Invoice[] memory allInvoices = new IInvoiceToken.Invoice[](nextInvoiceId);
        
        for (uint256 i = 0; i < nextInvoiceId; i++) {
            allInvoices[i] = invoices[i];
        }
        
        return allInvoices;
    }

    /**
     * @notice Returns invoices associated with an investor
     * @param investor Address to query
     * @return Array of Invoice structs the investor has funded
     */
    function getInvestorInvoices(address investor) external view returns (IInvoiceToken.Invoice[] memory) {
        uint256[] memory invoiceIds = investorInvoices[investor].values();
        IInvoiceToken.Invoice[] memory result = new IInvoiceToken.Invoice[](invoiceIds.length);
        
        for (uint256 i = 0; i < invoiceIds.length; i++) {
            result[i] = invoices[invoiceIds[i]];
        }
        
        return result;
    }


    /**
    * @notice Returns all invoices in a pool
    * @param poolId Pool to query
    * @return invoicesDetails Array of Invoice structs
    * @custom:reverts InvalidStatus if pool doesn't exist
    */
    function getPoolInvoices(uint256 poolId) external view returns (IInvoiceToken.Invoice[] memory) {
        uint256[] memory invoiceIds = pools[poolId].invoiceIds;
        IInvoiceToken.Invoice[] memory invoicesDetails = new IInvoiceToken.Invoice[](invoiceIds.length);
        
        for (uint256 i = 0; i < invoiceIds.length; i++) {
            invoicesDetails[i] = invoices[invoiceIds[i]];
        }
        
        return invoicesDetails;
    }

    /**
    * @notice Returns all created pools
    * @return allPools Array of all Pool structs
    */
    function getAllPools() external view returns (IInvoiceToken.Pool[] memory) {
        IInvoiceToken.Pool[] memory allPools = new IInvoiceToken.Pool[](nextPoolId);
        
        for (uint256 i = 0; i < nextPoolId; i++) {
            allPools[i] = pools[i];
        }
        
        return allPools;
    }

    /**
    * @notice Returns all investors in an invoice
    * @param invoiceId Invoice to query
    * @return Array of investor addresses
    */
    function getInvoiceInvestors(uint256 invoiceId) external view returns (address[] memory) {
        return invoiceInvestors[invoiceId].values();
    }

    /**
     * @notice Returns standard ADMIN_ROLE bytes32 value
     * @return bytes32 role identifier
     */
    function ADMIN_ROLE() public pure returns (bytes32) {
        return Roles.ADMIN_ROLE;
    }

    /**
     * @notice Returns standard OPERATOR_ROLE bytes32 value
     * @return bytes32 role identifier
     */
    function OPERATOR_ROLE() public pure returns (bytes32) {
        return Roles.OPERATOR_ROLE; 
    }

    // ============ INTERNAL FUNCTIONS ============

    /**
    * @dev Processes an investment in an invoice
    * @notice Internal function handling token minting and accounting
    * @param invoiceId ID of the invoice being invested in
    * @param amount Actual investment amount after fees
    * @param investor Address of the investor
    */
    function _processInvestment(uint256 invoiceId, uint256 amount, address investor) internal {
        IInvoiceToken.Invoice storage invoice = invoices[invoiceId];
        uint256 shares = amount.calculateShares(invoice.details.amount);
        totalInvestedAmounts += amount;
        
        _mint(investor, invoiceId, shares, "");
        investorShares[invoiceId][investor] += shares;
        
        if (investorShares[invoiceId][investor] == shares) {
            investorInvoices[investor].add(invoiceId);
            invoiceInvestors[invoiceId].add(investor);
        }
        
        invoice.financials.totalSupply += amount;
        invoice.financials.collectedAmount += amount;

        emit Invested(invoiceId, investor, amount, 0);
    }

    /**
    * @dev Initializes a new collateral structure
    * @notice Uses default rates from contract storage
    * @return Collateral struct with default rates
    */
    function _initCollateral() private view returns (IInvoiceToken.Collateral memory) {
        return IInvoiceToken.Collateral({
            initialDeposit: 0,
            withheldAmount: 0,
            totalAmount: 0,
            isStaked: false,
            isReleased: false,
            isWithdrawable: false,
            stakingPlatform: address(0),
            stakingContract: address(0),
            stakedAmount: 0,
            rates: defaultCollateralRates
        });
    }

    /**
    * @dev Validates conditions for investor compensation
    * @notice Checks invoice status, dates, and collateral
    * @param invoiceId ID of invoice to validate
    * @custom:reverts InvalidStatus if invoice doesn't exist
    * @custom:reverts DeadlineNotPassed if not yet due
    * @custom:reverts InvoiceAlreadyPaid if already repaid
    * @custom:reverts NoCollateral if no collateral available
    */
    function _validateCompensation(uint256 invoiceId) private view {
    
        if (invoices[invoiceId].details.invoiceId != invoiceId) {
            revert InvalidStatus();
        }

        IInvoiceToken.Invoice storage invoice = invoices[invoiceId];
        IInvoiceToken.Collateral storage collateral = invoiceCollaterals[invoiceId];

        if (block.timestamp <= invoice.details.dueDate) {
            revert DeadlineNotPassed();
        }

        if (invoice.financials.isPaid) {
            revert InvoiceAlreadyPaid();
        }

        if (collateral.totalAmount == 0) {
            revert NoCollateral();
        }

        if (collateral.isReleased) {
            revert CollateralAlreadyReleased();
        }

        if (invoiceInvestors[invoiceId].length() == 0) {
            revert InvalidStatus();
        }
        
    }

    /**
    * @dev Calculates distribution amounts for compensation
    * @notice Handles surplus return and fee calculations
    * @param invoiceId ID of defaulted invoice
    * @return amountDistributed Total to distribute to investors
    * @return performanceFee Calculated platform fee
    */
    function _calculateDistribution(uint256 invoiceId) private returns (uint256 amountDistributed, uint256 performanceFee) {
        IInvoiceToken.Invoice storage invoice = invoices[invoiceId];
        IInvoiceToken.Collateral storage collateral = invoiceCollaterals[invoiceId];

        uint256 surplus = collateral.totalAmount > invoice.financials.collectedAmount 
            ? collateral.totalAmount - invoice.financials.collectedAmount 
            : 0;
        
        if (surplus > 0) {
            stablecoinToken.safeTransfer(invoice.details.company, surplus);
            collateral.totalAmount -= surplus;
        }

        uint256 interest = invoice.financials.interestWithheld;
        performanceFee = (interest * commissionRates.performanceFee) / 10000;
        uint256 netInterest = interest - performanceFee;
        amountDistributed = collateral.totalAmount + netInterest;

    }

    /**
    * @dev Distributes collateral to investors proportionally
    * @notice Burns investor shares after distribution
    * @param invoiceId ID of compensated invoice
    * @param amountDistributed Total amount being distributed
    * @custom:emits InvestorCompensated for each investor
    */
    function _distributeToInvestors(uint256 invoiceId, uint256 amountDistributed) private {
        address[] memory investors = invoiceInvestors[invoiceId].values();
        
        for (uint256 i = 0; i < investors.length; i++) {
            address investor = investors[i];
            uint256 shares = investorShares[invoiceId][investor];
            
            if (shares > 0) {
                uint256 amount = (amountDistributed * shares) / PERCENTAGE_BASE;
                
                if (amount > 0) {
                    stablecoinToken.safeTransfer(investor, amount);
                    
                    _burn(investor, invoiceId, shares);
                    
                    emit InvestorCompensated(invoiceId, investor, amount);
                }
                
                delete investorShares[invoiceId][investor];
                investorInvoices[investor].remove(invoiceId);
            }
        }
    }

    /**
    * @dev Finalizes compensation process
    * @notice Handles fee transfers and state updates
    * @param invoiceId ID of processed invoice
    * @param amountDistributed Total amount distributed
    * @param performanceFee Platform fee amount
    * @custom:emits CompensationCompleted
    */
    function _finalizeCompensation(uint256 invoiceId, uint256 amountDistributed, uint256 performanceFee) private {
        IInvoiceToken.Invoice storage invoice = invoices[invoiceId];
        IInvoiceToken.Collateral storage collateral = invoiceCollaterals[invoiceId];

        if (performanceFee > 0) {
            stablecoinToken.safeTransfer(feeTreasury, performanceFee);
        }

        invoice.financials.isPaid = true;
        invoice.financials.repaymentAmount = amountDistributed;
        collateral.isReleased = true;
        collateral.totalAmount = 0;

        emit InvestorsCompensated(invoiceId, amountDistributed);
    }

    // ============ TIMELOCK IMPLEMENTATION ============

    /**
    * @dev Initiates a timelocked operation
    * @notice Stores execution timestamp for future validation
    * @param operationId Unique identifier for the operation
    * @custom:reverts TimelockAlreadyStarted if operation exists
    * @custom:emits TimelockStarted
    */
    function _startTimelock(bytes32 operationId) internal {
        if (_timelocks[operationId] != 0) {
            revert TimelockAlreadyStarted();
        }
        _timelocks[operationId] = block.timestamp + TIMELOCK_DURATION;
        emit TimelockStarted(operationId, _timelocks[operationId]);
    }

    /**
    * @dev Validates timelock expiration
    * @notice Checks if waiting period has elapsed
    * @param operationId ID of timelocked operation
    * @custom:reverts TimelockNotStarted if operation not found
    * @custom:reverts TimelockNotExpired if period not passed
    */
    function _checkTimelock(bytes32 operationId) internal view {
        if (_timelocks[operationId] == 0) {
            revert TimelockNotStarted();
        }
        if (block.timestamp < _timelocks[operationId]) {
            revert TimelockNotExpired();
        }
    }

    // ============ OVERRIDES ============

    /**
    * @notice ERC1155 metadata URI getter
    * @dev Overrides standard ERC1155 URI function
    * @param invoiceId Token ID (matches invoiceId)
    * @return metadataURI Associated metadata URI
    */
    function uri(uint256 invoiceId) public view override returns (string memory) {
        return invoices[invoiceId].details.metadataURI;
    }

    /**
    * @notice Returns pool metadata URI
    * @param poolId Pool to query
    * @return metadataURI String of pool metadata
    */
    function getPoolURI(uint256 poolId) external view returns (string memory) {
        return pools[poolId].metadataURI;
    }

    /**
    * @notice ERC165 interface support check
    * @dev Combines ERC1155 and AccessControl support checks
    * @param interfaceId Interface identifier
    * @return bool Whether interface is supported
    */
    function supportsInterface(bytes4 interfaceId) public view override(ERC1155Upgradeable, AccessControlUpgradeable) returns (bool) {
        return super.supportsInterface(interfaceId);
    }
} 
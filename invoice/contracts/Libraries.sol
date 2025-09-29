// SPDX-License-Identifier: MIT
pragma solidity ^0.8.27;

import "./Interfaces.sol";

/**
 * @title InvoiceCalculations - Financial math utilities
 * @notice Provides safe calculation methods for invoice financing operations
 * @dev All functions are pure and perform overflow-safe arithmetic
 */
library InvoiceCalculations {

    /**
     * @notice Calculates investor shares from investment amount
     * @dev Shares are represented with 18 decimal places (1e18 = 100%)
     * @param investment Amount invested in stablecoin units
     * @param totalAmount Total invoice amount in same units
     * @return uint256 Share percentage scaled by 1e18
     * @custom:reverts On division by zero if totalAmount is 0
     * 
     * @dev Example:
     * - Investment 1000, Total 5000 => Returns 2e17 (20%)
     */
    function calculateShares(uint256 investment, uint256 totalAmount) internal pure returns (uint256) {
        return (investment * 1e18) / totalAmount;
    }
    
    /**
     * @notice Computes fee amount from base value
     * @dev Fee rates use basis points (10000 = 100%)
     * @param amount Base amount to calculate fee from
     * @param feeRate Fee percentage in basis points
     * @return uint256 Fee amount in same units as input
     * 
     * @dev Example:
     * - Amount 1000, Fee 50 (0.5%) => Returns 5
     */
    function calculateFee(uint256 amount, uint256 feeRate) internal pure returns (uint256) {
        return (amount * feeRate) / 10000;
    }
    
     /**
     * @notice Calculates simple interest on principal
     * @dev Uses annual rate in basis points (10000 = 100%)
     * @param principal Base loan amount
     * @param rate Annual interest rate in basis points
     * @return uint256 Interest amount in same units as principal
     * 
     * @dev Example:
     * - Principal 10000, Rate 500 (5%) => Returns 500
     */
    function calculateInterest(uint256 principal, uint256 rate) internal pure returns (uint256) {
        return (principal * rate) / 10000;
    }
}

/**
 * @title PoolLib - Pool management utilities
 * @notice Provides validation logic for invoice pools
 * @dev All functions are pure and stateless
 */
library PoolLib {

    /**
     * @notice Validates if invoice can be added to pool
     * @dev Checks pool status, capacity and invoice eligibility
     * @param pool Pool storage structure
     * @param invoice Invoice to validate
     * @param maxPoolAmount System-wide pool size limit (0 = unlimited)
     * @param maxInvoiceCount System-wide invoice limit (0 = unlimited)
     * @return bool True if invoice can be added under all constraints
     * 
     * @dev Checks:
     * 1. Pool active status
     * 2. Invoice not already in another pool
     * 3. Invoice not paid
     * 4. Pool invoice capacity
     * 5. Pool amount capacity
     */
    function canAddInvoice(
        IInvoiceToken.Pool memory pool,
        IInvoiceToken.Invoice memory invoice,
        uint256 maxPoolAmount,
        uint256 maxInvoiceCount
    ) internal pure returns (bool) {
        if (!pool.isActive) return false;
        if (invoice.references.poolId != 0) return false;
        if (invoice.financials.isPaid) return false;
        if (maxInvoiceCount > 0 && pool.invoiceIds.length >= maxInvoiceCount) return false;
        if (maxPoolAmount > 0 && pool.totalAmount + invoice.details.amount > maxPoolAmount) return false;
        return true;
    }
}
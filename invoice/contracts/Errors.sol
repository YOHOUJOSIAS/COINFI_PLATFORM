// SPDX-License-Identifier: MIT
pragma solidity ^0.8.27;

// Access Control Errors
error Unauthorized(); // When caller lacks required role/permissions
error InvalidAddress(); // When zero address or invalid EOA/contract address provided

// Parameter Validation Errors
error InvalidAmount(); // When amount is zero or outside acceptable bounds
error InvalidStatus(); // When contract/invoice/pool is in unexpected state

// Timing Errors
error DeadlinePassed(); // When action is attempted after deadline
error DeadlineNotPassed(); // When action requires deadline to be passed but isn't
error TooEarlyToRelease(); // When collateral release is attempted before lock period
error FundingPeriodEnded(); // When funding window has closed

// Financial Errors
error InsufficientFunds(); // When balance/allowance is less than required
error InvestmentTooSmall(); // When investment below minimum threshold
error AlreadyFullyFunded(); // When invoice has reached maximum funding
error InvestmentFailed(); // When pool investment couldn't be fully allocated

// Invoice Lifecycle Errors
error InvoiceNotActive(); // When invoice isn't in activatable state
error InvoiceAlreadyPaid(); // When invoice has already been repaid
error InvoiceNotEligibleForPool(); // When invoice can't be added to pool

// Collateral Errors
error NoCollateral(); // When operation requires collateral but none exists
error CollateralNotDeposited(); // When required collateral wasn't deposited
error CollateralAlreadyReleased(); // When collateral was already returned

// Pool Errors
error PoolNotActive(); // When pool is inactive
error PoolFull(); // When pool has reached capacity
error PoolExpired(); // When pool duration has ended

// Timelock Errors
error TimelockAlreadyStarted(); // When timelock operation was already initiated
error TimelockNotStarted(); // When timelock doesn't exist for operation
error TimelockNotExpired(); // When timelock period hasn't completed

// Token Errors
error SameToken(); // When new token address matches current token
error InvalidToken(); // When token contract doesn't meet requirements
// SPDX-License-Identifier: MIT
pragma solidity ^0.8.27;

import "@openzeppelin/contracts/access/AccessControl.sol";

/**
 * @title Roles - Access Control Definitions
 * @notice Provides standardized role definitions and validation utilities
 * @dev Centralizes role management to maintain consistency across contracts
 */
library Roles {
    /**
     * @notice Administrator role identifier
     * @dev Grants privileged access to system configuration
     * @return bytes32 keccak256 hash of "ADMIN_ROLE"
     * 
     * @custom:permissions Allows:
     * - System parameter updates
     * - Emergency interventions
     * - Role management
     */
    bytes32 public constant ADMIN_ROLE = keccak256("ADMIN_ROLE");

    /**
     * @notice Operator role identifier
     * @dev Grants day-to-day operational permissions
     * @return bytes32 keccak256 hash of "OPERATOR_ROLE"
     * 
     * @custom:permissions Allows:
     * - Pool management
     * - Invoice listing
     * - Routine operations
     */
    bytes32 public constant OPERATOR_ROLE = keccak256("OPERATOR_ROLE");
    
    /**
     * @notice Validates admin privileges
     * @dev Reverts with message if account lacks ADMIN_ROLE
     * @param account Address to verify
     * @param accessControl AccessControl contract instance
     * 
     * @custom:reverts With "Caller is not admin" if role check fails
     * @custom:usage Used for sensitive administrative functions
     */
    function requireAdmin(address account, AccessControl accessControl) internal view {
        require(accessControl.hasRole(ADMIN_ROLE, account), "Caller is not admin");
    }
    
    /**
     * @notice Validates operator privileges
     * @dev Reverts with message if account lacks OPERATOR_ROLE
     * @param account Address to verify
     * @param accessControl AccessControl contract instance
     * 
     * @custom:reverts With "Caller is not operator" if role check fails
     * @custom:usage Used for operational maintenance functions
     */
    function requireOperator(address account, AccessControl accessControl) internal view {
        require(accessControl.hasRole(OPERATOR_ROLE, account), "Caller is not operator");
    }
}
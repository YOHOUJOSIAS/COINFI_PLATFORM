require("@nomicfoundation/hardhat-toolbox");
require("@openzeppelin/hardhat-upgrades");
require("dotenv").config();

/** @type import('hardhat/config').HardhatUserConfig */
module.exports = {
   solidity: {
    version: "0.8.27",
    settings: {
      optimizer: {
        enabled: true,
        runs: 200
      },
      viaIR: true 
    }
  },
  networks: {
    // Hedera Testnet Setup
    hederaTestnet: {
      url: process.env.NETWORK_RPC || "https://testnet.hashio.io/api",
      accounts: process.env.PRIVATE_KEY ? [process.env.PRIVATE_KEY] : [],
      chainId: process.env.CHAIN_ID_INT ? parseInt(process.env.CHAIN_ID_INT) : 296,
      gas: "auto",
      gasPrice: "auto",
      timeout: 60000,
    },
    
    // Configuration du réseau principal Hedera (commenté)
    // hederaMainnet: {
    //   url: process.env.NETWORK_RPC || "https://mainnet.hashio.io/api",
    //   accounts: process.env.PRIVATE_KEY ? [process.env.PRIVATE_KEY] : [],
    //   chainId: process.env.CHAIN_ID_INT ? parseInt(process.env.CHAIN_ID_INT) : 295,
    //   gas: "auto",
    //   gasPrice: "auto",
    //   timeout: 60000,
    // },
  },
  etherscan: {
    apiKey: {
      hederaTestnet: process.env.NETWORK_EXPLORER,
    },
  },
  paths: {
    sources: "./contracts",
    tests: "./test",
    cache: "./cache",
    artifacts: "./artifacts"
  },
  mocha: {
    timeout: 40000
  }
};
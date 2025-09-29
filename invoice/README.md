# NETWORK USED***********
Hedera testnet

# ENVIRONMENT VARIABLES TO SET IN .env FILE******
# HEDERA**************************
CHAIN_ID=0x128 # 296 in decimal
CHAIN_ID_INT=296
NETWORK_NAME="Hedera Testnet"
NETWORK_EXPLORER=https://hashscan.io/testnet
NETWORK_RPC=https://testnet.hashio.io/api

# Blockchain Configuration (Mainnet)
CHAIN_ID=0x127 # 295 in decimal
NETWORK_NAME=Hedera Mainnet
NETWORK_EXPLORER=https://hashscan.io
RPC_URL=https://mainnet.hashio.io/api
# Private key
PRIVATE_KEY=78676Y...............

# MODULES************************************************************
Create the project: invoice_contract in this case

Initialize Node.js project: npm init -y

Install Hardhat: npm install --save-dev hardhat

Initialize Hardhat: npx hardhat
or
: npx hardhat init

Install useful Hardhat plugins: npm install --save-dev @nomicfoundation/hardhat-toolbox dotenv

Install useful Hardhat plugins: npm install --save-dev dotenv

Start Hardhat node: npx hardhat node

Install OpenZeppelin Contracts: 
: npm install @openzeppelin/contracts@4.9.6
: npm install ethers


# COMMANDS******************************************************
Install dependencies : npm install
Compile with Hardhat: npx hardhat compile

# IF YOU SET UP THE DEPLOYMENT SCRIPT IN PACKAGE.JSON LIKE THIS: "deploy": "npx hardhat run scripts/deploy.js --network hederaTestnet && npx hardhat run scripts/copyABIs.js", run the following command to deploy contracts and copy-paste ABIs to the frontend (CodeIgniter). The ABIs are easily accessible in the contracts-abi/InvoiceToken.abi.json file for the invoice token smart contract and contracts-abi/Usdt.abi.json for the USDT test smart contract. These are the two ABIs needed in the frontend code:
npm run deploy

# IF YOU DIDN'T SET UP THE DEPLOYMENT SCRIPT IN PACKAGE.JSON, run the following command to deploy the NFT and marketplace smart contracts:
npx hardhat run scripts/deploy.js --network hederaTestnet

# AND RUN THE FOLLOWING TO COPY-PASTE ABIs TO contracts-abi/InvoiceToken.abi.json for the invoice token smart contract and contracts-abi/Usdt.abi.json for the USDT test smart contract:
npx hardhat run scripts/copyABIs.js

# NB: YOU MUST COPY THE SMART CONTRACT ADDRESSES FROM THE TERMINAL OR FROM THE SCRIPTS/deployment-******.json FILE AFTER DEPLOYING THEM TO UPDATE THEIR RESPECTIVE VARIABLES IN THE FRONTEND'S .env FILE


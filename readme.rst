###################
What is CodeIgniter
###################

CodeIgniter is an Application Development Framework - a toolkit - for people
who build web sites using PHP. Its goal is to enable you to develop projects
much faster than you could if you were writing code from scratch, by providing
a rich set of libraries for commonly needed tasks, as well as a simple
interface and logical structure to access these libraries. CodeIgniter lets
you creatively focus on your project by minimizing the amount of code needed
for a given task.

*******************
Release Information
*******************

This repo contains in-development code for future releases. To download the
latest stable release please visit the `CodeIgniter Downloads
<https://codeigniter.com/download>`_ page.

**************************
Changelog and New Features
**************************

You can find a list of all changes for each release in the `user
guide change log <https://github.com/bcit-ci/CodeIgniter/blob/develop/user_guide_src/source/changelog.rst>`_.

*******************
Server Requirements
*******************

PHP version 5.6 or newer is recommended.

It should work on 5.3.7 as well, but we strongly advise you NOT to run
such old versions of PHP, because of potential security and performance
issues, as well as missing features.

************
Installation
************

Please see the `installation section <https://codeigniter.com/userguide3/installation/index.html>`_
of the CodeIgniter User Guide.

*******
License
*******

Please see the `license
agreement <https://github.com/bcit-ci/CodeIgniter/blob/develop/user_guide_src/source/license.rst>`_.

*********
Resources
*********

-  `User Guide <https://codeigniter.com/docs>`_
-  `Contributing Guide <https://github.com/bcit-ci/CodeIgniter/blob/develop/contributing.md>`_
-  `Language File Translations <https://github.com/bcit-ci/codeigniter3-translations>`_
-  `Community Forums <http://forum.codeigniter.com/>`_
-  `Community Wiki <https://github.com/bcit-ci/CodeIgniter/wiki>`_
-  `Community Slack Channel <https://codeigniterchat.slack.com>`_

Report security issues to our `Security Panel <mailto:security@codeigniter.com>`_
or via our `page on HackerOne <https://hackerone.com/codeigniter>`_, thank you.

***************
Acknowledgement
***************

The CodeIgniter team would like to thank EllisLab, all the
contributors to the CodeIgniter project and you, the CodeIgniter user.



##************************.ENV*******************************************************

# ======================
# ENVIRONMENT SETTINGS
# ======================
ENVIRONMENT=development  # [development|staging|production]
APP_NAME=CoinFinance
APP_VERSION=1.0.0
APP_DEBUG=true
APP_TIMEZONE=UTC

# ======================
# DATABASE CONFIGURATION
# ======================
DB_HOSTNAME=localhost
DB_USERNAME=root
DB_PASSWORD=
DB_DATABASE=coinfinance_db
DB_PORT=3306
DB_CHARSET=utf8mb4

# ======================
# HEDERA BLOCKCHAIN CONFIG
# ======================

# ------ TESTNET ------
CHAIN_ID=0x128  # Hex (296 in decimal)
CHAIN_ID_INT=296
NETWORK_NAME="Hedera Testnet"
NETWORK_EXPLORER=https://hashscan.io/testnet
NETWORK_RPC=https://testnet.hashio.io/api

# ------ MAINNET ------
# CHAIN_ID=0x127  # Hex (295 in decimal)
# CHAIN_ID_INT=295
# NETWORK_NAME="Hedera Mainnet"
# NETWORK_EXPLORER=https://hashscan.io
# NETWORK_RPC=https://mainnet.hashio.io/api

# Native currency (HBAR)
NATIVE_CURRENCY_NAME=HBAR
NATIVE_CURRENCY_SYMBOL=HBAR
NATIVE_CURRENCY_DECIMALS=8  # Hedera uses 8 decimals for HBAR

# ======================
# SMART CONTRACT ADDRESSES
# ======================
# Testnet Contracts
INVOICE_TOKEN_ADDRESS=0xa8Fa794E11F694b1D8A43C92296486e13a9e3043
CFN_TOKEN_ADDRESS=0x4E8Df0C99c8f2290cf81Ce8dfE4c0f4bb569DfaC
USDT_TOKEN_ADDRESS=0x00000000000000000000000000000000001691B4  # Hedera's testnet USDT

# Mainnet Contracts (example)
# INVOICE_TOKEN_ADDRESS=0x...
# CFN_TOKEN_ADDRESS=0x...
# USDT_TOKEN_ADDRESS=0x...

# ======================
# IPFS CONFIGURATION (Pinata)
# ======================
PINATA_API_KEY=your_pinata_api_key
PINATA_SECRET_API_KEY=your_pinata_secret_key
PINATA_JWT=your_pinata_jwt
IPFS_GATEWAY=https://gateway.pinata.cloud/ipfs/

# ======================
# WALLET AUTHENTICATION
# ======================
# Magic Link
MAGIC_LINK_API_KEY=pk_live_your_key
MAGIC_SECRET_KEY=sk_live_your_secret

# WalletConnect Project ID
WALLET_CONNECT_PROJECT_ID=your_walletconnect_id

# ======================
# EMAIL CONFIGURATION
# ======================
MAIL_DRIVER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD="your_app_password"
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="CoinFinance"

# ======================
# SECURITY SETTINGS
# ======================
JWT_SECRET=your_jwt_secret_key_here
ENCRYPTION_KEY=your_32_char_encryption_key
CSRF_PROTECTION=true
CSRF_TOKEN_NAME=ci_csrf_token

# ======================
# TRANSACTION DEFAULTS
# ======================
DEFAULT_GAS_LIMIT=3000000
DEFAULT_GAS_PRICE=20000000000  # 20 Gwei
MAX_PRIORITY_FEE=2000000000    # 2 Gwei
TRANSACTION_TIMEOUT=60000      # 60 seconds

# ======================
# CACHE & SESSION
# ======================
CACHE_DRIVER=file              # [file|redis|memcached]
CACHE_PREFIX=cf_
SESSION_DRIVER=file
SESSION_LIFETIME=120           # Minutes
SESSION_COOKIE_NAME=ci_session

# ======================
# FILE UPLOADS
# ======================
MAX_FILE_SIZE=10485760         # 10MB
ALLOWED_FILE_TYPES=jpg,jpeg,png,pdf,doc,docx
UPLOAD_PATH=./uploads/

# ======================
# RATE LIMITING
# ======================
RATE_LIMIT_REQUESTS=100
RATE_LIMIT_MINUTES=1
API_THROTTLE_LIMIT=60

# ======================
# EXTERNAL APIs
# ======================
COINGECKO_API_URL=https://api.coingecko.com/api/v3
EXCHANGE_RATE_API=https://api.exchangerate.host

# ======================
# FRONTEND SETTINGS
# ======================
ASSET_VERSION=1.0.0
GOOGLE_ANALYTICS_ID=UA-XXXXX-Y
RECAPTCHA_SITE_KEY=your_site_key
RECAPTCHA_SECRET_KEY=your_secret_key

# ======================
# TESTING
# ======================
TEST_PRIVATE_KEY=0x0000000000000000000000000000000000000000000000000000000000000001
TEST_ACCOUNT_ADDRESS=0x0000000000000000000000000000000000000001


*************CREATE YOUR PINATA ACCOUNT***************
https://app.pinata.cloud/signup
Create a new API key and secret key for this project.


#****************START SERVER*****************************
php -S localhost:8000

Link => http://localhost:8000/

## Testnet Faucet Hedera
Lien : https://portal.hedera.com/faucet 

#****************END SERVER********************************
Project Description

Coinfinance is a platform dedicated to managing and monitoring finances for SMEs.

It centralizes information related to invoices, payments, crypto wallets, and other financial indicators, while offering a modern, user-friendly, and responsive interface.

Project Objectives

- Simplify financial management for small and medium-sized enterprises.

- Offer easy integration with crypto wallets (MetaMask).

- Provide a clear and visually appealing dashboard with interactive charts.

- Enhance the transparency and traceability of transactions.

Stack Technique:

CodeIgniter 3 + PHP 8 + MySQL + Bootstrap 5 + MetaMask + Web3.js

Installation and Configuration Steps

1- Clone the project (git clone https://github.com/your-username/coinfinance.git)
2- Then navigate to the project folder: cd coinfinance
3- Configure the local environment

Ensure you have installed the following tools:
PHP ​​≥ 7.4
MySQL ≥ 5.7
Apache or Nginx (for example, via XAMPP, Laragon, or WAMP)
Composer (to manage PHP dependencies, if necessary)

4- Create the database

Open phpMyAdmin or your preferred MySQL client.

Create a new database (for example, coinfinance_db):

CREATE DATABASE coinfinance_db CHARACTERSET utf8mb4 COLLATE utf8mb4_unicode_ci;

Then import the database into phpMyAdmin.

5- CodeIgniter Configurator

In the application/config/config.php folder, enter the launch URL: $config['base_url'] = 'http://localhost/coinfinance/';

In the application/config/database.php file, update the environment: `$db['default'] = array(
'dsn' => '',
'hostname' => 'localhost',
'username' => 'root', // default username is root
'password' => '',
'database' => 'coinfinance_db', // database name
'dbdriver' => 'mysqli',
'dbprefix' => '',
'pconnect' => FALSE,
'db_debug' => (ENVIRONMENT !== 'production'),

);`

6- Start the local server

If you are using XAMPP or Laragon, place the project in the htdocs or www folder.

Next, start your Apache and MySQL servers, then visit: http://localhost/coinfinance/

7- Install & configure MetaMask and Web3

If your project interacts with the blockchain:

- Install the MetaMask extension in your browser.

- Connect your wallet to your website.

- Verify that the web3.min.js script or the initializeWallet() function is correctly loaded in your JS files.

- Test the connection using the designated button or JavaScript event.

CERTIFICAT LINK  : https://certs.hashgraphdev.com/89d7e7a7-58d0-43cb-b0be-2a2b8286001b.pdf 

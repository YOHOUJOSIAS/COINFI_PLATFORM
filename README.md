Description du projet

Coinfinance est une plateforme dédiée à la gestion et au suivi des finances pour les PME.
Elle permet de centraliser les informations liées aux factures, paiements, portefeuilles crypto, et autres indicateurs financiers, tout en offrant une interface moderne, fluide et responsive.

Objectifs du projet

- Simplifier la gestion financière pour les petites et moyennes entreprises.
- Offrir une intégration facile avec des portefeuilles crypto (MetaMask).
- Fournir un tableau de bord clair et esthétique avec des graphiques interactifs.
- Renforcer la transparence et la traçabilité des transactions.

Stack technique : 

CodeIgniter 3 + PHP 8 + MySQL + Bootstrap 5 + MetaMask + Web3.js



Étapes d’installation et de configuration

1- Cloner le projet ( git clone https://github.com/votre-utilisateur/coinfinance.git )
2- Puis entre dans le dossier du projet : cd coinfinance 
3- Configurer l’environnement local

Assurez-vous d’avoir installé les outils suivants :
PHP ≥ 7.4
MySQL ≥ 5.7
Apache ou Nginx (par exemple via XAMPP, Laragon ou WAMP)
Composer (pour gérer les dépendances PHP, si nécessaire)


4- Créer la base de données

Ouvre phpMyAdmin ou ton client MySQL préféré.

Crée une nouvelle base de données (par exemple coinfinance_db) :

CREATE DATABASE coinfinance_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci; 
ensuite vous importez la base de donnée dans PhpMyAdmin


5- Configurer CodeIgniter 

dans le dossier application/config/config.php mettez l'url de lancement $config['base_url'] = 'http://localhost/coinfinance/';
dans le dossier application/config/database.php  mettez à jour l'environement $db['default'] = array(
    'dsn'   => '',
    'hostname' => 'localhost',
    'username' => 'root',  // par defaut le username est root
    'password' => '',
    'database' => 'coinfinance_db',   // le nom de la base de donnée
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => (ENVIRONMENT !== 'production'),
);


6- Lancer le serveur local

 Si tu utilises XAMPP ou Laragon, place le projet dans le dossier htdocs ou www.

Ensuite, démarre ton serveur Apache et MySQL, puis visite : http://localhost/coinfinance/' 


7-  Installer & configurer MetaMask et Web3

Si ton projet interagit avec la blockchain :
- Installe l’extension MetaMask dans ton navigateur.
- Connecte ton portefeuille à ton site.
- Vérifie que le script web3.min.js ou l’initialisation initializeWallet() est bien chargée dans tes fichiers JS.
- Teste la connexion via le bouton ou l’événement JavaScript prévu.

<?php

class Config
{
    // Paramètres pour la connexion à la base de données
    private static $pdo = null;
    private static $host = 'localhost';
    private static $dbname = 'projetweb';
    private static $user = 'root';
    private static $password = '';

    // Paramètres pour la configuration du paiement
    private static $paymentApiUrl = 'https://api.paymentgateway.com';  // URL de l'API de paiement
    private static $paymentApiKey = 'your_api_key_here';  // Clé API pour l'authentification
    private static $paymentEnvironment = 'test'; // Environnement de l'API (test ou production)

    /**
     * Retourne l'instance PDO pour la connexion à la base de données
     * @return PDO
     */
    public static function getConnexion()
    {
        if (!isset(self::$pdo)) {
            try {
                self::$pdo = new PDO(
                    'mysql:host=' . self::$host . ';dbname=' . self::$dbname,
                    self::$user,
                    self::$password,
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Gestion des erreurs
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC // Mode de récupération par défaut
                    ]
                );
            } catch (PDOException $e) {
                // Enregistrement des erreurs dans un fichier log
                error_log("Erreur de connexion : " . $e->getMessage(), 3, 'logs/db_errors.log');
                die('Erreur de connexion à la base de données.');
            }
        }
        return self::$pdo;
    }

    /**
     * Permet de changer les paramètres de connexion à la base de données
     * @param string $host
     * @param string $dbname
     * @param string $user
     * @param string $password
     */
    public static function setConfig($host, $dbname, $user, $password)
    {
        self::$host = $host;
        self::$dbname = $dbname;
        self::$user = $user;
        self::$password = $password;
    }

    /**
     * Retourne les informations de connexion pour le service de paiement
     * @return array
     */
    public static function getPaymentConfig()
    {
        return [
            'api_url' => self::$paymentApiUrl,
            'api_key' => self::$paymentApiKey,
            'environment' => self::$paymentEnvironment
        ];
    }

    /**
     * Permet de changer les paramètres pour le service de paiement
     * @param string $apiUrl
     * @param string $apiKey
     * @param string $environment
     */
    public static function setPaymentConfig($apiUrl, $apiKey, $environment)
    {
        self::$paymentApiUrl = $apiUrl;
        self::$paymentApiKey = $apiKey;
        self::$paymentEnvironment = $environment;
    }
}

// Exemple d'utilisation pour changer la configuration de la base de données
// Config::setConfig('new_host', 'new_db', 'new_user', 'new_password');

// Exemple d'utilisation pour récupérer la configuration de la base de données
$dbConnection = Config::getConnexion();

// Exemple d'utilisation pour changer la configuration de paiement
Config::setPaymentConfig('https://api.newpaymentgateway.com', 'new_api_key', 'production');

// Exemple d'utilisation pour récupérer la configuration de paiement
$paymentConfig = Config::getPaymentConfig();
echo "API URL: " . $paymentConfig['api_url'];
echo "API Key: " . $paymentConfig['api_key'];
echo "Environment: " . $paymentConfig['environment'];
?>

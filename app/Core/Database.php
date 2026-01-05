<?php

namespace Mini\Core;

use PDO;

/**
 * Classe Database - Gestion de la connexion à la base de données
 * Utilise le pattern Singleton pour une seule instance
 */
class Database
{
    /** @var PDO|null */
    private ?PDO $dbh = null;
    
    /** @var Database|null */
    private static ?Database $_instance = null;

    /**
     * Constructeur privé - Pattern Singleton
     */
    private function __construct()
    {
        // Récupération des données du fichier de configuration
        $configData = parse_ini_file(dirname(__DIR__) . '/config.ini');

        try {
            // Connexion à PostgreSQL
            $dsn = "pgsql:host={$configData['DB_HOST']};port={$configData['DB_PORT']};dbname={$configData['DB_NAME']}";
            
            $this->dbh = new PDO(
                $dsn,
                $configData['DB_USERNAME'],
                $configData['DB_PASSWORD'],
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]
            );
        } catch (\PDOException $exception) {
            echo 'Erreur de connexion à la base de données...<br>';
            echo $exception->getMessage() . '<br>';
            exit;
        }
    }

    /**
     * Récupère l'instance PDO - Pattern Singleton
     * @return PDO
     */
    public static function getPDO(): PDO
    {
        if (self::$_instance === null) {
            self::$_instance = new Database();
        }
        return self::$_instance->dbh;
    }
}

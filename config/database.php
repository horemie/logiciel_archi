<?php

class Database
{
    private $host = "localhost";
    private $dbname = "gestion_hospital";
    private $username = "root";
    private $password = "";

    public $connexion;

    public function connecter()
    {
        $this->connexion = null;

        try {

            $this->connexion = new PDO(
                "mysql:host={$this->host};dbname={$this->dbname};charset=utf8",
                $this->username,
                $this->password
            );

            // Gestion des erreurs
            $this->connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Retour des résultats sous forme de tableau associatif
            $this->connexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            // Désactivation de l'émulation des requêtes préparées
            $this->connexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        } catch (PDOException $e) {

            die("Erreur de connexion : " . $e->getMessage());

        }

        return $this->connexion;
    }
}

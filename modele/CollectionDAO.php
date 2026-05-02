<?php
require_once __DIR__ . "/../config/Database.php";
require_once __DIR__ . "/Collection.php";
require_once __DIR__ . "/Jeu.php";

class CollectionDAO {

    /* ================================
       RÉCUPÉRER TOUTES LES COLLECTIONS
       ================================ */
    public static function getAll() {
        $pdo = connexionPDO();
        $sql = "SELECT idCollection, nomCollection, dateCreation, notePerso, idUtilisateur 
                FROM Collection 
                ORDER BY dateCreation DESC";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $collections = [];
        foreach ($rows as $r) {
            $collections[] = new Collection(
                $r['idCollection'],
                $r['nomCollection'],
                $r['dateCreation'],
                $r['notePerso'],
                $r['idUtilisateur']
            );
        }
        return $collections;
    }

    /* ================================
       RÉCUPÉRER UNE COLLECTION PAR ID
       ================================ */
    public static function getById($id) {
        $pdo = connexionPDO();
        $sql = "SELECT idCollection, nomCollection, dateCreation, notePerso, idUtilisateur 
                FROM Collection 
                WHERE idCollection = :id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $r = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($r) {
            return new Collection(
                $r['idCollection'],
                $r['nomCollection'],
                $r['dateCreation'],
                $r['notePerso'],
                $r['idUtilisateur']
            );
        }
        return null;
    }

    /* ================================
       RÉCUPÉRER LES COLLECTIONS PAR UTILISATEUR
       ================================ */
    public static function getByUser($idUtilisateur) {
        $pdo = connexionPDO();
        $sql = "SELECT idCollection, nomCollection, dateCreation, notePerso, idUtilisateur 
                FROM Collection 
                WHERE idUtilisateur = :uid 
                ORDER BY dateCreation DESC";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':uid', $idUtilisateur, PDO::PARAM_INT);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $collections = [];
        foreach ($rows as $r) {
            $collections[] = new Collection(
                $r['idCollection'],
                $r['nomCollection'],
                $r['dateCreation'],
                $r['notePerso'],
                $r['idUtilisateur']
            );
        }
        return $collections;
    }

    /* ================================
       INSERTION D'UNE COLLECTION
       ================================ */
    public static function insert($nomCollection, $idUtilisateur, $notePerso = null) {
        $pdo = connexionPDO();

        $dateCreation = date('Y-m-d');

        $sql = "INSERT INTO Collection (nomCollection, dateCreation, notePerso, idUtilisateur) 
                VALUES (:nom, :dateCreation, :note, :uid)";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':nom', $nomCollection, PDO::PARAM_STR);
        $stmt->bindValue(':dateCreation', $dateCreation, PDO::PARAM_STR);
        $stmt->bindValue(':note', $notePerso, PDO::PARAM_STR);
        $stmt->bindValue(':uid', $idUtilisateur, PDO::PARAM_INT);

        $ok = $stmt->execute();
        if ($ok) return $pdo->lastInsertId();
        return false;
    }

    /* ================================
       MISE À JOUR D'UNE COLLECTION
       ================================ */
    public static function update($idCollection, $nomCollection, $notePerso = null) {
        $pdo = connexionPDO();

        $sql = "UPDATE Collection 
                SET nomCollection = :nom, notePerso = :note 
                WHERE idCollection = :id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':nom', $nomCollection, PDO::PARAM_STR);
        $stmt->bindValue(':note', $notePerso, PDO::PARAM_STR);
        $stmt->bindValue(':id', $idCollection, PDO::PARAM_INT);

        return $stmt->execute();
    }

    /* ================================
       SUPPRESSION D'UNE COLLECTION
       ================================ */
    public static function delete($idCollection) {
        $pdo = connexionPDO();

        // Supprimer dans Appartient
        $sql = "DELETE FROM Appartient WHERE idCollection = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $idCollection, PDO::PARAM_INT);
        $stmt->execute();

        // Supprimer la collection
        $sql2 = "DELETE FROM Collection WHERE idCollection = :id";
        $stmt2 = $pdo->prepare($sql2);
        $stmt2->bindValue(':id', $idCollection, PDO::PARAM_INT);

        return $stmt2->execute();
    }

    /* ================================
       COMPTER LES JEUX
       ================================ */
    public static function countJeux($idCollection) {
        $pdo = connexionPDO();
        $sql = "SELECT COUNT(*) AS nb FROM Appartient WHERE idCollection = :id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $idCollection, PDO::PARAM_INT);
        $stmt->execute();

        $r = $stmt->fetch(PDO::FETCH_ASSOC);
        return $r ? intval($r['nb']) : 0;
    }

    /* ================================
       LISTE DES JEUX D'UNE COLLECTION
       ================================ */
    public static function getJeuxInCollection($idCollection) {
        $pdo = connexionPDO();

        $sql = "SELECT j.* 
                FROM Appartient a 
                JOIN Jeu j ON a.idJeu = j.idJeu 
                WHERE a.idCollection = :id 
                ORDER BY j.titre";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $idCollection, PDO::PARAM_INT);
        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $jeux = [];
        foreach ($rows as $r) {
            $jeux[] = new Jeu(
                $r['idJeu'],
                $r['titre'],
                $r['anneeSortie'],
                $r['prixEstime']
            );
        }
        return $jeux;
    }

    /* ================================
       AJOUTER UN JEU À UNE COLLECTION
       ================================ */
    public static function ajouterJeu($idCollection, $idJeu) {
        $pdo = connexionPDO();
        $sql = "INSERT INTO Appartient (idCollection, idJeu) VALUES (:idCollection, :idJeu)";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':idCollection', $idCollection, PDO::PARAM_INT);
        $stmt->bindValue(':idJeu', $idJeu, PDO::PARAM_INT);

        return $stmt->execute();
    }

    /* ================================
       RETIRER UN JEU D'UNE COLLECTION
       ================================ */
    public static function retirerJeu($idCollection, $idJeu) {
        $pdo = connexionPDO();
        $sql = "DELETE FROM Appartient WHERE idCollection = :idCollection AND idJeu = :idJeu";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':idCollection', $idCollection, PDO::PARAM_INT);
        $stmt->bindValue(':idJeu', $idJeu, PDO::PARAM_INT);

        return $stmt->execute();
    }
}



<?php
require_once __DIR__ . "/../config/Database.php";
require_once __DIR__ . "/Collection.php";
require_once __DIR__ . "/Jeu.php";

class CollectionDAO {

    public static function getAll() {
        $pdo = connexionPDO();
        $sql = "SELECT idCollection, nomCollection, DateCreation, etat, notePerso, idUtilisateur FROM Collection ORDER BY DateCreation DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $collections = [];
        foreach ($rows as $r) {
            $collections[] = new Collection($r['idCollection'], $r['nomCollection'], $r['DateCreation'], $r['etat'], $r['notePerso'], $r['idUtilisateur']);
        }
        return $collections;
    }

    public static function getById($id) {
        $pdo = connexionPDO();
        $sql = "SELECT idCollection, nomCollection, DateCreation, etat, notePerso, idUtilisateur FROM Collection WHERE idCollection = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $r = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($r) {
            return new Collection($r['idCollection'], $r['nomCollection'], $r['DateCreation'], $r['etat'], $r['notePerso'], $r['idUtilisateur']);
        }
        return null;
    }

    public static function getByUser($idUtilisateur) {
        $pdo = connexionPDO();
        $sql = "SELECT idCollection, nomCollection, DateCreation, etat, notePerso, idUtilisateur FROM Collection WHERE idUtilisateur = :uid ORDER BY DateCreation DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':uid', $idUtilisateur, PDO::PARAM_INT);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $collections = [];
        foreach ($rows as $r) {
            $collections[] = new Collection($r['idCollection'], $r['nomCollection'], $r['DateCreation'], $r['etat'], $r['notePerso'], $r['idUtilisateur']);
        }
        return $collections;
    }

    public static function insert($nomCollection, $idUtilisateur, $etat = null, $notePerso = null, $dateCreation = null) {
        $pdo = connexionPDO();
        if ($dateCreation === null) {
            $dateCreation = date('Y-m-d');
        }
        $sql = "INSERT INTO Collection (nomCollection, DateCreation, etat, notePerso, idUtilisateur) VALUES (:nom, :date, :etat, :note, :uid)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':nom', $nomCollection, PDO::PARAM_STR);
        $stmt->bindValue(':date', $dateCreation, PDO::PARAM_STR);
        $stmt->bindValue(':etat', $etat, PDO::PARAM_STR);
        $stmt->bindValue(':note', $notePerso, PDO::PARAM_STR);
        $stmt->bindValue(':uid', $idUtilisateur, PDO::PARAM_INT);
        $ok = $stmt->execute();
        if ($ok) return $pdo->lastInsertId();
        return false;
    }

    public static function update($idCollection, $nomCollection, $etat = null, $notePerso = null) {
        $pdo = connexionPDO();
        $sql = "UPDATE Collection SET nomCollection = :nom, etat = :etat, notePerso = :note WHERE idCollection = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':nom', $nomCollection, PDO::PARAM_STR);
        $stmt->bindValue(':etat', $etat, PDO::PARAM_STR);
        $stmt->bindValue(':note', $notePerso, PDO::PARAM_STR);
        $stmt->bindValue(':id', $idCollection, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public static function delete($idCollection) {
        $pdo = connexionPDO();
        // Supprimer les associations dans la table Appartient
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

    public static function countJeux($idCollection) {
        $pdo = connexionPDO();
        $sql = "SELECT COUNT(*) AS nb FROM Appartient WHERE idCollection = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $idCollection, PDO::PARAM_INT);
        $stmt->execute();
        $r = $stmt->fetch(PDO::FETCH_ASSOC);
        return $r ? intval($r['nb']) : 0;
    }

    public static function getJeuxInCollection($idCollection) {
        $pdo = connexionPDO();
        $sql = "SELECT j.* FROM Appartient a JOIN Jeu j ON a.idJeu = j.idJeu WHERE a.idCollection = :id ORDER BY j.titre";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $idCollection, PDO::PARAM_INT);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $jeux = [];
        foreach ($rows as $r) {
            $jeux[] = new Jeu($r['idJeu'], $r['titre'], $r['anneeSortie'], $r['prixEstime']);
        }
        return $jeux;
    }

    public static function ajouterJeu($idCollection, $idJeu) {
        $pdo = connexionPDO();
        $sql = "INSERT INTO Appartient (idCollection, idJeu) VALUES (:idCollection, :idJeu)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':idCollection', $idCollection, PDO::PARAM_INT);
        $stmt->bindValue(':idJeu', $idJeu, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public static function retirerJeu($idCollection, $idJeu) {
        $pdo = connexionPDO();
        $sql = "DELETE FROM Appartient WHERE idCollection = :idCollection AND idJeu = :idJeu";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':idCollection', $idCollection, PDO::PARAM_INT);
        $stmt->bindValue(':idJeu', $idJeu, PDO::PARAM_INT);
        return $stmt->execute();
    }
}



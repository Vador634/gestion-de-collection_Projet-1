<?php
require_once __DIR__ . "/../config/Database.php";
require_once __DIR__ . "/Collection.php";
require_once __DIR__ . "/Jeu.php";

class CollectionDAO {

    private static function versCollection(array $r) {
        return new Collection($r['idCollection'], $r['nomCollection'], $r['dateCreation'], $r['notePerso'], $r['idUtilisateur']);
    }

    /* ================================
       TOUTES LES COLLECTIONS
       ================================ */
    public static function getAll() {
        $stmt = connexionPDO()->query(
            "SELECT idCollection, nomCollection, dateCreation, notePerso, idUtilisateur
             FROM Collection ORDER BY dateCreation DESC, idCollection DESC"
        );
        return array_map([self::class, 'versCollection'], $stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    /* ================================
       UNE COLLECTION PAR ID
       ================================ */
    public static function getById($id) {
        $stmt = connexionPDO()->prepare(
            "SELECT idCollection, nomCollection, dateCreation, notePerso, idUtilisateur
             FROM Collection WHERE idCollection = :id"
        );
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $r = $stmt->fetch(PDO::FETCH_ASSOC);
        return $r ? self::versCollection($r) : null;
    }

    /* ================================
       COLLECTIONS D'UN UTILISATEUR
       ================================ */
    public static function getByUser($idUtilisateur) {
        $stmt = connexionPDO()->prepare(
            "SELECT idCollection, nomCollection, dateCreation, notePerso, idUtilisateur
             FROM Collection WHERE idUtilisateur = :uid
             ORDER BY dateCreation DESC, idCollection DESC"
        );
        $stmt->bindValue(':uid', $idUtilisateur, PDO::PARAM_INT);
        $stmt->execute();
        return array_map([self::class, 'versCollection'], $stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    /* ================================
       CRÉATION
       ================================ */
    public static function insert($nomCollection, $idUtilisateur, $notePerso = null) {
        $pdo = connexionPDO();
        $stmt = $pdo->prepare(
            "INSERT INTO Collection (nomCollection, dateCreation, notePerso, idUtilisateur)
             VALUES (:nom, :dateCreation, :note, :uid)"
        );
        $stmt->bindValue(':nom', $nomCollection, PDO::PARAM_STR);
        $stmt->bindValue(':dateCreation', date('Y-m-d'), PDO::PARAM_STR);
        $stmt->bindValue(':note', $notePerso, $notePerso === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindValue(':uid', $idUtilisateur, PDO::PARAM_INT);
        return $stmt->execute() ? (int)$pdo->lastInsertId() : false;
    }

    /* ================================
       MODIFICATION
       ================================ */
    public static function update($idCollection, $nomCollection, $notePerso = null) {
        $stmt = connexionPDO()->prepare(
            "UPDATE Collection SET nomCollection = :nom, notePerso = :note WHERE idCollection = :id"
        );
        $stmt->bindValue(':nom', $nomCollection, PDO::PARAM_STR);
        $stmt->bindValue(':note', $notePerso, $notePerso === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindValue(':id', $idCollection, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /* ================================
       SUPPRESSION (collection + liens vers les jeux)
       ================================ */
    public static function delete($idCollection) {
        $pdo = connexionPDO();
        $pdo->beginTransaction();
        try {
            foreach (["DELETE FROM Appartient WHERE idCollection = :id", "DELETE FROM Collection WHERE idCollection = :id"] as $sql) {
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':id', $idCollection, PDO::PARAM_INT);
                $stmt->execute();
            }
            $pdo->commit();
            return true;
        } catch (Exception $e) {
            $pdo->rollBack();
            throw $e;
        }
    }

    /* ================================
       NOMBRE DE JEUX PAR COLLECTION (une seule requête)
       ================================ */
    public static function countJeuxParCollection(array $idsCollections) {
        $resultat = array_fill_keys($idsCollections, 0);
        if (!$idsCollections) return $resultat;
        $marqueurs = implode(',', array_fill(0, count($idsCollections), '?'));
        $stmt = connexionPDO()->prepare(
            "SELECT idCollection, COUNT(*) AS nb FROM Appartient WHERE idCollection IN ($marqueurs) GROUP BY idCollection"
        );
        $stmt->execute(array_map('intval', $idsCollections));
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $r) {
            $resultat[$r['idCollection']] = (int)$r['nb'];
        }
        return $resultat;
    }

    public static function countJeux($idCollection) {
        return self::countJeuxParCollection([$idCollection])[$idCollection];
    }

    /* ================================
       JEUX D'UNE COLLECTION
       ================================ */
    public static function getJeuxInCollection($idCollection) {
        $stmt = connexionPDO()->prepare(
            "SELECT j.idJeu, j.titre, j.anneeSortie, j.prixEstime, j.idCondition, j.idRarete, j.idDeveloppeur
             FROM Appartient a JOIN Jeu j ON a.idJeu = j.idJeu
             WHERE a.idCollection = :id ORDER BY j.titre"
        );
        $stmt->bindValue(':id', $idCollection, PDO::PARAM_INT);
        $stmt->execute();
        $jeux = [];
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $r) {
            $jeux[] = new Jeu($r['idJeu'], $r['titre'], $r['anneeSortie'], $r['prixEstime'], $r['idCondition'], $r['idRarete'], $r['idDeveloppeur']);
        }
        return $jeux;
    }

    public static function contientJeu($idCollection, $idJeu) {
        $stmt = connexionPDO()->prepare("SELECT COUNT(*) FROM Appartient WHERE idCollection = :c AND idJeu = :j");
        $stmt->bindValue(':c', $idCollection, PDO::PARAM_INT);
        $stmt->bindValue(':j', $idJeu, PDO::PARAM_INT);
        $stmt->execute();
        return (int)$stmt->fetchColumn() > 0;
    }

    /* ================================
       AJOUTER UN JEU (la date d'ajout est obligatoire en base)
       ================================ */
    public static function ajouterJeu($idCollection, $idJeu) {
        if (self::contientJeu($idCollection, $idJeu)) {
            return false; // déjà présent
        }
        $stmt = connexionPDO()->prepare(
            "INSERT INTO Appartient (idCollection, idJeu, dateAjout) VALUES (:idCollection, :idJeu, :dateAjout)"
        );
        $stmt->bindValue(':idCollection', $idCollection, PDO::PARAM_INT);
        $stmt->bindValue(':idJeu', $idJeu, PDO::PARAM_INT);
        $stmt->bindValue(':dateAjout', date('Y-m-d'), PDO::PARAM_STR);
        return $stmt->execute();
    }

    /* ================================
       RETIRER UN JEU
       ================================ */
    public static function retirerJeu($idCollection, $idJeu) {
        $stmt = connexionPDO()->prepare("DELETE FROM Appartient WHERE idCollection = :idCollection AND idJeu = :idJeu");
        $stmt->bindValue(':idCollection', $idCollection, PDO::PARAM_INT);
        $stmt->bindValue(':idJeu', $idJeu, PDO::PARAM_INT);
        return $stmt->execute();
    }
}

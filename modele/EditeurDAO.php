<?php
require_once __DIR__ . "/../config/Database.php";
require_once __DIR__ . "/Editeur.php";

class EditeurDAO {
    public static function getAll() {
        $pdo = connexionPDO();
        $sql = "SELECT idEditeur, libelleEditeur FROM Editeur ORDER BY libelleEditeur";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $list = [];
        foreach ($rows as $r) {
            $list[] = new Editeur($r['idEditeur'], $r['libelleEditeur']);
        }
        return $list;
    }

    public static function getById($id) {
        $pdo = connexionPDO();
        $sql = "SELECT idEditeur, libelleEditeur FROM Editeur WHERE idEditeur = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id',$id,PDO::PARAM_INT);
        $stmt->execute();
        $r = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($r) return new Editeur($r['idEditeur'],$r['libelleEditeur']);
        return null;
    }

    public static function insert($libelleEditeur) {
        $pdo = connexionPDO();
        $sql = "INSERT INTO Editeur(libelleEditeur) VALUES(:libelle)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':libelle',$libelleEditeur,PDO::PARAM_STR);
        $ok = $stmt->execute();
        if ($ok) return $pdo->lastInsertId();
        return false;
    }

    public static function update($id, $libelleEditeur) {
        $pdo = connexionPDO();
        $sql = "UPDATE Editeur SET libelleEditeur = :libelle WHERE idEditeur = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id',$id,PDO::PARAM_INT);
        $stmt->bindValue(':libelle',$libelleEditeur,PDO::PARAM_STR);
        return $stmt->execute();
    }

    public static function delete($id) {
        $pdo = connexionPDO();
        $sql = "DELETE FROM Editeur WHERE idEditeur = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id',$id,PDO::PARAM_INT);
        return $stmt->execute();
    }
}

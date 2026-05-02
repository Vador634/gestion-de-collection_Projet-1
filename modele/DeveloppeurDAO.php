<?php
require_once __DIR__ . "/../config/Database.php";
require_once __DIR__ . "/Developpeur.php";

class DeveloppeurDAO {
    public static function getAll() {
        $pdo = connexionPDO();
        $sql = "SELECT idDeveloppeur, libelleDeveloppeur FROM Developpeur ORDER BY libelleDeveloppeur";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $list = [];
        foreach ($rows as $r) {
            $list[] = new Developpeur($r['idDeveloppeur'], $r['libelleDeveloppeur']);
        }
        return $list;
    }

    public static function getById($id) {
        $pdo = connexionPDO();
        $sql = "SELECT idDeveloppeur, libelleDeveloppeur FROM Developpeur WHERE idDeveloppeur = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id',$id,PDO::PARAM_INT);
        $stmt->execute();
        $r = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($r) return new Developpeur($r['idDeveloppeur'],$r['libelleDeveloppeur']);
        return null;
    }
}

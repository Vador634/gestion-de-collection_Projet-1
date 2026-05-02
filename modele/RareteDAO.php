<?php
require_once __DIR__ . "/../config/Database.php";
require_once __DIR__ . "/Rarete.php";

class RareteDAO {
    private static function ensureDefaults() {
        $pdo = connexionPDO();
        $defaults = [
            'commun',
            'rare',
            'super rare'
        ];
        $check = $pdo->prepare("SELECT COUNT(*) FROM Rarete WHERE libelleRarete = :lib");
        $insert = $pdo->prepare("INSERT INTO Rarete(libelleRarete) VALUES(:lib)");
        foreach ($defaults as $d) {
            $check->bindValue(':lib',$d,PDO::PARAM_STR);
            $check->execute();
            if (((int)$check->fetchColumn()) === 0) {
                $insert->bindValue(':lib',$d,PDO::PARAM_STR);
                $insert->execute();
            }
        }
    }

    public static function getAll() {
        self::ensureDefaults();
        $pdo = connexionPDO();
        $sql = "SELECT idRarete, libelleRarete FROM Rarete ORDER BY libelleRarete";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $list = [];
        foreach ($rows as $r) {
            $list[] = new Rarete($r['idRarete'], $r['libelleRarete']);
        }
        return $list;
    }

    public static function getById($id) {
        $pdo = connexionPDO();
        $sql = "SELECT idRarete, libelleRarete FROM Rarete WHERE idRarete = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id',$id,PDO::PARAM_INT);
        $stmt->execute();
        $r = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($r) return new Rarete($r['idRarete'],$r['libelleRarete']);
        return null;
    }
}

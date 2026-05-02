<?php
require_once __DIR__ . "/../config/Database.php";
require_once __DIR__ . "/Condition.php";

class ConditionDAO {
    // ensure the four expected rows exist
    private static function ensureDefaults() {
        $pdo = connexionPDO();
        $defaults = [
            'mauvais',
            'bon',
            'excellente',
            'dématérialisé'
        ];
        $check = $pdo->prepare("SELECT COUNT(*) FROM ConditionJeu WHERE libelleCondition = :lib");
        $insert = $pdo->prepare("INSERT INTO ConditionJeu(libelleCondition) VALUES(:lib)");
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
        $sql = "SELECT idCondition, libelleCondition FROM ConditionJeu ORDER BY libelleCondition";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $list = [];
        foreach ($rows as $r) {
            $list[] = new Condition($r['idCondition'], $r['libelleCondition']);
        }
        return $list;
    }

    public static function getById($id) {
        $pdo = connexionPDO();
        $sql = "SELECT idCondition, libelleCondition FROM ConditionJeu WHERE idCondition = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id',$id,PDO::PARAM_INT);
        $stmt->execute();
        $r = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($r) return new Condition($r['idCondition'],$r['libelleCondition']);
        return null;
    }
}

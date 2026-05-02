<?php
require_once __DIR__ . "/../config/Database.php";
require_once __DIR__ . "/Console.php";

class ConsoleDAO {
    public static function getAll() {
        $conn = connexionPDO();
        $sql = "SELECT * FROM Console ORDER BY nomConsole";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $res = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $res[] = new Console($row["idConsole"], $row["nomConsole"], $row["fabricant"]);
        }
        return $res;
    }

    public static function getById($idConsole) {
        $conn = connexionPDO();
        $sql = "SELECT * FROM Console WHERE idConsole = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(":id", $idConsole, PDO::PARAM_INT);
        $stmt->execute();

        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return new Console($row["idConsole"], $row["nomConsole"], $row["fabricant"]);
        }
        return null;
    }

    public static function insert($nomConsole, $fabricant) {
        $conn = connexionPDO();
        $sql = "INSERT INTO Console(nomConsole, fabricant) VALUES (:nomConsole, :fabricant)";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(":nomConsole", $nomConsole, PDO::PARAM_STR);
        $stmt->bindValue(":fabricant", $fabricant, PDO::PARAM_STR);
        $ok = $stmt->execute();
        if ($ok) return $conn->lastInsertId();
        return false;
    }

    public static function update($idConsole, $nomConsole, $fabricant) {
        $conn = connexionPDO();
        $sql = "UPDATE Console SET nomConsole = :nomConsole, fabricant = :fabricant WHERE idConsole = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(":id", $idConsole, PDO::PARAM_INT);
        $stmt->bindValue(":nomConsole", $nomConsole, PDO::PARAM_STR);
        $stmt->bindValue(":fabricant", $fabricant, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public static function delete($idConsole) {
        $conn = connexionPDO();
        $sql = "DELETE FROM Console WHERE idConsole = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(":id", $idConsole, PDO::PARAM_INT);
        return $stmt->execute();
    }
}


<?php
require_once __DIR__ . "/../config/Database.php";
require_once __DIR__ . "/Genre.php";

class GenreDAO {
    public static function getAll() {
        $conn = connexionPDO();
        $sql = "SELECT * FROM Genre ORDER BY nomGenre";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $res = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $res[] = new Genre($row["idGenre"], $row["nomGenre"]);
        }
        return $res;
    }

    public static function getById($idGenre) {
        $conn = connexionPDO();
        $sql = "SELECT * FROM Genre WHERE idGenre = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(":id", $idGenre, PDO::PARAM_INT);
        $stmt->execute();

        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return new Genre($row["idGenre"], $row["nomGenre"]);
        }
        return null;
    }

    public static function insert($nomGenre) {
        $conn = connexionPDO();
        $sql = "INSERT INTO Genre(nomGenre) VALUES (:nomGenre)";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(":nomGenre", $nomGenre, PDO::PARAM_STR);
        $ok = $stmt->execute();
        if ($ok) return $conn->lastInsertId();
        return false;
    }

    public static function update($idGenre, $nomGenre) {
        $conn = connexionPDO();
        $sql = "UPDATE Genre SET nomGenre = :nomGenre WHERE idGenre = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(":id", $idGenre, PDO::PARAM_INT);
        $stmt->bindValue(":nomGenre", $nomGenre, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public static function delete($idGenre) {
        $conn = connexionPDO();
        $sql = "DELETE FROM Genre WHERE idGenre = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(":id", $idGenre, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
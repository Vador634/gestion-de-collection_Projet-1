<?php
require_once __DIR__ . "/../config/Database.php";
require_once __DIR__ . "/Jeu.php";

class JeuDAO {
    public static function getAll() {
        $cnx = connexionPDO();
        $req = $cnx->prepare("SELECT * FROM Jeu ORDER BY titre");
        $req->execute();
        $resultat = $req->fetchAll(PDO::FETCH_ASSOC);

        $jeux = [];
        foreach ($resultat as $row) {
            $jeux[] = new Jeu($row["idJeu"], $row["titre"], $row["anneeSortie"], $row["prixEstime"]);
        }
        return $jeux;
    }

    public static function getById($id) {
        $cnx = connexionPDO();
        $req = $cnx->prepare("SELECT * FROM Jeu WHERE idJeu = :id");
        $req->bindValue(":id", $id, PDO::PARAM_INT);
        $req->execute();
        $row = $req->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new Jeu($row["idJeu"], $row["titre"], $row["anneeSortie"], $row["prixEstime"]);
        }
        return null;
    }

    public static function insert($titre, $anneeSortie, $prixEstime) {
        $cnx = connexionPDO();
        $req = $cnx->prepare("INSERT INTO Jeu(titre, anneeSortie, prixEstime) VALUES(:titre, :annee, :prix)");
        $req->bindValue(":titre", $titre, PDO::PARAM_STR);
        $req->bindValue(":annee", $anneeSortie, PDO::PARAM_INT);
        $req->bindValue(":prix", $prixEstime);
        $ok = $req->execute();
        if ($ok) return $cnx->lastInsertId();
        return false;
    }

    public static function update($id, $titre, $anneeSortie, $prixEstime) {
        $cnx = connexionPDO();
        $req = $cnx->prepare("UPDATE Jeu SET titre = :titre, anneeSortie = :annee, prixEstime = :prix WHERE idJeu = :id");
        $req->bindValue(":id", $id, PDO::PARAM_INT);
        $req->bindValue(":titre", $titre, PDO::PARAM_STR);
        $req->bindValue(":annee", $anneeSortie, PDO::PARAM_INT);
        $req->bindValue(":prix", $prixEstime);
        return $req->execute();
    }

    public static function delete($id) {
        $cnx = connexionPDO();
        $req = $cnx->prepare("DELETE FROM Jeu WHERE idJeu = :id");
        $req->bindValue(":id", $id, PDO::PARAM_INT);
        return $req->execute();
    }
}



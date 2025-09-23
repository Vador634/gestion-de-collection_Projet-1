<?php
require_once "config/Database.php";
require_once "modele/Jeu.php";

class JeuDAO {
    public static function getAll() {
        $cnx = connexionPDO();
        $req = $cnx->prepare("SELECT * FROM Jeu");
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
        $req->bindValue(":annee", $anneeSortie, PDO::PARAM_STR);
        $req->bindValue(":prix", $prixEstime, PDO::PARAM_STR);
        return $req->execute();
    }
}



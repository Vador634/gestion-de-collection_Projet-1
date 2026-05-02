<?php
require_once __DIR__ . "/../config/Database.php";
require_once __DIR__ . "/Jeu.php";
require_once __DIR__ . "/Console.php";
require_once __DIR__ . "/Genre.php";
require_once __DIR__ . "/Editeur.php";

class JeuDAO {
    public static function getAll() {
        $cnx = connexionPDO();
        $req = $cnx->prepare("SELECT idJeu, titre, anneeSortie, prixEstime FROM Jeu ORDER BY titre");
        $req->execute();
        $resultat = $req->fetchAll(PDO::FETCH_ASSOC);

        $jeux = [];
        foreach ($resultat as $row) {
            $jeux[] = new Jeu(
                $row["idJeu"],
                $row["titre"],
                $row["anneeSortie"],
                $row["prixEstime"]
            );
        }
        return $jeux;
    }

    public static function getById($id) {
        $cnx = connexionPDO();
        $req = $cnx->prepare("SELECT idJeu, titre, anneeSortie, prixEstime FROM Jeu WHERE idJeu = :id");
        $req->bindValue(":id", $id, PDO::PARAM_INT);
        $req->execute();
        $row = $req->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new Jeu(
                $row["idJeu"],
                $row["titre"],
                $row["anneeSortie"],
                $row["prixEstime"]
            );
        }
        return null;
    }

    public static function insert($titre, $anneeSortie, $prixEstime) {
        $cnx = connexionPDO();
        $req = $cnx->prepare(
            "INSERT INTO Jeu(titre, anneeSortie, prixEstime) VALUES(:titre, :annee, :prix)"
        );
        $req->bindValue(":titre", $titre, PDO::PARAM_STR);
        $req->bindValue(":annee", $anneeSortie, PDO::PARAM_INT);
        $req->bindValue(":prix", $prixEstime);
        $ok = $req->execute();
        if ($ok) return $cnx->lastInsertId();
        return false;
    }

    public static function update($id, $titre, $anneeSortie, $prixEstime) {
        $cnx = connexionPDO();
        $req = $cnx->prepare(
            "UPDATE Jeu SET titre = :titre, anneeSortie = :annee, prixEstime = :prix WHERE idJeu = :id"
        );
        $req->bindValue(":id", $id, PDO::PARAM_INT);
        $req->bindValue(":titre", $titre, PDO::PARAM_STR);
        $req->bindValue(":annee", $anneeSortie, PDO::PARAM_INT);
        $req->bindValue(":prix", $prixEstime);
        return $req->execute();
    }

    public static function delete($id) {
        $cnx = connexionPDO();
        // nettoyer tables associatives
        $stmt = $cnx->prepare("DELETE FROM Disponible WHERE idJeu = :id");
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $stmt = $cnx->prepare("DELETE FROM GenreJeu WHERE idJeu = :id");
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $stmt = $cnx->prepare("DELETE FROM Edite WHERE idJeu = :id");
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();

        $req = $cnx->prepare("DELETE FROM Jeu WHERE idJeu = :id");
        $req->bindValue(":id", $id, PDO::PARAM_INT);
        return $req->execute();
    }

    // ---------- helpers for many-to-many relations ----------
    public static function getConsoles($idJeu) {
        $cnx = connexionPDO();
        $sql = "SELECT c.* FROM Console c
                JOIN Disponible d ON c.idConsole = d.idConsole
                WHERE d.idJeu = :id"; // c.fabricant used below
        $stmt = $cnx->prepare($sql);
        $stmt->bindValue(':id',$idJeu,PDO::PARAM_INT);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $list = [];
        foreach ($rows as $r) {
            $list[] = new Console($r['idConsole'],$r['nomConsole'],$r['fabricant']);
        }
        return $list;
    }

    public static function setConsoles($idJeu, array $ids) {
        $cnx = connexionPDO();
        $cnx->beginTransaction();
        $stmt = $cnx->prepare("DELETE FROM Disponible WHERE idJeu = :id");
        $stmt->bindValue(':id',$idJeu,PDO::PARAM_INT);
        $stmt->execute();
        if (!empty($ids)) {
            $stmt = $cnx->prepare("INSERT INTO Disponible(idJeu,idConsole) VALUES(:jeu,:console)");
            foreach ($ids as $cid) {
                $stmt->bindValue(':jeu',$idJeu,PDO::PARAM_INT);
                $stmt->bindValue(':console',$cid,PDO::PARAM_INT);
                $stmt->execute();
            }
        }
        $cnx->commit();
    }

    public static function getGenres($idJeu) {
        $cnx = connexionPDO();
        $sql = "SELECT g.* FROM Genre g
                JOIN GenreJeu gj ON g.idGenre = gj.idGenre
                WHERE gj.idJeu = :id";
        $stmt = $cnx->prepare($sql);
        $stmt->bindValue(':id',$idJeu,PDO::PARAM_INT);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $list = [];
        foreach ($rows as $r) {
            $list[] = new Genre($r['idGenre'],$r['nomGenre'] ?? $r['libelleGenre']);
        }
        return $list;
    }

    public static function setGenres($idJeu, array $ids) {
        $cnx = connexionPDO();
        $cnx->beginTransaction();
        $stmt = $cnx->prepare("DELETE FROM GenreJeu WHERE idJeu = :id");
        $stmt->bindValue(':id',$idJeu,PDO::PARAM_INT);
        $stmt->execute();
        if (!empty($ids)) {
            $stmt = $cnx->prepare("INSERT INTO GenreJeu(idJeu,idGenre) VALUES(:jeu,:genre)");
            foreach ($ids as $gid) {
                $stmt->bindValue(':jeu',$idJeu,PDO::PARAM_INT);
                $stmt->bindValue(':genre',$gid,PDO::PARAM_INT);
                $stmt->execute();
            }
        }
        $cnx->commit();
    }

    public static function getEditeurs($idJeu) {
        $cnx = connexionPDO();
        $sql = "SELECT e.* FROM Editeur e
                JOIN Edite ed ON e.idEditeur = ed.idEditeur
                WHERE ed.idJeu = :id";
        $stmt = $cnx->prepare($sql);
        $stmt->bindValue(':id',$idJeu,PDO::PARAM_INT);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $list = [];
        foreach ($rows as $r) {
            $list[] = new Editeur($r['idEditeur'],$r['libelleEditeur']);
        }
        return $list;
    }

    public static function setEditeurs($idJeu, array $ids) {
        $cnx = connexionPDO();
        $cnx->beginTransaction();
        $stmt = $cnx->prepare("DELETE FROM Edite WHERE idJeu = :id");
        $stmt->bindValue(':id',$idJeu,PDO::PARAM_INT);
        $stmt->execute();
        if (!empty($ids)) {
            $stmt = $cnx->prepare("INSERT INTO Edite(idJeu,idEditeur) VALUES(:jeu,:editeur)");
            foreach ($ids as $eid) {
                $stmt->bindValue(':jeu',$idJeu,PDO::PARAM_INT);
                $stmt->bindValue(':editeur',$eid,PDO::PARAM_INT);
                $stmt->execute();
            }
        }
        $cnx->commit();
    }
}



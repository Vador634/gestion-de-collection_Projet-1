<?php
require_once __DIR__ . "/../config/Database.php";
require_once __DIR__ . "/Jeu.php";
require_once __DIR__ . "/Console.php";
require_once __DIR__ . "/Genre.php";
require_once __DIR__ . "/Editeur.php";

class JeuDAO {
    private const COLONNES = "idJeu, titre, anneeSortie, prixEstime, idCondition, idRarete, idDeveloppeur";

    private static function versJeu(array $row) {
        return new Jeu(
            $row["idJeu"],
            $row["titre"],
            $row["anneeSortie"],
            $row["prixEstime"],
            $row["idCondition"],
            $row["idRarete"],
            $row["idDeveloppeur"]
        );
    }

    public static function getAll() {
        $req = connexionPDO()->query("SELECT " . self::COLONNES . " FROM Jeu ORDER BY titre");
        $jeux = [];
        foreach ($req->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $jeux[] = self::versJeu($row);
        }
        return $jeux;
    }

    public static function getById($id) {
        $req = connexionPDO()->prepare("SELECT " . self::COLONNES . " FROM Jeu WHERE idJeu = :id");
        $req->bindValue(":id", $id, PDO::PARAM_INT);
        $req->execute();
        $row = $req->fetch(PDO::FETCH_ASSOC);
        return $row ? self::versJeu($row) : null;
    }

    /**
     * Ajoute un jeu. La condition, la rareté et le développeur sont facultatifs.
     * @return int|false identifiant du jeu créé
     */
    public static function insert($titre, $anneeSortie, $prixEstime, $idCondition = null, $idRarete = null, $idDeveloppeur = null) {
        $cnx = connexionPDO();
        $req = $cnx->prepare(
            "INSERT INTO Jeu(titre, anneeSortie, prixEstime, idCondition, idRarete, idDeveloppeur)
             VALUES(:titre, :annee, :prix, :cond, :rare, :dev)"
        );
        self::lierChamps($req, $titre, $anneeSortie, $prixEstime, $idCondition, $idRarete, $idDeveloppeur);
        return $req->execute() ? (int)$cnx->lastInsertId() : false;
    }

    public static function update($id, $titre, $anneeSortie, $prixEstime, $idCondition = null, $idRarete = null, $idDeveloppeur = null) {
        $req = connexionPDO()->prepare(
            "UPDATE Jeu SET titre = :titre, anneeSortie = :annee, prixEstime = :prix,
                            idCondition = :cond, idRarete = :rare, idDeveloppeur = :dev
             WHERE idJeu = :id"
        );
        $req->bindValue(":id", $id, PDO::PARAM_INT);
        self::lierChamps($req, $titre, $anneeSortie, $prixEstime, $idCondition, $idRarete, $idDeveloppeur);
        return $req->execute();
    }

    private static function lierChamps(PDOStatement $req, $titre, $annee, $prix, $cond, $rare, $dev) {
        $req->bindValue(":titre", $titre, PDO::PARAM_STR);
        $req->bindValue(":annee", $annee, $annee === null ? PDO::PARAM_NULL : PDO::PARAM_INT);
        $req->bindValue(":prix", $prix === null ? null : (string)$prix, $prix === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $req->bindValue(":cond", $cond, $cond === null ? PDO::PARAM_NULL : PDO::PARAM_INT);
        $req->bindValue(":rare", $rare, $rare === null ? PDO::PARAM_NULL : PDO::PARAM_INT);
        $req->bindValue(":dev", $dev, $dev === null ? PDO::PARAM_NULL : PDO::PARAM_INT);
    }

    /**
     * Supprime un jeu et toutes ses associations (collections, consoles,
     * genres, éditeurs, langues, modes de jeu), dans une transaction.
     */
    public static function delete($id) {
        $cnx = connexionPDO();
        $cnx->beginTransaction();
        try {
            foreach (['Appartient', 'Disponible', 'GenreJeu', 'Edite', 'JeuLangue', 'JeuModeDeJeu', 'Jeu'] as $table) {
                $stmt = $cnx->prepare("DELETE FROM $table WHERE idJeu = :id");
                $stmt->bindValue(":id", $id, PDO::PARAM_INT);
                $stmt->execute();
            }
            $cnx->commit();
            return true;
        } catch (Exception $e) {
            $cnx->rollBack();
            throw $e;
        }
    }

    /** Nombre de collections qui contiennent ce jeu. */
    public static function countCollections($idJeu) {
        $stmt = connexionPDO()->prepare("SELECT COUNT(*) FROM Appartient WHERE idJeu = :id");
        $stmt->bindValue(':id', $idJeu, PDO::PARAM_INT);
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }

    // ---------- Associations plusieurs-à-plusieurs ----------

    public static function getConsoles($idJeu) {
        $stmt = connexionPDO()->prepare(
            "SELECT c.idConsole, c.nomConsole, c.fabricant FROM Console c
             JOIN Disponible d ON c.idConsole = d.idConsole
             WHERE d.idJeu = :id ORDER BY c.nomConsole"
        );
        $stmt->bindValue(':id', $idJeu, PDO::PARAM_INT);
        $stmt->execute();
        $list = [];
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $r) {
            $list[] = new Console($r['idConsole'], $r['nomConsole'], $r['fabricant']);
        }
        return $list;
    }

    public static function getGenres($idJeu) {
        $stmt = connexionPDO()->prepare(
            "SELECT g.idGenre, g.libelleGenre FROM Genre g
             JOIN GenreJeu gj ON g.idGenre = gj.idGenre
             WHERE gj.idJeu = :id ORDER BY g.libelleGenre"
        );
        $stmt->bindValue(':id', $idJeu, PDO::PARAM_INT);
        $stmt->execute();
        $list = [];
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $r) {
            $list[] = new Genre($r['idGenre'], $r['libelleGenre']);
        }
        return $list;
    }

    public static function getEditeurs($idJeu) {
        $stmt = connexionPDO()->prepare(
            "SELECT e.idEditeur, e.libelleEditeur FROM Editeur e
             JOIN Edite ed ON e.idEditeur = ed.idEditeur
             WHERE ed.idJeu = :id ORDER BY e.libelleEditeur"
        );
        $stmt->bindValue(':id', $idJeu, PDO::PARAM_INT);
        $stmt->execute();
        $list = [];
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $r) {
            $list[] = new Editeur($r['idEditeur'], $r['libelleEditeur']);
        }
        return $list;
    }

    public static function setConsoles($idJeu, array $ids) {
        self::remplacerAssociations('Disponible', 'idConsole', $idJeu, $ids);
    }

    public static function setGenres($idJeu, array $ids) {
        self::remplacerAssociations('GenreJeu', 'idGenre', $idJeu, $ids);
    }

    public static function setEditeurs($idJeu, array $ids) {
        self::remplacerAssociations('Edite', 'idEditeur', $idJeu, $ids);
    }

    /**
     * Remplace les associations d'un jeu dans une table de liaison.
     * Les identifiants sont convertis en entiers et dédoublonnés.
     * S'exécute dans la transaction en cours s'il y en a une.
     */
    private static function remplacerAssociations($table, $colonne, $idJeu, array $ids) {
        $cnx = connexionPDO();
        $ids = array_unique(array_filter(array_map('intval', $ids), function ($id) { return $id > 0; }));

        $transactionLocale = !$cnx->inTransaction();
        if ($transactionLocale) $cnx->beginTransaction();
        try {
            $stmt = $cnx->prepare("DELETE FROM $table WHERE idJeu = :id");
            $stmt->bindValue(':id', $idJeu, PDO::PARAM_INT);
            $stmt->execute();

            $stmt = $cnx->prepare("INSERT INTO $table(idJeu, $colonne) VALUES(:jeu, :autre)");
            foreach ($ids as $id) {
                $stmt->bindValue(':jeu', $idJeu, PDO::PARAM_INT);
                $stmt->bindValue(':autre', $id, PDO::PARAM_INT);
                $stmt->execute();
            }
            if ($transactionLocale) $cnx->commit();
        } catch (Exception $e) {
            if ($transactionLocale) $cnx->rollBack();
            throw $e;
        }
    }
}

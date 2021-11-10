<?php 

    require_once '../config/config.php';

    function connectBdd() {
        try {
        $bdd = new PDO($param, $user, $psw, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        if ($bdd) {
          echo 'Connected';
        }
      } catch (PDOException $ex) {
        return $bdd;
      }
    }

    function getAllInformations($bdd, $query) {
        $result = null;

        $select = $bdd->query($query);
        if ($select) {
           while ($row = $select->fetch(\PDO::FETCH_ASSOC)) {
               $result[] = $row;
           }
        }
        return $result;
    }

    function insertFormation($bdd, $info) {
        $result = null;
        $query = "INSERT INTO formation (intitule, niveau) VALUES (:intitule, :niveau)";

        $prepare = $bdd->prepare($query);
        $insert = $prepare->execute(array(':intitule' => $info['intitule'], ':niveau' => $info['niveau']));
        if ($insert !== false) {
            $result = null;
            $query = "SELECT * FORM formation ORDER BY id DESC LIMIT 1";
            $result = getAllInformations($bdd, $query);
            return $result;
        }
    }
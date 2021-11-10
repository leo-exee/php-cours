<?php
//  Fonction à utiliser de préférence à var_dump() lorsque XDebug n'est pas configuré sur la configuration
//  Attention, pour voir les affichages, il faut:
//	* soit basculer la constante DUMP à TRUE dans votre application... 
//	* soit passer TRUE en deuxième paramètre.
//  Vous pouvez passer en 3ème paramètre une chaîne de caractères pour commenter le dump.
//  Dans ce cas, vous DEVEZ donner une valeur pour le deuxième paramètre (soit DUMP, soit TRUE).
function dump_var($var, $dump=DUMP, $msg=null)
{
    if($dump) {
	if($msg)
	    echo"<p><strong>$msg</strong></p>";
	echo '<pre>';
	var_dump($var);
	echo '</pre>';
    }
}


/**
 * Etablie une connexion avec la BDD
 * @param array $infoBdd les paramètres de connexion (voir config/appConfig.php)
 * @return PDO|null
 */
function connectBdd(array $infoBdd): ?PDO {
    $db = null;

    dump_var($infoBdd, DUMP, 'infoBdd: ');
    $myport = (isset($infoBdd['port'])) ? $infoBdd['port'] : 3306;
    $mycharset = (isset($infoBdd['charset'])) ? $infoBdd['charset'] : 'UTF8';
    $hostname = (isset($infoBdd['host'])) ? $infoBdd['host'] : null;
    $mydbname = (isset($infoBdd['dbname'])) ? $infoBdd['dbname'] : null;
    $myusername = (isset($infoBdd['user'])) ? $infoBdd['user'] : null;
    $mypassword = (isset($infoBdd['pass'])) ? $infoBdd['pass'] : '';

    if ($hostname == null || $mydbname == null || $myusername == null) {
	return null;
    }

    //  Composition du DSN
    $dsn = "mysql:dbname=$mydbname;host=$hostname;port=$myport";
    dump_var($dsn, DUMP, 'DSN: ');
    $db = new PDO($dsn, $myusername, $mypassword, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES $mycharset"));
    if ($db) {
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    return $db;
}

function getAllFormations(PDO $bdd): ?array {
    $resultSet = NULL;
    $query = 'SELECT * FROM formation';
    dump_var($query, DUMP, 'Requête SQL:');

    $rqtResult = $bdd->query($query);
    dump_var($rqtResult, DUMP, 'getAllFormation');
    if ($rqtResult) {
        while ($row = $rqtResult->fetch(\PDO::FETCH_ASSOC)) {
            $resultSet[] = $row;
        }
    }
    return $resultSet;
}


function getFormationId(PDO $bdd, int $id): ?array {
    $resultSet = NULL;
    $query = 'SELECT * FROM formation WHERE id=:id;';
    dump_var($query, DUMP, 'Requête SQL:');

    $reqPrep = $bdd->prepare($query);
    dump_var($reqPrep, DUMP, '$reqPrep dans getFormationId');
    $res = $reqPrep->execute(array(':id' => $id));
    dump_var($res, DUMP, '$res dans getFormationId');

    if ($res != FALSE) {
	$resultSet = ($tmp = $reqPrep->fetch(PDO::FETCH_ASSOC)) ? $tmp : null;
    }
    return $resultSet;
}



function updateFormation(PDO $bdd, array $formation): ?array {
    dump_var($formation, DUMP, '$formation dans updateFormation');
    $resultSet = NULL;

    // id ne peut pas être null et la compétence doit bien exister dans la bdd, sinon insert...
    if ($formation['id'] == null || getFormationId($bdd, $formation['id']) == null) {
	$formation['id'] = null;
	$resultSet = insertFormation($bdd, $formation);
    } else {
	//  Entité existante
	$query = "UPDATE formation"
		. " SET intitule = :intitule, niveau = :niveau"
		. " WHERE id = :id";

	$reqPrep = $bdd->prepare($query);
	dump_var($reqPrep, DUMP, '$reqPrep dans updateFormation');
	$res = $reqPrep->execute(array(':intitule' => $formation['intitule'],
	    ':niveau' => $formation['niveau'],
	    ':id' => $formation['id'],)
	);

	if ($res != FALSE) {
	    $resultSet = $formation;
	}
    }

    return $resultSet;
}


function insertFormation(PDO $bdd, array $obj): ?array {
    dump_var($obj, DUMP, '$obj dans insertFormation');
    $resultSet = NULL;

    // Nouvelle entité
    $query = "INSERT INTO formation" .
	    " (intitule, niveau)"
	    . " VALUES (:intitule, :niveau)";

    $reqPrep = $bdd->prepare($query);
    dump_var($reqPrep, DUMP, '$reqPrep dans insertCompetence');
    $res = $reqPrep->execute(array(':intitule' => $obj['intitule'],
	':niveau' => $obj['niveau'])
    );

    if ($res !== FALSE) {
	$obj['id'] = $bdd->lastInsertId();
	$resultSet = $obj;
    }

    return $resultSet;
}

function saveFormation(PDO $bdd, array $formation): ?array {
    if (isset($formation['id']))
	return updateFormation($bdd, $formation);
    else
	return insertFormation($bdd, $formation);
}



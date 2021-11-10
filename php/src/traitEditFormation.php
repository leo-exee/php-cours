<?php
declare(strict_types=1);

require_once '../../config/appConfig.php';
require_once '../../src/fonctionsUtiles.php';

//  On s'assure qu'on arrive bien selon la méthode POST
$error = true;
//  On récupère le verbe HTTP qui nous ammène ici (GET ou POST
$request = strtoupper(filter_input(INPUT_SERVER, 'REQUEST_METHOD', FILTER_SANITIZE_STRING));

switch ($request) {
    case'POST':
	//  Cette partie de code sera exécuté seulement lors d'une requète POST, c'est à  dire lorsque le formulaire sera soumis.
	//  Récupération du token dansle formulaire
	$token = ($tmp = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRING)) ? $tmp : '';
	if (DUMP) {
	    echo"token<br/>";
	    var_dump($token);
	}
	if (!empty($_SESSION['token']) && $token !== '' && hash_equals($_SESSION['token'], $token)) {
	    //  Le token est correct
	    //  hash_equals — Comparaison de chaînes résistante aux attaques temporelles

	    $error = false;

	    $filters = array(
		'id' => FILTER_VALIDATE_INT,
		'intitule' => FILTER_SANITIZE_STRING,
		'niveau' => FILTER_VALIDATE_INT,
	    );

	    $postFiltre = filter_input_array(INPUT_POST, $filters, TRUE);
	    $postFiltre['intitule'] = substr($postFiltre['intitule'], 0, 45);
	    if($postFiltre['niveau'] < 1) {
		$postFiltre['niveau'] = 1;
	    }
	    if($postFiltre['niveau'] > 8) {
		$postFiltre['niveau'] = 8;
	    }
	    dump_var($postFiltre, DUMP, '$postFiltre');

	    if ($postFiltre['intitule'] != null && $postFiltre['intitule'] != '' && !is_null($postFiltre['niveau'])) {
		if ($postFiltre['id'] === FALSE) {
		    $postFiltre['id'] = null;
		}
		$bdd = connectBdd($infoBdd);
		if ($bdd) {
		    $formation = saveFormation($bdd, $postFiltre);
		    dump_var($formation, DUMP, '$formation');
		}
	    }
	} else {
	    //  Erreur sur le token
	    $error = true;
	}
	break;
    default:
	// On est arrivé ici avec autre chose que POST...
	header("location: ../formEditFormation");
	break;
}

//  Redirection vers la liste des personnes
if (!DUMP)
    header("location: ../listeFormations.php");
else
    echo'<p>DUMP est true, redirection vers "../index.php" dévalidée.</p>';
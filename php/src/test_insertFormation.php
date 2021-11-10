<?php
declare(strict_types=1);

require_once '../config/appConfig.php';

$tab = array('intitule' => 'Insertion Formation','niveau' => -1);
//$tab = array('intitule' => 'Insertion Formation Insertion Formation Insertion Formation Insertion Formation','niveau' => -1);
//$tab = array('intitule' => 'Insertion Formation','niveau' => 'Test');
dump_var($tab, true, 'Données à sauver:');

$bdd = connectBdd($infoBdd);

$Sauvee = insertFormation($bdd, $tab);
dump_var($Sauvee, true, 'insertFormation:');
<?php
declare(strict_types=1);

require_once '../config/appConfig.php';
require_once '../src/fonctionsUtiles.php';

$bdd = connectBdd($infoBdd);

$formations = getAllFormations($bdd);
dump_var($formations, true, 'getAllFormations:');
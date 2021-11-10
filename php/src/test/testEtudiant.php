<?php

declare(strict_types=1);

require_once '../config/config.php';
require_once '../config/config.php';
require_once '../fonctionsUtiles.php';

use Entites\Etudiant;

$obj = new Etudiant();
dump_var($obj, true, 'Etudiant dans param:');

$obj->setId(11)->setIdFormation(99)->setNom('JEAN')->setPrenom('JEAN');

dump_var($obj, true, 'Etudiant après edit:');
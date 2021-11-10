<?php
declare(strict_types=1);

require_once '../config/appConfig.php';
require_once '../src/fonctionsUtiles.php';

$bdd = connectBdd($infoBdd);
if ($bdd):
    $lesFormations = getAllFormations($bdd);
?>
    <!DOCTYPE html>
    <!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
    <!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
    <!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
    <!--[if gt IE 8]><!--> <html class="no-js" lang="fr"> <!--<![endif]-->
        <head>
            <title>Compétences</title>
	    <?php include_once 'inc/head.php'; ?>
        </head>
        <body>
            <!--[if lt IE 8]>
                <p class="browserupgrade">Vous utilisez un navigateur web <strong>dépassé</strong>. S'il vous plait, <a href="http://browsehappy.com/">mettez à jour votre navigateur</a> pour améliorer votre experience de navigation.</p>
            <![endif]-->

            <div class="header-container">
		<?php include_once 'inc/header.php'; ?>
    	</div>

            <div class="main-container">
                <div class="main wrapper clearfix">
    		<div id="corps">
    		    <article>
    			<header>
    			    <h1>Liste des formations</h1>
    			    <p>Voici les formations enregistrées:</p>
    			</header>
    			<section>

    			    <table class="striped sortable">
    				<thead>
    				    <tr><th>Id</th><th>Intitulé</th><th>Niveau</th><th></th></tr>
    				</thead>
    				<tbody>
					<?php
					foreach ($lesFormations as $formation):
					    ?>
					    <tr>
						<td><?= $formation['id']; ?></td>
						<td><?= $formation['intitule'] ?></td>
						<td><?= $formation['niveau'] ?></td>
						<td><a href="formEditFormation.php?id=<?= $formation['id'] ?>"><img src="img/edit.png" style="max-height: 32px;"></a></td>
					    </tr>
					<?php endforeach; ?>
    				</tbody>
    			    </table>
			    <?php else: ?>
    			    <p>Oups, il y a un problème avec la BDD...</p>
			    <?php endif ?>			    
			</section>
		    </article>
		</div>
            </div> <!-- #main -->
        </div> <!-- #main-container -->

        <div class="footer-container">
	    <?php include_once 'inc/footer.php'; ?>
        </div>
	<script src="js/kickstart.js"></script> <!-- KICKSTART -->
        <script src="js/main.js"></script>
    </body>
</html>


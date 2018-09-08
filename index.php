<?php
/*************************************
 * @project: 	Xenomorph
 * @file:     Index page
 * @author: 	Mickaël POLLET
 *************************************/

// Déclaration de l'autoload
require __DIR__ . '/vendor/autoload.php';



try {

	try {

		// Chargement des paramètres vitaux
		if (!file_exists('system.php')) {
			$error_message = 'Impossible d\'accéder au script du system du framework.';
			include ('views/critical_error.vew.php');
			exit;
		}
		require_once('system.php');

		// Chargement des configurations
		if (!file_exists(SITE_ROOT.XCONFIG_PATH.'XConfig_load.php')) {
			$error_message = 'Impossible d\'accéder au script de chargement des configurations du framework.';
			include ('views/critical_error.vew.php');
			exit;
		}
		require_once(SITE_ROOT.XCONFIG_PATH.'XConfig_load.php');

	} catch (PDOException $pdo) {
		throw new XException('0005'.$pdo->errorInfo[1], 4, array( 0 => $pdo->errorInfo[2] ));
	}
} catch (XException $Xe) { // FIN Try
	// Affichage du message d'erreur
	switch ($Xe->getCriticity()) {
		case 1: 	$_SESSION['XMessages']['INFO'][] =		$Xe->getMessage();	break;
		case 2:		$_SESSION['XMessages']['SUCCESS'][] =	$Xe->getMessage();	break;
		case 3:		$_SESSION['XMessages']['WARNING'][]	=	$Xe->getMessage();	break;
		case 4:		$_SESSION['XMessages']['ERROR'][]	=	$Xe->getMessage();	break;
		case 5:		$_SESSION['XMessages']['ERROR'][] =		$Xe->getMessage();	break;
		default:	$_SESSION['XMessages']['INFO'][] =		$Xe->getMessage();	break;
	}
}





























echo "<h1>XENOMORPH - Framework</h1>";

echo "Hello world";


?>

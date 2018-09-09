<?php
/*************************************
 * @project: 	Xenomorph
 * @file:     Index page
 * @author: 	Mickaël POLLET
 *************************************/

try {

	try {

		// Déclaration des variables
		global $XDebug_lvl;																													// Déclaration de la variable globale qui indique le niveau de debug
		$XDebug_lvl = 5;																														// Définition du niveau minimum d'affichage des messages de debug
		$site_root = __DIR__;																												// Définition du répertoire par défaut pour le Framework

		/************************************************************************/
		/*					Chargement des fonctions basiques du Framework							*/
		/************************************************************************/

		if (!file_exists($site_root . '/toolbox/XToolbox.php')) {										// Si le fichier des fonctions basiques du Framework n'existe pas...
			$error_message = "Impossible d'accéder au script de chargement des fonctions basiques du framework.";	// On prépare le message d'erreur l'indiquant
			include ('views/critical_error.vew.php');																	// On inclue la vue spécifique des erreurs systèmes pour l'afficher
			exit;																																			// On stoppe le chargement
		} else {																																		// SINON...
			require_once($site_root . '/toolbox/XToolbox.php');												// On charge les fonctions basiques du Framework
		}

		XDebugger("===== Démarrage du chargement du Framework =====", 0);

		/************************************************************************/
		/*					Vérification de l'existence des dépendances Composer				*/
		/************************************************************************/

		XDebugger("----- Vérification de l'existence des dépendances Composer ------", 0);

		if (!file_exists($site_root . '/vendor/autoload.php')) {										// SI le fichier de chargement des dépendances Composer n'existe pas...
			require_once($site_root . '/services/installation_framework.php');				// On charge le fichier d'installation du Framework
		} else {
			require $site_root . '/vendor/autoload.php';															// Chargement des dépendances
		}

		XDebugger("----- FIN Vérification de l'existence des dépendances Composer ------", 0);

		/************************************************************************/
		/*				Vérification de l'existence du répertoire d'application				*/
		/************************************************************************/

		XDebugger("----- Vérification de l'existence du répertoire d'application ------", 0);

		if (!file_exists($site_root . '/application/')) {														// SI il n'existe pas...
			require_once($site_root . '/services/installation_application.php');			// On charge le script d'installation d'une nouvelle application
		} else {																																		// SINON...
			define("APPLICATION_ROOT", "/application/");															// On charge la constante pour utiliser le répertoire de l'application
		}

		XDebugger("----- FIN Vérification de l'existence du répertoire d'application ------", 0);

		/************************************************************************/
		/*							Chargement des paramètres critiques											*/
		/************************************************************************/

		XDebugger("----- Chargement des paramètres critiques ------", 0);

		if (!file_exists($site_root . '/config/XSystem.php')) {											// Si le fichier d'initialisation système du Framework n'existe pas...
			$error_message = "Impossible d'accéder au script system du framework.";		// On prépare le message d'erreur l'indiquant
			include ('views/critical_error.vew.php');																	// On inclue la vue spécifique des erreurs systèmes pour l'afficher
			exit;																																			// On stoppe le chargement
		} else {																																		// SINON...
			require_once($site_root . '/config/XSystem.php');													// On charge le fichier d'initialisation système du Framework
		}

		XDebugger("----- FIN Chargement des paramètres critiques ------", 0);

		/************************************************************************/
		/*									Chargement des configurations												*/
		/************************************************************************/

		XDebugger("----- Chargement des configurations ------", 0);

		if (!file_exists(SITE_ROOT.XCONFIG_PATH.'XConfig_load.php')) {
			$error_message = "Impossible d'accéder au script de chargement des configurations du framework.";
			include ('views/critical_error.vew.php');
			exit;
		} else {
			require_once(SITE_ROOT.XCONFIG_PATH.'XConfig_load.php');
		}

		XDebugger("----- FIN Chargement des configurations ------", 0);

		XDebugger("===== Fin du chargement du Framework =====", 0);

	} catch (PDOException $pdo) {
		throw new XException('0005'.$pdo->errorInfo[1], 4, array( 0 => $pdo->errorInfo[2] ));
	}

} catch (XException $Xe) {
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

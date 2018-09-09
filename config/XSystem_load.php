<?php
/*************************************
 * @project: 	Xenomorph
 * @file:		System Configuration Loadder
 * @author: 	Mickaël POLLET
 *************************************/

XDebugger("===== Chargement du System Configuration Loadder =====", 0);

/************************************************************/
/*					Chargement des Paramètres critiques 						*/
/************************************************************/

	XDebugger("----- Chargement des Paramètres critiques ------", 0);

	// Déclaration des variables globales
	global $XConfig;																																// Variable globale pour les fichiers de configuration du Framework
	global $global_config;																													// Variable globale pour les fichiers de configuration de l'application
	global $XSystem_rights;																													// Variable globale pour les droits de l'application

	// Décalration des noms de fichier
	$framework_config_file = 'XConfig.ini';
	$application_config_file = 'config.ini';
	$specific_application_config_file = 'application.ini';

	// Définition de la zone de temps
	date_default_timezone_set('Europe/Paris');

	XDebugger("----- FIN Chargement des Paramètres critiques ------", 0);

/************************************************************/
/*	Chargement des fichiers de configuration du framework 	*/
/************************************************************/

	XDebugger("----- Chargement des fichiers de configuration du framework ------", 0);

	// Vérification de l'existance du fichier de configuration du framework
	if(!file_exists(SITE_ROOT.XCONFIG_PATH.$framework_config_file)) {
		throw new Exception("Fichier de configuration du framework introuvable à l'adresse : \"".SITE_ROOT.XCONFIG_PATH.$framework_config_file."\"");
	}

	// Vérification des droits du fichier de configuration du framework
	if(!is_writable(SITE_ROOT.XCONFIG_PATH.$framework_config_file)) {
		throw new Exception("Droits insuffisants sur le fichier de configuration du framework : \"".$framework_config_file."\"");
	}

	// Chargement du fichier de configuration du Framework
	$XConfig = parse_ini_file(SITE_ROOT.XCONFIG_PATH.$framework_config_file, true);

	// Vérification de l'architecture du framework
	foreach ($XConfig['framework_architecture'] as $Xarch_key => $Xarch_value) {

		if (!file_exists($Xarch_value)) {
			syslog(LOG_ERR, "La ressource système ".$Xarch_value." est introuvable");
			$error_message = "La ressource système ".$Xarch_value." est introuvable".'<br/>Impossible de définir l\'architecture du framework.';
			include ('views/critical_error.vew.php');
		}

		if (!is_dir($Xarch_value)) {
			syslog(LOG_ERR, "La ressource système ".$Xarch_value." n'est pas un dossier");
			$error_message = "La ressource système ".$Xarch_value." n'est pas un dossier".'<br/>Impossible de définir l\'architecture du framework.';
			include ('views/critical_error.vew.php');
		}

		// Définition de constantes avec l'architecture déclarée dans le fichier de configuration
		define(strtoupper($Xarch_key), $Xarch_value);
	}

	// Définition de la sous-architecture du framework
	foreach ($XConfig['sub_architecture'] as $XSub_arch_key => $XSub_arch_value) {
		define(strtoupper($XSub_arch_key), $XSub_arch_value);			// Définition de constantes avec l'architecture déclarée dans le fichier de configuration
	}

	XDebugger("----- FIN Chargement des fichiers de configuration du framework ------", 0);

/****************************************************************/
/*	Chargement des fichiers de configuration de l'application		*/
/****************************************************************/

	XDebugger("----- Chargement des fichiers de configuration de l'application ------", 0);

	// Vérification de l'existance du fichier de configuration de l'application
	if(!file_exists(SITE_ROOT.APPLICATION_ROOT.CONFIG_DIR.$application_config_file)) {
		throw new Exception("Fichier de configuration de l'application introuvable à l'adresse : \"".SITE_ROOT.APPLICATION_ROOT.CONFIG_DIR.$application_config_file."\"");
	}

	// Vérification des droits du fichier de configuration
	if(!is_writable(SITE_ROOT.APPLICATION_ROOT.CONFIG_DIR.$application_config_file)) {
		throw new Exception("Droits insuffisants sur le fichier de configuration de l'application : \"".SITE_ROOT.APPLICATION_ROOT.CONFIG_DIR.$application_config_file."\"");
	}

	$global_config = parse_ini_file(SITE_ROOT.APPLICATION_ROOT.CONFIG_DIR.$application_config_file, true);

	// Définition de l'architecture de l'application
	foreach ($global_config['architecture'] as $arch_key => $arch_value) {
		if (!file_exists(SITE_ROOT.$arch_value)) {
			throw new Exception("La ressource applicative ".$arch_value." est introuvable");
		}
		if (!is_dir(SITE_ROOT.$arch_value)) {
			throw new Exception("La ressource applicative ".$arch_value." n'est pas un dossier");
		}
		define(strtoupper($arch_key), SITE_ROOT.$arch_value);			// Définition de constantes avec l'architecture déclarée dans le fichier de configuration
	}

	// Définition de la sous-architecture de l'application
	foreach ($global_config['sub_architecture'] as $sub_arch_key => $sub_arch_value) {
		define(strtoupper($sub_arch_key), $sub_arch_value);				// Définition de constantes avec l'architecture déclarée dans le fichier de configuration
	}

	// Vérification de l'existance du dossier contenant le Wrapper
	if (!file_exists(SITE_ROOT.WRAPPER_DIR)) {
		$error_message = 'Impossible d\'accéder au dossier Wrapper du framework.';
		include ('views/critical_error.vew.php');
		exit;
	}

	// Vérification de l'existance du dossier contenant les outils du Framework
	if (!file_exists(SITE_ROOT.TOOLBOX_DIR)) {
		$error_message = 'Impossible d\'accéder au dossier Toolbox du framework.';
		include ('views/critical_error.vew.php');
		exit;
	}

	XDebugger("----- FIN Chargement des fichiers de configuration de l'application ------", 0);

/****************************************************************************/
/*	Chargement des fichiers de configuration spécifiques de l'application		*/
/****************************************************************************/

	XDebugger("----- Chargement des fichiers de configuration spécifiques de l'application ------", 0);

	// Vérification de l'existance du fichier de configuration de l'application
	if(!file_exists(SITE_ROOT.APPLICATION_ROOT.CONFIG_DIR.$specific_application_config_file)) {
		throw new Exception("Fichier de configuration spécifique de l'application introuvable à l'adresse : \"".SITE_ROOT.APPLICATION_ROOT.CONFIG_DIR.$specific_application_config_file."\"");
	}

	// Vérification des droits du fichier de configuration
	if(!is_writable(SITE_ROOT.APPLICATION_ROOT.CONFIG_DIR.$specific_application_config_file)) {
		throw new Exception("Droits insuffisants sur le fichier de configuration spécifique de l'application : \"".SITE_ROOT.APPLICATION_ROOT.CONFIG_DIR.$specific_application_config_file."\"");
	}

	$specific_global_config_parsing = parse_ini_file(SITE_ROOT.APPLICATION_ROOT.CONFIG_DIR.$specific_application_config_file, true);

	foreach ($specific_global_config_parsing as $specific_global_config_parsing_key => $specific_global_config_parsing_value) {
		$global_config[$specific_global_config_parsing_key] = $specific_global_config_parsing_value;
	}

	XDebugger("----- FIN Chargement des fichiers de configuration spécifiques de l'application ------", 0);

/************************************************************/
/*									Chargement du Wrapper										*/
/************************************************************/

	XDebugger("----- Chargement du Wrapper ------", 0);

	if (!file_exists(SITE_ROOT.WRAPPER_DIR.'XWrapper.php')) {
		$error_message = 'Impossible d\'accéder au script XWrapper du framework.';
		include ('views/critical_error.vew.php');
		exit;
	} else {
			require_once(SITE_ROOT.WRAPPER_DIR.'XWrapper.php');
	}

	XDebugger("----- FIN Chargement du Wrapper ------", 0);

/************************************************************/
/*					Chargement des fichiers de fonctions						*/
/************************************************************/

	XDebugger("----- Chargement des fichiers de fonctions ------", 0);

	$available_tools_scan = scandir(SITE_ROOT.TOOLBOX_DIR);

	foreach ($available_tools_scan as $tool_key => $tool_value) {
		if ($tool_value != '.' && $tool_value != '..') {
			require_once(SITE_ROOT.TOOLBOX_DIR.$tool_value);
		}
	}

	XDebugger("----- FIN Chargement des fichiers de fonctions ------", 0);

/************************************************************/
/*							Auto-Chargement des classes 								*/
/************************************************************/

	XDebugger("----- Auto-Chargement des classes ------", 0);

	spl_autoload_register('classLoading');							// On enregistre la fonction en autoload pour qu'elle soit appelée dès qu'on instanciera une classe non déclarée.

	XDebugger("----- FIN Auto-Chargement des classes ------", 0);

/************************************************************/
/*			Chargement du connecteur à la base de données				*/
/************************************************************/

	XDebugger("----- Chargement du connecteur à la base de données ------", 0);

	if (!file_exists(SITE_ROOT.XCONFIG_PATH.'XDataBase_connector.php')) {
		$error_message = 'Impossible d\'accéder au script de connexion à la base du framework.';
		include ('views/critical_error.vew.php');
		exit;
	} else {
			require_once(SITE_ROOT.XCONFIG_PATH.'XDataBase_connector.php');
	}

	XDebugger("----- FIN Chargement du connecteur à la base de données ------", 0);

/************************************************************/
/*							Chargement du module d'erreurs 							*/
/************************************************************/

	XDebugger("----- Chargement du module d'erreurs ------", 0);

	function XSystemError($code, $message, $fichier, $ligne) {

		switch ($code) {
			case 1:			$XCode = 4;	break;
			case 2:			$XCode = 4;	break;
			case 8:			$XCode = 4;	break;
			case 16:		$XCode = 5;	break;
			case 32:		$XCode = 3;	break;
			case 256:		$XCode = 4;	break;
			case 512:		$XCode = 3;	break;
			case 1024:	$XCode = 1;	break;
			default:		$XCode = 4;	break;
		}

		throw new XException('00010009', $XCode, array( 0 => $message ), 0, $fichier, $ligne);
	}

	function XUncaughtException($e) {
		echo "ERREUR : \nLigne : ". $e->getLine() . "\nFichier : " . $e->getFile() . "\n<strong>Exception</strong> : " . $e->getMessage();
	}

	set_exception_handler('XUncaughtException');
	set_error_handler('XSystemError');

	XDebugger("----- FIN Chargement du module d'erreurs ------", 0);

XDebugger("===== FIN Chargement du System Configuration Loadder =====", 0);

?>

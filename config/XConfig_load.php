<?php
/*************************************
 * @project: 	Xenomorph
 * @file:		Configuration Loadder
 * @author: 	Mickaël POLLET
 *************************************/

XDebugger("===== Chargement du Configuration Loadder =====", 0);

/****************************************************************/
/*						Chargement des paramètres système									*/
/****************************************************************/

	XDebugger("----- Chargement des paramètres système ------", 0);

	if (!file_exists(SITE_ROOT.XCONFIG_PATH.'XSystem_load.php')) {
		$error_message = 'Impossible d\'accéder au script de chargement du system du framework.';
		include ('views/critical_error.vew.php');
		exit;
	} else {
		require_once(SITE_ROOT.XCONFIG_PATH.'XSystem_load.php');
	}

	XDebugger("----- FIN Chargement des paramètres système ------", 0);

/****************************************************************/
/*				Chargement de l'arbre des droits système							*/
/****************************************************************/

	XDebugger("----- Chargement de l'arbre des droits système ------", 0);

	$system_rights_manager = new XRightManager();
	$system_rights = $system_rights_manager->getList();

	if (!$system_rights) {
		$error_message = 'Impossible d\'accéder aux droits d\'utilisateur.';
		include ('views/critical_error.vew.php');
		exit;
	}

	foreach ($system_rights as $system_rights_key => $system_rights_value) {
		$XSystem_rights[$system_rights_value->rights_level()] = $system_rights_value;
	}

	XDebugger("----- FIN Chargement de l'arbre des droits système ------", 0);

/****************************************************************/
/*						Chargement du moteur de chifrement								*/
/****************************************************************/

	XDebugger("----- Chargement du moteur de chifrement ------", 0);

	if (!file_exists(SITE_ROOT.LIBS_DIR.MIPICRYPT_DIR)) {
		$error_message = 'Impossible d\'accéder au dossier de cryptage Mipicrypt du framework.';
		include ('views/critical_error.vew.php');
		exit;
	}

	if (!file_exists(SITE_ROOT.LIBS_DIR.MIPICRYPT_DIR.'mipicrypt.php')) {
		$error_message = 'Impossible d\'accéder au script de cryptage Mipicrypt du framework.';
		include ('views/critical_error.vew.php');
		exit;
	} else {
		require_once(SITE_ROOT.LIBS_DIR.MIPICRYPT_DIR.'mipicrypt.php');
	}

	XDebugger("----- FIN Chargement du moteur de chifrement ------", 0);

/****************************************************************/
/*	Chargement de la session utilisateur ainsi que des langues	*/
/****************************************************************/

	XDebugger("----- Chargement de la session utilisateur ainsi que des langues ------", 0);

	if (!file_exists(SITE_ROOT.XCONFIG_PATH.'XSession.php')) {
		$error_message = 'Impossible d\'accéder au script de session du framework.';
		include ('views/critical_error.vew.php');
		exit;
	}
	require_once(SITE_ROOT.XCONFIG_PATH.'XSession.php');

	XDebugger("----- FIN Chargement de la session utilisateur ainsi que des langues ------", 0);

/****************************************************************/
/*						Chargement des paramètres spécifiques							*/
/****************************************************************/

	XDebugger("----- Chargement des paramètres spécifiques ------", 0);

	global $PostContainer;
	global $GetContainer;
	global $SessionContainer;
	global $ServerContainer;

	$PostContainer = array();
	$GetContainer = array();
	$SessionContainer = array();
	$ServerContainer = array();

	foreach ($_POST as $POST_key => $POST_value) {
		$PostContainer[$POST_key] =  $POST_value;
	}

	foreach ($_GET as $GET_key => $GET_value) {
		$GetContainer[$GET_key] =  $GET_value;
	}

	foreach ($_SESSION as $SESSION_key => $SESSION_value) {
		$SessionContainer[$SESSION_key] =  $SESSION_value;
	}

	foreach ($_SERVER as $SERVER_key => $SERVER_value) {
		$ServerContainer[$SERVER_key] =  $SERVER_value;
	}

	XDebugger("----- FIN Chargement des paramètres spécifiques ------", 0);

/********************************************************************/
/*		Chargement du fichier de configuration de l'application				*/
/********************************************************************/

	XDebugger("----- Chargement du fichier de configuration de l'application ------", 0);

	if (!file_exists(SITE_ROOT.CONFIG_DIR.'config_load.php')) {
		$error_message = 'Impossible d\'accéder au script de configuration de l\'application.';
		include ('views/critical_error.vew.php');
		exit;
	} else {
			require_once(SITE_ROOT.CONFIG_DIR.'config_load.php');
	}

	XDebugger("----- FIN Chargement du fichier de configuration de l'application ------", 0);

/************************************************************/
/*					Chargement des fichiers de version 							*/
/************************************************************/

	XDebugger("----- Chargement des fichiers de version ------", 0);

	global $XVersion;
	$XVersion = new XVersion();

	XDebugger("----- FIN Chargement des fichiers de version ------", 0);

XDebugger("===== FIN Chargement du Configuration Loadder =====", 0);
?>

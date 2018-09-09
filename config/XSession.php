<?php
/*************************************
 * @project: 	Xenomorph
 * @file:		Session loadding page
 * @author: 	Mickaël POLLET
 *************************************/

// Démarrage de la session
session_name(globalConfig('application', 'app_name'));

ini_set('session.gc_maxlifetime', globalConfig('security', 'session_time'));
ini_set('session.use_trans_sid', 0);
ini_set('session.use_only_cookies', 1);
//ini_set('session.cookie_domain' , globalConfig('core', 'host'));
ini_set('session.hash_function', 'sha512');
ini_set('session.hash_bits_per_character', 5);

if (globalConfig('core', 'protocol') == 'http') {
	ini_set('session.cookie_httponly', 1);
} else {
	ini_set('session.cookie_secure', 1);
}

session_start();

// Préparation du tableau des messages
$_SESSION['XMessages'] = array(	'ERROR' => array(), 'WARNING' => array(), 'INFO' => array(), 'SUCCESS' => array());

// Vérification du token de session
$session_params = new XSessionManager();

if (isset($_SESSION['token']) && isset($_SESSION['user_key'])) {
	if (!$session_params->check($_SESSION['token'], $_SESSION['user_key'])) {
		header('Location:index.php?page=logout');
		exit();
	}
} else {

	// Vérification d'une connextion par SSO
	if (isset($_GET['XSso']) && !empty($_GET['XSso'])) {
		$XSso = new XSsoManager();
		$XSsoCheck = $XSso->check($_GET['XSso']);
		if (!$XSsoCheck) {
			if (!isset($_GET['page']) || $_GET['page'] != 'login') {
				header('Location:index.php?page=login');
				exit();
			}
		} else {
			$session_params = new XSessionManager();
			$session_params_token = $session_params->initialize($XSsoCheck);

			foreach ($session_params_token as $session_params_token_key => $session_params_token_value) {
				$_SESSION[$session_params_token_key] = $session_params_token_value;
			}

			header('Location:index.php');
			exit();
		}
	}

	if (!isset($_GET['page']) || $_GET['page'] != 'login') {
		header('Location:index.php?page=login');
		exit();
	}
}

// Chargement des fichiers de langue
$languages = new XLanguageManager();												// Démarrage du Manager
$languages->load(globalConfig('application', 'default_lang'));						// Chargement de la langue par défaut pour avoir les variables de langue par défaut
$available_languages = $languages->getList();										// Chargement de la liste des langues

// Paramétrage de la langue à charger
if (!isset($_SESSION['lang'])) {
	$_SESSION['lang'] = globalConfig('application', 'default_lang');
} else if (isset($_GET['lang'])) {
	if (array_key_exists($_GET['lang'], $available_languages)) {
		$user_manager = new UserManager();
		$current_user = $user_manager->get($_SESSION['session_user']->mail());
		$current_user->setLang($_GET['lang']);
		$user_manager->update($current_user);
		$_SESSION['lang'] = $_GET['lang'];
	} else {
		$_SESSION['lang'] = globalConfig('application', 'default_lang');
		$_SESSION['XMessages']['ERROR'][] = "Cette langue n'est pas disponible";
	}
}

/************************************************************/
/*					Chargement de la langue 				*/
/************************************************************/
$languages->load($_SESSION['lang']);
?>
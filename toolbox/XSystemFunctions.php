<?php
/*************************************
 * @project: 	Xenomorph
 * @file:		System functions page
 * @author: 	Mickaël POLLET
 *************************************/

/************************************************************/
/*				Traitement des fichiers de langue 			*/
/************************************************************/

// Chargement des classes
function classLoading($class)	{

	if (!file_exists(SITE_ROOT.XMODELS_DIR)) {
		$error_message = 'Impossible d\'accéder au dossier models du framework.';
		syslog(LOG_ERR, $error_message);
		include ('views/critical_error.vew.php');
		exit;
	}

	if (!file_exists(SITE_ROOT.XMODELS_DIR.MANAGERS_DIR)) {
		$error_message = 'Impossible d\'accéder au dossier models manager du framework.';
		syslog(LOG_ERR, $error_message);
		include ('views/critical_error.vew.php');
		exit;
	}

	if (!file_exists(SITE_ROOT.APPLICATION_ROOT.MODELS_DIR.MANAGERS_DIR)) {
		$error_message = 'Impossible d\'accéder au dossier models manager de l\'application.';
		syslog(LOG_ERR, $error_message);
		include ('views/critical_error.vew.php');
		exit;
	}

	if (!file_exists(SITE_ROOT.APPLICATION_ROOT.MODELS_DIR)) {
		$error_message = 'Impossible d\'accéder au dossier models de l\'application.';
		syslog(LOG_ERR, $error_message);
		include ('views/critical_error.vew.php');
		exit;
	}

	switch ($class) {

		// Chargement d'un Manager framework
		case preg_match("#^X[A-Z]{1}.*Manager$#", $class) == 1:
			require SITE_ROOT.XMODELS_DIR.MANAGERS_DIR.$class.'.class.php';
			break;

		// Chargement d'une classe framework
		case preg_match("#^X[A-Z].*#", $class) == 1:
			require SITE_ROOT.XMODELS_DIR.$class.'.class.php';
			break;

		// Chargement d'un Manager application
		case preg_match("#^[A-Z]{1}.*Manager$#", $class) == 1:
			require SITE_ROOT.APPLICATION_ROOT.MODELS_DIR.MANAGERS_DIR.$class.'.class.php';
			break;

		// Chargement d'un Web service
		case preg_match("#^[A-Z]{1}.*WS$#", $class) == 1:
			if (!file_exists(SITE_ROOT.APPLICATION_ROOT.MODELS_DIR.WSCLASSES_DIR)) {
				$error_message = 'Impossible d\'accéder au dossier models webservice de l\'application.';
				include ('views/critical_error.vew.php');
				exit;
			}
			require SITE_ROOT.APPLICATION_ROOT.MODELS_DIR.WSCLASSES_DIR.$class.'.class.php';
			break;

		// Chargement de mipicrypt
		case 'Mipicrypt':
			require_once(SITE_ROOT.MIPICRYPT_DIR.'mipicrypt.php');
			break;

		// Chargement d'une classe application
		default:
			require SITE_ROOT.MODELS_DIR.$class.'.class.php';
			break;
	}
}

// Récupération d'une valeur du fichier de configuration du framework
function XConfig($domain, $expression = null) {
	global $XConfig;
	if ($expression == null) {
		return $XConfig[$domain];
	} else {
		return $XConfig[$domain][$expression];
	}
}

// Récupération d'une valeur du fichier de configuration global
function globalConfig($domain, $expression = null) {
	global $global_config;
	if ($expression == null) {
		return $global_config[$domain];
	} else {
		return $global_config[$domain][$expression];
	}
}

// Affichage d'une valeur du fichier de langue chargé
function userLang($domain, $expression = null, $parameters = array() ) {
	global $global_lang;
	$message = "";

	try  {
		if ($expression == null) {
			$message = $global_lang[$domain];
		} else {
			$message = $global_lang[$domain][$expression];
		}
		if (count($parameters) > 0) {
			for ($i = 0; $i < count($parameters); $i++) {
				$message = str_replace('{{'.$i.'}}', $parameters[$i], $message);
			}
		}
	} catch (XException $e) {
		throw new XException("00010012", 4, array(0 => '['.$domain.']'.$expression, 1 => $_SESSION['lang']), true);
	}
	return $message;
}

function decodingDatas($datas) {
	if (mb_detect_encoding($datas, 'UTF-8', true)) {
		return utf8_decode($datas);
	} else {
		return $datas;
	}
}

function circlesTextSize($digit) {
	switch ($digit) {
		case $digit > 8:
			return "1.3vw";
			break;

		case $digit > 6:
			return "1.4vw";
			break;

		default:
			return "1.5vw";
			break;
	}
}

function is_json($string) {
	return ((is_string($string) &&
			(is_object(json_decode($string)) ||
			is_array(json_decode($string))))) ? true : false;
}

function inArray($search, $array) {
	foreach ($array as $array_key => $array_value) {
		if (is_array($array_value)) {
			if (inArray($search, $array_value)) {
				return true;
			}
		} else {
			if ($array_key === $search || $array_value === $search) {
				return true;
			}
		}
	}
	return false;
}

// Récupération de la branche GIT courante
function gitBranch() {
	$currentHead = file(SITE_ROOT.'/.git/HEAD', FILE_USE_INCLUDE_PATH);
	$currentHeadLine = $currentHead[0];
	$branchString = explode("/", $currentHeadLine, 3);
	$branchName = $branchString[2];
	return trim($branchName);
}

?>

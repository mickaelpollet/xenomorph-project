<?php
/*************************************
 * @project: 	Xenomorph
 * @file:		Pages Wrapper
 * @author: 	Mickaël POLLET
 *************************************/

function XControllerWrapper($controller_name) {

	global $XConfig;
	global $global_config;
	global $XSystem_rights;

	$page_name = "";
	$page_title = "";
	$args = null;

	$delay = XConfig('general_config', 'delay_refresh');

	if (isset($_POST['refreshOff'])) {
		XCookieManager::delete("refresh", "isRefresh");
	}

	else if (isset($_POST['refreshOn'])) {
		XCookieManager::add(new XCookie(array("category" => "refresh", "name" => "isRefresh", "value" => 1, "timeout" => 3600)));
		header("Refresh: ".$delay.";url=index.php?page=".$_GET['page']);
	} else {
		if (isset($_GET['page']) && XCookieManager::getByName("refresh", "isRefresh")) {
			header("Refresh: ".$delay.";url=index.php?page=".$_GET['page']);
		}
	}

	try {

		try {
			if (!file_exists(CONTROLLERS_DIR.$controller_name)) {
				throw new XException('0005'.$pdo->errorInfo[1], 4, array( 0 => $pdo->errorInfo[2] ));
			}
			include(CONTROLLERS_DIR.$controller_name);
		} catch (PDOException $pdo) {
			throw new XException('0005'.$pdo->errorInfo[1], 4, array( 0 => $pdo->errorInfo[2] ));
		}

	} catch (XException $Xe) { // FIN Try
		// Affichage du message d'erreur
		switch ($Xe->getCriticity()) {
			case 1:		$_SESSION['XMessages']['INFO'][]	=	$Xe->getMessage();	break;
			case 2:		$_SESSION['XMessages']['SUCCESS'][]	=	$Xe->getMessage();	break;
			case 3:		$_SESSION['XMessages']['WARNING'][]	=	$Xe->getMessage();	break;
			case 4:		$_SESSION['XMessages']['ERROR'][]	=	$Xe->getMessage();	break;
			case 5:		$_SESSION['XMessages']['ERROR'][]	=	$Xe->getMessage();	break;
			default:	$_SESSION['XMessages']['INFO'][]	=	$Xe->getMessage();	break;
		}
		if ($page_name != "empty" && $page_name != "no_right" && $page_name != "login" && $page_name != "pwd") {
			$page_name = "error";
			$page_title = "error";
			$args = $Xe;
		}

	}
	XViewWrapper($page_name, $page_title, $args);
}

function XViewWrapper($page_name, $page_title = null, $args = null) {
	global $available_languages;

	if (!file_exists(SITE_ROOT.VIEWS_DIR)) {
		$error_message = 'Impossible d\'accéder au répertoire des vues.';
		syslog(LOG_ERR, $error_message);
				include ('views/critical_error.vew.php');
		exit;
	}
	if (!file_exists(SITE_ROOT.VIEWS_DIR.$page_name.'.vew.php')) {
		$error_message = 'Impossible d\'accéder à la vue '.$page_name.'.';
		syslog(LOG_ERR, $error_message);
		include ('views/critical_error.vew.php');
		exit;
	}
	if ($page_name != 'error' && $page_name != 'login' && $page_name != 'pwd') {
		if (!file_exists(LIBS_DIR.FRAMEWORK_DIR.WRAPPER_DIR.'XPage_header.php')) {
			throw new XException('0005'.$pdo->errorInfo[1], 4, array( 0 => $pdo->errorInfo[2] ));
		}
		include(LIBS_DIR.FRAMEWORK_DIR.WRAPPER_DIR.'XPage_header.php');
	}

	include(SITE_ROOT.VIEWS_DIR.$page_name.'.vew.php');

	if ($page_name != 'error' && $page_name != 'login' && $page_name != 'pwd') {
		if (!file_exists(LIBS_DIR.FRAMEWORK_DIR.WRAPPER_DIR.'XPage_footer.php')) {
			throw new XException('0005'.$pdo->errorInfo[1], 4, array( 0 => $pdo->errorInfo[2] ));
		}
		include(LIBS_DIR.FRAMEWORK_DIR.WRAPPER_DIR.'XPage_footer.php');
	}
}

?>

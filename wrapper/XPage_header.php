<?php
/*************************************
 * @project:    Xenomorph
 * @file:       Pages header
 * @author:     Mickaël POLLET
 *************************************/

echo '
<!DOCTYPE html>

	<html xmlns="http://www.w3.org/1999/xhtml" ng-app="'.mb_strtolower(globalConfig('application', 'app_name')).'" lang="'.$_SESSION['lang'].'">

	<head>
	<meta charset="'.globalConfig('application', 'global_encodage').'">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">';

if ($page_title != null) {
	echo '<title>'.strtoupper(globalConfig('application', 'app_name')).' - '.ucfirst($page_title).'</title>';
} else {
	echo '<title>'.strtoupper(globalConfig('application', 'app_name')).'</title>';
}

echo '
	<!-- Bootstrap -->
	<!-- <link href="'.CSS_DIR.'bootstrap.css" rel="stylesheet">
	<link href="'.CSS_DIR.'bootstrap-theme.css" rel="stylesheet"> -->
	<link href="'.CSS_DIR.'bootstrap.min.css" rel="stylesheet">
	<link href="'.CSS_DIR.'bootstrap-theme.min.css" rel="stylesheet">
	<!-- GlyphIcons Pro -->
	<link href="'.CSS_DIR.'glyphicons-filetypes.css" rel="stylesheet">
	<link href="'.CSS_DIR.'glyphicons-halflings.css" rel="stylesheet">
	<link href="'.CSS_DIR.'glyphicons-social.css" rel="stylesheet">
	<link href="'.CSS_DIR.'glyphicons.css" rel="stylesheet">
	<!-- Toastr -->
	<!-- <link href="'.CSS_DIR.'toastr.css" rel="stylesheet" /> -->
	<link href="'.CSS_DIR.'toastr.min.css" rel="stylesheet" />
	<!-- Framework -->
	<link href="'.LIBS_DIR.FRAMEWORK_DIR.CSS_DIR.'XMain.css" rel="stylesheet">
	<!-- Application -->
	<link href="'.CSS_DIR.'main.css" rel="stylesheet">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn\'t work if you view the page via file:// -->
	<!--[if lt IE 9]>
	  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

	<!--[if lt IE 10]>
		<div style="position:relative; color:#fff; top:0px; width:100%; height:40px; background-color:#A0152D; margin-top:0px; padding:5px; border-bottom:solid 5px #791022; text-align: center">
			<p>Cette application a été conçue pour fonctionner <b>à partir de la version 10 d\'Internet Explorer</b>. Mettez votre navigateur à jour ou utilisez un navigateur alternatif.</p>
		</div>
	<![endif]-->';

echo '</head>

<body>';

// Menu HAUT
if (!file_exists(LIBS_DIR.FRAMEWORK_DIR.WRAPPER_DIR.'XTop_menu.php')) {
	$error_message = 'Impossible d\'accéder au script du menu haut.';
	include ('views/critical_error.vew.php');
	exit;
}
include(LIBS_DIR.FRAMEWORK_DIR.WRAPPER_DIR.'XTop_menu.php');

echo '<div class="container-fluid">
<div class="row">';

if (!file_exists(LIBS_DIR.FRAMEWORK_DIR.WRAPPER_DIR.'XLeft_menu.php')) {
	$error_message = 'Impossible d\'accéder au script du menu gauche.';
	include ('views/critical_error.vew.php');
	exit;
}
include(LIBS_DIR.FRAMEWORK_DIR.WRAPPER_DIR.'XLeft_menu.php');

echo '<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">';

// Chargement des messages à afficher
foreach ($_SESSION['XMessages']['ERROR'] as $XMessages_error_key => $XMessages_error_value) {
	echo showMessage($XMessages_error_value, 'error');
}
foreach ($_SESSION['XMessages']['WARNING'] as $XMessages_warning_key => $XMessages_warning_value) {
	echo showMessage($XMessages_warning_value, 'warning');
}
foreach ($_SESSION['XMessages']['INFO'] as $XMessages_info_key => $XMessages_info_value) {
	echo showMessage($XMessages_info_value, 'info');
}
foreach ($_SESSION['XMessages']['SUCCESS'] as $XMessages_success_key => $XMessages_success_value) {
	echo showMessage($XMessages_success_value, 'success');
}

?>
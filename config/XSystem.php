<?php
/*************************************
 * @project: 	Xenomorph
 * @file:		XSystem configuration page
 * @author: 	Mickaël POLLET
 *************************************/

/************************************************************************/
/*							Initialisation des paramètres critiques									*/
/************************************************************************/

XDebugger("----- Initialisation des paramètres critiques ------", 0);

$services_site_root = __DIR__ . "/../";     // Définition de la racine des services

define('XCONFIG_PATH', '/config/');         // Définition du répertoire contenant les fichiers de configuration du Framework

XDebugger("----- Définition du SITE_ROOT ------", 0);

// Définition du répertoire racine en fonction du contexte de chargement du Framework
if (isset($_SERVER['REQUEST_URI']) && preg_match('#\/wsdl\/servers\/#', $_SERVER['REQUEST_URI'])) {
  XDebugger("Root WebServices défini", 5);
  // Quand l'appel se fait par WebServices
 	define('SITE_ROOT', '../../');
} else if (!isset($_SERVER["REMOTE_ADDR"]) || (isset($_SERVER['REQUEST_URI']) && preg_match('#\/services\/#', $_SERVER['REQUEST_URI']))) {
  XDebugger("Root Services défini", 5);
  // Quand il s'agit de l'utilisation d'un service
	define('SITE_ROOT', $services_site_root);
} else {
  XDebugger("Root classique défini", 5);
  // Quand le Framework est chargé normalement
	define('SITE_ROOT', $site_root);
}

XDebugger("----- FIN Initialisation des paramètres critiques ------", 0);

?>

<?php
/*************************************
 * @project: 	Xenomorph
 * @file:		Globals fonctions page
 * @author: 	Mickaël POLLET
 *************************************/

/************************************************************************/
/*															SYSTEM																	*/
/************************************************************************/

	// Fonction de gestion du debug
	function XDebugger($msg, $crit = 1) {

		global $XDebug_lvl;															// Récupération de la variable globale de niveau de debugging
		$msg = utf8_decode($msg);												// Décodage UTF8 du message pour l'affichage

		// Préparation des syslog à afficher en fonction du niveau programmé
		if ($XDebug_lvl > 0 && $XDebug_lvl >= $crit) {
			switch ($XDebug_lvl) {
				case 5:	syslog(LOG_INFO, 		$msg);	break;
				case 4:	syslog(LOG_WARNING, $msg);	break;
				case 3:	syslog(LOG_ERR,			$msg);	break;
				case 2:	syslog(LOG_CRIT, 		$msg);	break;
				case 1:	syslog(LOG_DEBUG, 	$msg);	break;
			}
		}
	}

	// Fonction de suppression de l'arbre de répertoires
	function rrmdir($dir) {
		if (is_dir($dir)) {
			$objects = scandir($dir);
			foreach ($objects as $object) {
				if ($object != "." && $object != "..") {
					if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else unlink($dir."/".$object);
				}
			}
			reset($objects);
			rmdir($dir);
		}
	}

/************************************************************************/
/*															AFFICHAGE SITE													*/
/************************************************************************/

	// Affiche une icône Bootstrap en fonction de son nom
	function showGlyph($glyph_name, $type = 'glyphicons', $color = '', $params = '') {

		$type_possibilities = array('halflings', 'glyphicons', 'filetypes', 'social');

		if (!in_array($type, $type_possibilities)) {	throw new XException('00010001', 4, array( 0 => $type )); }

		if (empty($color)) {
			if (!empty($params)) {
				return '<span class=\''.$type.' '.$type.'-'.$glyph_name.'\' style=\''.$params.'\'></span>';
			} else {
				return '<span class=\''.$type.' '.$type.'-'.$glyph_name.'\'></span>';
			}
		} else {
			if (!empty($params)) {
				return '<span class=\''.$type.' '.$type.'-'.$glyph_name.'\' style=\'color:'.$color.';'.$params.'\'></span>';
			} else {
				return '<span class=\''.$type.' '.$type.'-'.$glyph_name.'\' style=\'color:'.$color.'\'></span>';
			}
		}
	}

	function userIconType($user) {
		$user_right_lvl = $user->rights()->rights_level();
		$rights_manager = new XRightManager();

		switch ($user_right_lvl) {
			case $user_right_lvl >= $rights_manager->get(8, 1)->rights_level():
				return '<span data-toggle="tooltip" data-placement="top" title="'.ucfirst(userLang('tooltips', 'adm')).'" data-toggle="tooltip">'.showGlyph('old-man', 'glyphicons', '#d9534f').'</span>';	break;
			case $user_right_lvl >= $rights_manager->get(7, 1)->rights_level():
				return '<span data-toggle="tooltip" data-placement="top" title="'.ucfirst(userLang('tooltips', 'cpt_appli')).'" data-toggle="tooltip">'.showGlyph('multiple-displays', 'glyphicons', '#5cb85c').'</span>';	break;
			case $user_right_lvl >= $rights_manager->get(6, 1)->rights_level() && $user_right_lvl < $rights_manager->get(7, 1)->rights_level():
				return '<span data-toggle="tooltip" data-placement="top" title="'.ucfirst(userLang('tooltips', 'manager')).'" data-toggle="tooltip">'.showGlyph('user', 'glyphicons', '#f0ad4e').'</span>';	break;
			case $user_right_lvl >= $rights_manager->get(5, 1)->rights_level() && $user_right_lvl < $rights_manager->get(7, 1)->rights_level():
				return '<span data-toggle="tooltip" data-placement="top" title="'.ucfirst(userLang('tooltips', 'validated')).'" data-toggle="tooltip">'.showGlyph('user', 'glyphicons', '#f0ad4e').'</span>';	break;
			case $user_right_lvl == $rights_manager->get(1, 1)->rights_level():
				return '<span data-toggle="tooltip" data-placement="top" title="'.ucfirst(userLang('tooltips', 'desactivated')).'" data-toggle="tooltip">'.showGlyph('user-ban', 'glyphicons', '#428bca').'</span>';	break;
		}
	}

	// Gestion des extensions possible de fichier
	function fileExtension($file) {
		$listFileExtension = array("txt", "doc", "rtf", "log", "tex" ,"msg", "text" ,
			"wpd" ,"wps", "docx", "page", "csc", "dat", "tar", "xml", "vcf", "pps", "key",
			"ppt", "pptx", "sdf", "gbr", "ged", "mp3", "m4a", "waw", "wma", "mpa", "iff",
			"aif", "ra", "mid", "m3v", "e-3gp", "swf", "avi", "asx", "mp4", "e-3g2", "mpg",
			"asf", "vob", "wmv", "mov", "srt", "m4v", "flv", "rm", "png", "psd", "psp",
			"jpg", "tif", "tiff", "vif", "bmp", "tgr", "thm", "yuv", "dds", "ai", "eps",
			"ps", "svg", "pdf", "pct", "indd", "xlr", "xls, xlsx", "db", "dbf", "mdb",
			"pdb", "sql", "aacd", "app", "exe", "com", "bat", "apk", "jar", "hsf", "pif",
			"vb", "cgi", "css", "js", "php", "xhtml", "htm", "html", "asp", "cer", "jsp",
			"cfm", "aspx", "rss", "csr", "less", "otf", "ttf", "font", "fnt", "eot", "woff",
			"zip", "zipx", "rar", "targ", "sitx", "deb", "e-7z", "pkg", "rpm", "cbr", "gz",
			"dmg", "cue", "bin", "iso", "hdf", "vcd", "bak", "tmp", "ics", "msi", "cfg",
			"ini", "prf", "json", "site", "xap", "api", "ico,webp", "bpg", "flac", "ogg");

		$myExtension = explode('.', $file)[count(explode('.', $file)) - 1];

		if (in_array($myExtension, $listFileExtension)) {	// Si on trouve l'extension dans la liste on la renvoie
			return $myExtension;
		} else {											// Si non on renvoie le format 'txt'
			return $listFileExtension[0];
		}
	}

	// ATTENTION : Il faut faire un echo pour l'affichage !
	function showLabel($label, $type = 'default') {
		return '<span class="label label-'.$type.'">'.$label.'</span>';
	}

	// Surligne en jaune fluo une chaîne de caractères
	function colorize($data, $search, $color = '#ffff66') {
		if ($search != '' && stristr($data, $search)) {
			return str_ireplace($search, '<span style="background-color:'.$color.';">'.$search.'</span>', $data);
		} else {
			return $data;
		}
	}

	// Affiche un message d'alerte
	// ATTENTION : Il faut faire un echo pour l'affichage !
	function showMessage($message, $type = 'info') {
		switch ($type) {
			case 'success':
				return '<div class="alert alert-success" role="alert"><b>'.showGlyph('ok').'</b> '.$message.'</div>';
				break;

			case 'info':
				return '<div class="alert alert-info" role="alert"><b>'.showGlyph('search').'</b> '.$message.'</div>';
				break;

			case 'warning':
				return '<div class="alert alert-warning" role="alert"><b>'.showGlyph('warning-sign').'</b> '.$message.'</div>';
				break;

			case 'error':
				return '<div class="alert alert-danger" role="alert"><b>'.showGlyph('remove').'</b> '.$message.'</div>';
				break;

			default:
				return '<div class="alert alert-info" role="alert"><b>'.showGlyph('search').'</b> '.$message.'</div>';
				break;
		}
	}

	// Pagination d'un ensemble de données
	function datasPagination($datas, $events_by_page, $page_needed) {
		$page_nbr = ceil(count($datas)/$events_by_page);
		$current_datas_paged = array_chunk($datas, $events_by_page, TRUE);
		if (!empty($datas)) {
			$datas_paged = array(	'page_number' => (int)$page_nbr,
									'page' => (int)$page_needed,
									'datas' => $current_datas_paged[($page_needed-1)]);
		} else {
			$datas_paged = array(	'page_number' => (int)$page_nbr,
									'page' => (int)$page_needed,
									'datas' => NULL);
		}

		return $datas_paged;
	}

	// Pied de pagination
	function paginationFooter($pages_number, $current_page, $url) {
		// Préparation des données
		$footer = '';

		// Début du footer
		$footer .= '	<nav>
							<ul class="pagination pagination-sm">';

		// "Page précédente"
		if ($current_page > 1) {
			$footer .= '		<li><a href="'.$url.''.($current_page-1).'" data-toggle="tooltip" data-placement="top" title="'.ucfirst(userLang('general', 'PREVIOUS_PAGE')).'"><span aria-hidden="true">&laquo;</span><span class="sr-only">Précédent</span></a></li>';
		} else {
			$footer .= '		<li class="disabled"><a href="" data-toggle="tooltip" data-placement="top" title="'.ucfirst(userLang('general', 'PREVIOUS_PAGE')).'"><span aria-hidden="true">&laquo;</span><span class="sr-only">Précédent</span></a></li>';
		}

		// Pages afichées
		if (($current_page-3) > 0) {
			$footer .= '		<li><a href="'.$url.'1">1</a></li>';
		}

		if (($current_page-3) > 0 && ($current_page-3) != 1) {
			$footer .= '		<li><a href="'.$url.''.($current_page-3).'">...</a></li>';
		}

		if (($current_page-2) > 0) {
			$footer .= '		<li><a href="'.$url.''.($current_page-2).'">'.($current_page-2).'</a></li>';
		}

		if (($current_page-1) > 0) {
			$footer .= '		<li><a href="'.$url.''.($current_page-1).'">'.($current_page-1).'</a></li>';
		}

		$footer .= '			<li class="active"><a href="'.$url.''.$current_page.'">'.$current_page.'</a></li>';

		if (($current_page+1) < $pages_number) {
			$footer .= '		<li><a href="'.$url.''.($current_page+1).'">'.($current_page+1).'</a></li>';
		}

		if (($current_page+2) < $pages_number) {
			$footer .= '		<li><a href="'.$url.''.($current_page+2).'">'.($current_page+2).'</a></li>';
		}

		if (($current_page+3) < ($pages_number-1)) {
			$footer .= '		<li><a href="'.$url.''.($current_page+3).'">...</a></li>';
		}

		if ($current_page < $pages_number) {
			$footer .= '		<li><a href="'.$url.''.$pages_number.'">'.$pages_number.'</a></li>';
		}

		// "Page suivante"
		if ($current_page < $pages_number) {
			$footer .= '		<li><a href="'.$url.''.($current_page+1).'" data-toggle="tooltip" data-placement="top" title="'.ucfirst(userLang('general', 'NEXT_PAGE')).'"><span aria-hidden="true">&raquo;</span><span class="sr-only">Suivant</span></a></li>';
		} else {
			$footer .= '		<li class="disabled"><a href="" data-toggle="tooltip" data-placement="top" title="'.ucfirst(userLang('general', 'NEXT_PAGE')).'"><span aria-hidden="true">&raquo;</span><span class="sr-only">Suivant</span></a></li>';
		}

		// Fin du footer
		$footer .= '		</ul>
						</nav>';

		return $footer;
	}

/************************************************************************/
/*													FONCTIONS DIVERSES													*/
/************************************************************************/

	// Export en CSV d'un tableau
	function arrayCsv($array, $file, $delimiter = ';') {
		// On crée le fichier $file si il n'existe pas
		if (!file_exists(pathinfo($file)['dirname'])) {
			mkdir(pathinfo($file)['dirname'], 0764, TRUE);
		}
		$file_to_open = fopen($file, 'a');

		// Pour chage ligne de l'array on écrit l'info sous format csv dans $file
		foreach ($array as $fields) {
			fprintf($file_to_open, chr(0xEF).chr(0xBB).chr(0xBF)); // On écrit le header du fichier pour gérer l'utf-8
			fputcsv($file_to_open, $fields, $delimiter);	// On écrit la ligne csv en fonction du délimiter dans $file_to_open
		}

		// On ferme le fichier
		fclose($file_to_open);
	}

	// Transforme les secondes en heure complète
	function TimeTransformation($time)	{
		if ($time>=86400)
		/* 86400 = 3600*24 c'est à dire le nombre de secondes dans un seul jour ! donc là on vérifie si le nombre de secondes donné contient des jours ou pas */
		{
		// Si c'est le cas on commence nos calculs en incluant les jours

		// on divise le nombre de seconde par 86400 (=3600*24)
		// puis on utilise la fonction floor() pour arrondir au plus petit
		$jour = floor($time/86400);
		// On extrait le nombre de jours
		$reste = $time%86400;

		$heure = floor($reste/3600);
		// puis le nombre d'heures
		$reste = $reste%3600;

		$minute = floor($reste/60);
		// puis les minutes

		$seconde = $reste%60;
		// et le reste en secondes

		// on rassemble les résultats en forme de date
		//$result = $jour.'j '.$heure.'h '.$minute.'min '.$seconde.'s';
		$result = $jour.'j '.$heure.'h';
		}
		elseif ($time < 86400 AND $time>=3600)
		// si le nombre de secondes ne contient pas de jours mais contient des heures
		{
		// on refait la même opération sans calculer les jours
		$heure = floor($time/3600);
		$reste = $time%3600;

		$minute = floor($reste/60);

		$seconde = $reste%60;

		//$result = $heure.'h '.$minute.'min '.$seconde.' s';
		$result = $heure.'h '.$minute.'min';
		}
		elseif ($time<3600 AND $time>=60)
		{
		// si le nombre de secondes ne contient pas d'heures mais contient des minutes
		$minute = floor($time/60);
		$seconde = $time%60;
		$result = $minute.'min '.$seconde.'s';
		}
		elseif ($time < 60)
		// si le nombre de secondes ne contient aucune minutes
		{
		$result = $time.'s';
		}
		return $result;
	}

	// Affichage du menu de XLeft_menu
	function printMenu($XMenus_value, $active, $rec)
	{
		// Si il n'est pas visible, on s'arrête là
		if (!$XMenus_value->visible()) {
			return;
		}

		// On définie si il est de classe active
		$classe_active = '';
		if ($active) {
			$classe_active = 'active';
		}

		// On crée le lien vers la page si il le faut
		if ($XMenus_value->link()) {															// Si il y a un lien
			$link = 'href="'.$_SERVER['PHP_SELF'].'?page='.$XMenus_value->controller().'">';	// On défini href pour la balise a
			$url = $_SERVER['PHP_SELF'].'?page='.$XMenus_value->controller();					// On défini l'url pour le onclick
		}
		else {																					// Si non
			$link = 'href="#" class="text-muted">';												// Il y a un href sur la même page
			$url = '#';																			// Il y a un url pour le onclick sur la même page.
		}

		//On affiche le menu
		echo '<li onclick="linkTo(\''.$url.'\')" class="'.$classe_active.'"><a style="padding-left: '.($rec*15).'px" '.$link.''.showGlyph($XMenus_value->icon()).' '.ucfirst(userLang('menu', $XMenus_value->name())).'</a></li>';
	}

	// On récupère les menus enfant du menu actuel
	function getChild($listXMenus, $XMenus, $page_name, $rec)
	{
		$active = 0;
		// Si le menu actuel est le même que la page actuel, elle est active
		if ($page_name === $XMenus->name()) {
			$active = 1;
		}
		// On affiche le menu
		printMenu($XMenus, $active, $rec);

		// Puis on reparcour la liste des menus enfant
		foreach ($listXMenus as $XMenus_key => $XMenus_value) {
			if ($XMenus_value->id() == $XMenus->id()) { // Si c'est le même menu, on le retire de la liste pour éviter les doublons
				unset($listXMenus[$XMenus_key]);
			}
			if ($XMenus_value->parent_id() == $XMenus->id()) { // Si c'est bien un enfant de menu actuel, on le traite
				getChild($listXMenus, $XMenus_value, $page_name, ++$rec);
				$rec --;
			}
		}
	}

	// On génère et affiche les clés pour une nouvelle application
	function generateAppKeys($appName = 'New app') {
		$XSsoManager = new XSsoManager();

		$keyList = array(	'name' => $appName,
							'app_key' => $XSsoManager->newAppKey($appName),
							'password_salt' => substr(sha1(uniqid()), 0, 20),
							'session_key' => substr(sha1(uniqid()), 0, 20));

		var_dump($keyList);
	}
?>

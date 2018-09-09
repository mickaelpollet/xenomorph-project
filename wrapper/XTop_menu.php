<?php

// function showMenu($menuList)
// {
// 	$XMenus = new XMenuManager();
// 	foreach ($menuList as $XMenus_key => $menu) {
// 		if ($menu->link()) {
// 			$url = $_SERVER['PHP_SELF'].'?page='.$menu->controller();
// 		}
// 		else {
// 			$url = '#';
// 		}
// 		if ($menu->isParent())
// 		{
// 			showMenu($XMenus->getParent(), $page_name);
// 		} else {
// 			$menu_rights = array();
// 			foreach ($menu->rights() as $menu_rights_key => $menu_rights_value) {
// 				switch ($menu_rights_value->type()) {
// 					case 1: $menu_rights['min'] = $menu_rights_value->level(); break;
// 					case 2: $menu_rights['max'] = $menu_rights_value->level(); break;
// 					case 3: $menu_rights['equal'] = $menu_rights_value->level(); break;
// 				}
// 			}
// 			if (userAccesses($menu_rights)) {
// 				if ($page_name === $menu->name()) {
// 					if ($menu->link()) {
// 						echo '	<li onclick="linkTo(\''.$url.'\')" class="active"><a href="'.$_SERVER['PHP_SELF'].'?page='.$menu->controller().'">'.showGlyph($menu->icon()).' '.ucfirst(userLang('menu', $menu->name())).'</a></li>';
// 					} else {
// 						echo '	<li class="active"><a class="cursor_text" href="#">'.showGlyph($menu->icon()).' '.ucfirst(userLang('menu', $menu->name())).'</a></li>';
// 					}
// 				} else {
// 					if ($menu->link()) {
// 						echo '	<li onclick="linkTo(\''.$url.'\')" ><a href="'.$_SERVER['PHP_SELF'].'?page='.$menu->controller().'">'.showGlyph($menu->icon()).' '.ucfirst(userLang('menu', $menu->name())).'</a></li>';
// 					} else {
// 						echo '	<li><a class="cursor_text" href="#">'.showGlyph($menu->icon()).' '.ucfirst(userLang('menu', $menu->name())).'</a></li>';
// 					}
// 				}
// 			}
// 		}
// 	}
// }


// Conteneur Menu HAUT
echo '<nav class="navbar navbar-inverse navbar-fixed-top">
		<div class="container-fluid">';

// Récupération de la branche GIT
$currentGitBranch = gitBranch();
switch ($currentGitBranch) {
	case 'master':	$gitBranch = '';																												break;
	case 'dev' :	$gitBranch = '<span class="small text-warning"> - </span><span class="small label label-warning">'.$currentGitBranch.'</span>';	break;
	default:		$gitBranch = '<span class="small text-info"> - </span><span class="small label label-info">'.$currentGitBranch.'</span>';		break;
}
// Logo et Nom de l'application
echo '<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="'.$_SERVER['PHP_SELF'].'?page=dashboard" onclick="linkTo(\''.$_SERVER['PHP_SELF'].'?page=dashboard\')">'.globalConfig('application', 'app_name').$gitBranch.'</a>
		</div>';
// Barre des menus
echo '	<div id="navbar" class="navbar-collapse collapse">';
// Gestion des langues
echo '		<ul class="nav navbar-nav navbar-right">';
echo '<li class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">'.$_SESSION['lang'].' <span class="caret"></span></a>
			<ul class="dropdown-menu">';
if ($available_languages) {
	foreach ($available_languages as $language_key => $language_value) {
		$current_url = preg_replace('/(\?|&)lang=[a-z]{2}/', '', $_SERVER['REQUEST_URI']);                      // Suppression du paramètre de langue si celui-ci est déjà présent
			if ($language_key == $_SESSION['lang']) {
				$active_param = ' class="active"';
			} else {
				$active_param = "";
			}

			if (strstr($current_url, "?")) {
				echo '	<li'.$active_param.'><a href="'.$current_url.'&lang='.$language_value->code().'">'.ucfirst($language_value->name()).' - '.$language_value->code().'</a></li>';
			} else {
				echo '	<li'.$active_param.'><a href="'.$current_url.'?lang='.$language_value->code().'">'.ucfirst($language_value->name()).' - '.$language_value->code().'</a></li>';
			}
	}
}
echo '			</ul>
			</li>';

echo '	</ul>';

// Barre de recherche
/*echo '      <form class="navbar-form navbar-right">

							<input type="text" class="form-control" placeholder="'.ucfirst(userLang('menu', 'search')).'...">
						</form>';*/

// Menus

echo '	<ul class="nav navbar-nav navbar-right">';
echo '		<li class="dropdown">';
echo '			<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Menu <span class="caret"></span></a>';
echo '				<ul class="dropdown-menu">';
/************************************************************/
/*          Chargement des menus du Framework               */
/************************************************************/
$XMenus = new XMenuManager();

// showMenu($XMenus->getList());

foreach ($XMenus->getList() as $XMenus_key => $XMenus_value) {

	if (!$XMenus_value->visible()) {
		continue;
	}

	$menu_rights = array();
	foreach ($XMenus_value->rights() as $menu_rights_key => $menu_rights_value) {
		switch ($menu_rights_value->type()) {
			case 1: $menu_rights['min'] = $menu_rights_value->level(); break;
			case 2: $menu_rights['max'] = $menu_rights_value->level(); break;
			case 3: $menu_rights['equal'] = $menu_rights_value->level(); break;
		}
	}

	if (userAccesses($menu_rights) && $XMenus_value->visible()) {
		if ($page_name === $XMenus_value->name()) {
			if ($XMenus_value->link()) {
				echo '	<li class="active"><a href="'.$_SERVER['PHP_SELF'].'?page='.$XMenus_value->controller().'">'.showGlyph($XMenus_value->icon()).' '.ucfirst(userLang('menu', $XMenus_value->name())).'</a></li>';
			} else {
				echo '	<li class="active"><a class="cursor_text" href="#">'.showGlyph($XMenus_value->icon()).' '.ucfirst(userLang('menu', $XMenus_value->name())).'</a></li>';
			}
		} else {
			if ($XMenus_value->link()) {
				echo '	<li><a href="'.$_SERVER['PHP_SELF'].'?page='.$XMenus_value->controller().'">'.showGlyph($XMenus_value->icon()).' '.ucfirst(userLang('menu', $XMenus_value->name())).'</a></li>';
			} else {
				echo '	<li><a class="cursor_text" href="#">'.showGlyph($XMenus_value->icon()).' '.ucfirst(userLang('menu', $XMenus_value->name())).'</a></li>';
			}
		}
	}
}

echo '					<li role="separator" class="divider"></li>';
echo '					<li><a href="'.$_SERVER['PHP_SELF'].'?page=logout">'.showGlyph('power').' '.ucfirst(userLang('menu', 'logout')).'</a></li>';
echo '				</ul>
				</li>
			</ul>
	</div>
</nav>';
?>
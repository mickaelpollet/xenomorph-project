<?php
$user = $_SESSION['session_user'];

/****************************************************************/
/*          Création des liens XSso menus du Framework          */
/****************************************************************/

// Création des liens XSso
$XSsoManager = new XSsoManager();
global $XOdbc;

// Récupération de la liste des application XSso cibles
$xssoLinkListQuerry = $XOdbc->prepare("SELECT * FROM x_sso_links");
$xssoLinkListQuerry->execute();
$xssoLinkList = $xssoLinkListQuerry->fetchAll(PDO::FETCH_ASSOC);

// Création des balises de lien XSso
$linkList = array();
foreach ($xssoLinkList as $xssoLink) {
	$key = $XSsoManager->create();
	$linkList[] = '<a class="label label-success" href="'.$xssoLink['url'].'?XSso='.$key.'" target="_BLANK">'.$xssoLink['name'].'</a>';
}

/****************************************************************/
/*          Création de l'entête de menus du Framework          */
/****************************************************************/

echo '<div class="col-sm-3 col-md-2 sidebar">
<p class="lead">Utilisateur courant :</p>';
		echo'<form action = "index.php?page='.$page_name.'" method = "post">';
		if (!XCookieManager::getByName("refresh", "isRefresh")) {
			echo '<p><button class="hideButton" type="submit" id="refreshOn" name="refreshOn" value="refreshOn">'.showGlyph('eye-close', 'glyphicons','#d95835').'</button> <b>'.$user->fname().' '.$user->lname().'</b></p>';
		} else {
			echo '<p><button class="hideButton" type="submit" id="refreshOff" name="refreshOff" value="refreshOff">'.showGlyph('eye-open', 'glyphicons', '#92b892').'</button> <b>'.$user->fname().' '.$user->lname().'</b></p>';
		}
		echo '</form>';
		echo '<p>'.showGlyph('envelope').' '.$user->mail().'</p>
		<p>'.showGlyph('user').' <span style="color:#bc272c">'.$user->rights()->libelle().'</span></p>
		<p class="small">IP actuelle : '.userIp().'</p>';
		//<p class="small text-right" style="color:#999"><a href="#" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Modifier mon compte">'.showGlyph("cogwheel", "glyphicons", "#f0ad4e").' Modifier</a></p>
		// On affiche les liens si on est administrateur.
		if (userAccesses(array ('min' => 70)) && $linkList) {
			foreach ($linkList as $link) {
				echo $link;
			}
		}
echo '<hr>
		<ul class="nav nav-sidebar">';

/************************************************************/
/*          Chargement des menus du Framework               */
/************************************************************/

$XMenus = new XMenuManager();

$listXMenus = $XMenus->getList();
foreach ($listXMenus as $XMenus_key => $XMenus_value) {
	$menu_rights = array();
	foreach ($XMenus_value->rights() as $menu_rights_key => $menu_rights_value) {
		switch ($menu_rights_value->type()) {
			case 1: $menu_rights['min'] = $menu_rights_value->level(); break;
			case 2: $menu_rights['max'] = $menu_rights_value->level(); break;
			case 3: $menu_rights['equal'] = $menu_rights_value->level(); break;
		}
	}
	if (!$XMenus_value->parent_id() && userAccesses($menu_rights)) {
		getChild($listXMenus, $XMenus_value, $page_name, 1);
	}
}

echo '		</ul>
		</div>';
?>
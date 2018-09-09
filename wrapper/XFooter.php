<?php
/*************************************
 * @project: 	Xenomroph
 * @file:		Footer page
 * @author: 	Mickaël POLLET
 *************************************/

global $XVersion;

// Préparation du wrap
echo '<footer style="vertical-align:middle">
		<nav class="navbar navbar-default navbar-fixed-bottom" role="navigation">
			<div class="container" style="vertical-align:middle;text-align:center">
				<div class="footer-text">
					<small>';

// Inclusion du footer applicatif
include(SITE_ROOT.VIEWS_DIR.'footer.php');

// Inclusion du footer du framework
echo ' - Xenomorph';

// Vérification des paramètres à afficher en fonction de la session
if (session_status()) {
	$session_params = new XSessionManager();
	if (isset($_SESSION['token']) && isset($_SESSION['user_key']) && isset($_SESSION['session_user'])) {
		// Vérification que l'utilisateur a des droits de développeur ou plus
		$rights_level_manager = new XRightManager();
		$minimum_rights_level = $rights_level_manager->get(10);
		if ($_SESSION['session_user']->rights()->rights_level() >= $minimum_rights_level->rights_level()) {		
			if (isset($XVersion)) {
			echo ' <span data-placement="top"
			                      id="versions_popover"
			                      popover-title="LIBRARIES"
			                      popover-trigger="outsideClick">v'.$XVersion->framework().'</span>';
			}

echo '		                      </small>
				</div>
			</div>';
			echo '		<div class="container" style="vertical-align:middle;text-align:right" ng-controller="systemController as system">
							<span data-placement="top"
			                      id="debug_popover"
			                      popover-title="DEBUG BACKTRACE"
			                      popover-trigger="outsideClick">'.showLabel('DEBUG').'</span> 
							<span data-placement="top"
			                      id="post_popover"
			                      popover-title="POST"
			                      popover-trigger="outsideClick">'.showLabel('POST').'</span> 
							<span data-placement="top"
			                      id="get_popover"
			                      popover-title="GET"
			                      popover-trigger="outsideClick">'.showLabel('GET').'</span> 
							<span data-placement="top"
			                      id="session_popover"
			                      popover-title="SESSION"
			                      popover-trigger="outsideClick">'.showLabel('SESSION').'</span> 
							<span data-placement="top"
			                      id="server_popover"
			                      popover-title="SERVER"
			                      popover-trigger="outsideClick">'.showLabel('SERVER').'</span>
						</div>';

			global $GetContainer;
			global $PostContainer;
			global $SessionContainer;
			global $ServerContainer;


			echo '	<div id="versions_popover_header" class="hidden">LIBRARIES</div>';
			echo '	<div id="versions_popover_content" class="hidden">
  						<div class="">';
  			
			// Inclusion des versions des libraries
  			echo '<span style="font-size:9px">XENOMORPH - <span style=\"color:blue\"><a href="index.php?page=version&log=fwk">'.$XVersion->framework().'</a></span></span><br/>';
			foreach (XConfig('libraries_version') as $library_key => $library_value) {
				echo '<span style="font-size:9px">'.strtoupper($library_key)." - <span style=\"color:blue\"><a href=\"".XConfig('libraries_href', $library_key)."\" target=\"_blank\">".$library_value."</a></span></span><br/>";
			}

			// Inclusion des versions des libraries de l'application
			foreach (globalConfig('libraries_version') as $library_key => $library_value) {
				echo '<span style="font-size:9px">'.strtoupper($library_key)." - <span style=\"color:blue\"><a href=\"".globalConfig('libraries_href', $library_key)."\" target=\"_blank\">".$library_value."</a></span></span><br/>";
			}

  			echo '		</div>
					</div>';

			echo '	<div id="debug_popover_header" class="hidden">DEBUG BACKTRACE</div>';
			echo '	<div id="debug_popover_content" class="hidden">
  						<div class="x_system_content">';
  						var_dump(debug_backtrace());
  			echo '		</div>
					</div>';

			echo '	<div id="post_popover_header" class="hidden">POST</div>';
			echo '	<div id="post_popover_content" class="hidden">
  						<div class="x_system_content">';
  						var_dump($PostContainer);
  			echo '		</div>
					</div>';

			echo '	<div id="get_popover_header" class="hidden">GET</div>';
			echo '	<div id="get_popover_content" class="hidden">
  						<div class="x_system_content">';  							
						var_dump($GetContainer);
  			echo '		</div>
					</div>';

			echo '	<div id="session_popover_header" class="hidden">SESSION</div>';
			echo '	<div id="session_popover_content" class="hidden">
  						<div class="x_system_content">';
  						var_dump($SessionContainer);
  			echo '		</div>
					</div>';

			echo '	<div id="server_popover_header" class="hidden">SERVER</div>';
			echo '	<div id="server_popover_content" class="hidden">
  						<div class="x_system_content">';
  						var_dump($ServerContainer);
  			echo '		</div>
					</div>';
		} else {
			if (isset($XVersion)) {
			echo ' v'.$XVersion->framework().'</small>
						</div>
					</div>';
			}
		}
	} else {
		if (isset($XVersion)) {
		echo ' v'.$XVersion->framework().'</small>
					</div>
				</div>';
		}
	}
} else {
	if (isset($XVersion)) {
	echo ' v'.$XVersion->framework().'</small>
				</div>
			</div>';
	}
}

echo '	</nav>
	</footer>';
?>
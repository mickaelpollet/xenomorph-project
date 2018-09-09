<?php
/*************************************
 * @project: 	Xenomorph
 * @file:	Pages footer
 * @author: 	Mickaël POLLET
 *************************************/

// Fermeture DIV conteneur principal
echo '</div>';

// Footer
include(LIBS_DIR.FRAMEWORK_DIR.WRAPPER_DIR.'XFooter.php');

// Inclusion de JQuery
echo '  <!-- jQuery -->
        <script src="'.LIBS_DIR.'jquery/jquery-3.1.1.min.js"></script>';

// Inclusion Bootstrap
echo '  <!-- Bootstrap -->
        <script src="'.LIBS_DIR.'bootstrap/bootstrap.min.js"></script>';

// Inclusion AngularJS
echo '  <!-- AngularJS -->
        <script src="'.LIBS_DIR.'angularjs/angular.min.js"></script>
        <script src="'.LIBS_DIR.'angularjs/angular-sanitize.min.js"></script>
        <script src="'.LIBS_DIR.'angularjs/angular-resource.min.js"></script>
        <script src="'.LIBS_DIR.'angularjs/angular-cookies.min.js"></script>
        <script src="'.LIBS_DIR.'angularjs/angular-route.min.js"></script>
        <script src="'.LIBS_DIR.'angularjs/angular-animate.min.js"></script>
        <script src="'.LIBS_DIR.'angularjs/angular-aria.min.js"></script>
        <script src="'.LIBS_DIR.'angularjs/angular-loader.min.js"></script>
        <script src="'.LIBS_DIR.'angularjs/angular-messages.min.js"></script>
        <script src="'.LIBS_DIR.'angularjs/angular-message-format.min.js"></script>
        <script src="'.LIBS_DIR.'angularjs/angular-mocks.js"></script>
        <script src="'.LIBS_DIR.'angularjs/angular-touch.min.js"></script>
        <script src="'.JAVASCRIPT_DIR.'app_angular.js"></script>';

// Inclusion UI-Bootstrap
echo '  <!-- UI-Bootstrap -->
        <script src="'.LIBS_DIR.'ui-bootstrap/ui-bootstrap-tpls-2.4.0.min.js"></script>';

// Inclusion Angular Filter
echo '  <!-- Angular Filter -->
        <script src="'.LIBS_DIR.'angular-filter/angular-filter.min.js"></script>';

// Inclusion Toastr
echo '  <!-- Toastr -->
        <script src="'.LIBS_DIR.'toastr/toastr.min.js"></script>';

// Inclusion Sevices Angular
echo '  <!-- Services -->
        <script src="'.SERVICES_DIR.'authServices.js"></script>
        <script src="'.SERVICES_DIR.'usersServices.js"></script>';

// Inclusion Controllers Angular
echo '  <!-- Controlleurs -->
        <script src="'.CONTROLLERS_DIR.'authController.js"></script>
        <script src="'.CONTROLLERS_DIR.'usersController.js"></script>
        <script src="'.CONTROLLERS_DIR.'systemController.js"></script>';

// Inculsion des fichiers JavaScript de l'application
echo '  <!-- Application -->
        <script src="'.LIBS_DIR.FRAMEWORK_DIR.JAVASCRIPT_DIR.'XMain.js"></script>
        <script src="'.JAVASCRIPT_DIR.'app.js"></script>';

// Vérification des paramètres à afficher en fonction de la session
if (session_status()) {
	$session_params = new XSessionManager();
	if (isset($_SESSION['token']) && isset($_SESSION['user_key']) && isset($_SESSION['session_user'])) {
		// Vérification que l'utilisateur a des droits de développeur ou plus
		$rights_level_manager = new XRightManager();
		$minimum_rights_level = $rights_level_manager->get(10);
		if ($_SESSION['session_user']->rights()->rights_level() >= $minimum_rights_level->rights_level()) {
			echo '  <!-- Templates Popover / Tooltips -->
					<script type="text/ng-template" id="PostTemplate.html"><div ng-include="\''.VIEWS_DIR.TEMPLATES_DIR.'PostTemplate.php\'"></div></script>
					<script type="text/ng-template" id="GetTemplate.html"><div ng-include="\''.VIEWS_DIR.TEMPLATES_DIR.'GetTemplate.php\'"></div></script>
					<script type="text/ng-template" id="SessionTemplate.html"><div ng-include="\''.VIEWS_DIR.TEMPLATES_DIR.'SessionTemplate.php\'"></div></script>
					<script type="text/ng-template" id="ServerTemplate.html"><div ng-include="\''.VIEWS_DIR.TEMPLATES_DIR.'ServerTemplate.php\'"></div></script>';
		}
	}
}

echo '</body>
</html>';
?>
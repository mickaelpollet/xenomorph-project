<?php
/*************************************
 * @project: 	Xenomorph
 * @file:     Framework Installation services page
 * @author: 	Mickaël POLLET
 *************************************/

  XDebugger("----- Installation des dépendances du Framework ------", 0);

  var_dump("Installation des dépendances Composer...");

  exec("cd .. | composer install");

  var_dump("Installation terminée !");

  XDebugger("----- Installation terminée ------", 0);

  die;

?>

<?php
/*************************************
 * @project: 	Xenomorph
 * @file:		DataBase Connector
 * @author: 	Mickaël POLLET
 *************************************/

try {

	global $XOdbc;

	@$XOdbc = new PDO($global_config['database']['driver'].':host='.$global_config['database']['host'].';port='.$global_config['database']['port'].';dbname='.$global_config['database']['database'], $global_config['database']['login'], $global_config['database']['password']);

} catch (PDOException  $e) {

	XDebugger($e->getMessage(), 2);

	if ($e->getCode() == 2002) {
		XSystem::log($e->getCode(), 5, array(0 => $global_config['database']['host']), true);
	} else if ($e->getCode() == 1045) {
		XSystem::log($e->getCode(), 5, array(0 => $global_config['database']['login']), true);
	}

	XViewWrapper('error', 'error', $e);
	die;
}

try {

	$request = $XOdbc->prepare('SET global sql_mode="STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION"');
	$request->execute();
	$XOdbc->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	switch ($global_config['database']['driver']) {
		case 'mysql':	$XOdbc->exec("SET CHARACTER SET utf8");			break;
		case 'pgsql':	$XOdbc->exec("SET CLIENT_ENCODING TO 'UTF8'");	break;
		default:		$XOdbc->exec();									break;
	}

} catch (PDOException $pdo) {
	throw new Exception(utf8_encode($pdo->getMessage()));
}

?>

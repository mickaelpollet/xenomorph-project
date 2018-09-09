<?php
/*************************************
 * @project: 	Xenomorph
 * @file:		TRAIT XSystem
 * @author: 	Mickaël POLLET
 *************************************/

trait XSystem
{

	public static function log($code, $criticity = 1, array $parameters = array(), $verbose = false) {

		// Préparation du message
		$message_to_log = new XLog();
		$message_to_log->set('ip_address', userIp());
		$message_to_log->set('type', (int)substr(sprintf('%08d', $code), 0, 4));
		$message_to_log->set('criticity', $criticity);
		$message_to_log->set('code', sprintf('%08d', $code));
		$message_to_log->set('parameters', $parameters);
		// Mise en table du message
		$messageManager = new XLogManager();
		$messageManager->add($message_to_log);

		if ($verbose) {
			switch ($message_to_log->criticity()) {
				case 1: 	$_SESSION['XMessages']['INFO'][] =		$messageManager->show($message_to_log);	break;
				case 2:		$_SESSION['XMessages']['SUCCESS'][] =	$messageManager->show($message_to_log);	break;
				case 3:		$_SESSION['XMessages']['WARNING'][]	=	$messageManager->show($message_to_log);	break;
				case 4:		$_SESSION['XMessages']['ERROR'][]	=	$messageManager->show($message_to_log);	break;
				case 5:		$_SESSION['XMessages']['ERROR'][] =		$messageManager->show($message_to_log);	break;
				default:	$_SESSION['XMessages']['INFO'][] =		$messageManager->show($message_to_log);	break;
			}
		}

		// Ajout du message sur le log système
		switch ($criticity) {
			case 1:		syslog(LOG_INFO,	utf8_decode(strip_tags($messageManager->show($message_to_log))));	break;
			case 2:		syslog(LOG_INFO,	utf8_decode(strip_tags($messageManager->show($message_to_log))));	break;
			case 3:		syslog(LOG_WARNING,	utf8_decode(strip_tags($messageManager->show($message_to_log))));	break;
			case 4:		syslog(LOG_ERR,		utf8_decode(strip_tags($messageManager->show($message_to_log))));	break;
			case 5:		syslog(LOG_ERR,		utf8_decode(strip_tags($messageManager->show($message_to_log))));	break;
			default:	syslog(LOG_INFO,	utf8_decode(strip_tags($messageManager->show($message_to_log))));	break;
		}

	}

	public function systemMessage($domain, $code, array $parameters = null, $file = null, $log_line = null ) {
		global $global_lang;
		if ($parameters == null) {
			return $global_lang[$domain][$code];
		} else {
			$message = $global_lang[$domain][$code];
			foreach ($parameters as $parameters_key => $parameters_value) {
				if (is_object($parameters_value)) {	$parameters_value = json_encode($parameters_value);	}
				$message = str_replace('{{'.$parameters_key.'}}', '<b>"'.$parameters_value.'"</b>', $message);
			}

			if ($file != null && $log_line != null) {
				return $message.'<div class="small"><em><strong>'.ucfirst($global_lang['general']['file']).' :</strong> '.$file.'<br/><strong>'.ucfirst($global_lang['general']['line']).' :</strong> '.$log_line.'</em></div>';
			} else {
				return $message;
			}
		}
	}

}

?>
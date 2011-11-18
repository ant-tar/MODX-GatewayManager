<?php

$modx =& $object->xpdo;

switch($options[xPDOTransport::PACKAGE_ACTION]) {
	case xPDOTransport::ACTION_INSTALL:
		$modelPath = $modx->getOption('gatewaymanager.core_path', null, $modx->getOption('core_path').'components/gatewaymanager/').'model/';
		$modx->addPackage('gatewaymanager', $modelPath);

		$manager = $modx->getManager();

		$manager->createObjectContainer('gatewayDomain');
	break;
}

return true;

?>
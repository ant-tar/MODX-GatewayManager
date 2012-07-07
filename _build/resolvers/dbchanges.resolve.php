<?php

$modx =& $object->xpdo;

$modx->log(xPDO::LOG_LEVEL_INFO, 'Making database changes.');
switch($options[xPDOTransport::PACKAGE_ACTION]) {
	case xPDOTransport::ACTION_INSTALL:
	case xPDOTransport::ACTION_UPGRADE:
		
		$modx =& $object->xpdo;
		$modelPath = $modx->getOption('gatewaymanager.core_path', null, $modx->getOption('core_path').'components/gatewaymanager/').'model/';
		$modx->addPackage('gatewaymanager', $modelPath);
		
		$manager = $modx->getManager();
		
		$manager->addField('gatewayDomain', 'active', array('after' => 'sitestart'));
		
	break;
}

?>
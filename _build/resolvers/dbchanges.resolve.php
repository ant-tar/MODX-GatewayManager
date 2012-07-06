<?php

$modx =& $object->xpdo;

$modx->log(xPDO::LOG_LEVEL_INFO,'Running PHP Resolver.');
switch($options[xPDOTransport::PACKAGE_ACTION]) {
	case xPDOTransport::ACTION_INSTALL:
		
		$modx =& $object->xpdo;
		$modelPath = $modx->getOption('gatewaymanager.core_path', null, $modx->getOption('core_path').'components/gatewaymanager/').'model/';
		$modx->addPackage('gatewaymanager', $modelPath);

		$manager = $modx->getManager();
		$manager->addField('gatewayDomain', 'active', array('after' => 'sitestart'));
		
	break;
}

?>
<?php

$modx =& $object->xpdo;

$modx->log(xPDO::LOG_LEVEL_INFO, 'Assigning Events to Plugin');
switch($options[xPDOTransport::PACKAGE_ACTION]) {
	case xPDOTransport::ACTION_INSTALL:
		
		$plugin = 'GatewayManager';
		$event = 'OnHandleRequest';
		
		$pluginObj = $modx->getObject('modPlugin', array('name' => $plugin));
		if (!$pluginObj) $modx->log(xPDO::LOG_LEVEL_INFO, 'Cannot get object: '.$plugin);
		if (empty($event)) $modx->log(xPDO::LOG_LEVEL_INFO, 'Cannot get System Events');
		if (!empty($event) && $pluginObj) {
			
			$exists = $modx->getObject('modPluginEvent', array('event' => $event, 'pluginid' => $pluginObj->get('id')));
			if(empty($exists)) {
				$intersect = $modx->newObject('modPluginEvent');
				$intersect->set('event', $event);
				$intersect->set('pluginid', $pluginObj->get('id'));
				$intersect->save();
			}
		}
	break;
}

?>
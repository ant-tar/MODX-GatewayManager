<?php

require_once dirname(dirname(__FILE__)) . '/model/gatewaymanager/gatewaymanager.class.php';

abstract class GatewayManagerController extends modExtraManagerController
{
	/** @var GatewayManager $gatewaymanager */
	public $gatewaymanager;
	public function initialize() {
		$this->gatewaymanager = new GatewayManager($this->modx);
		
		$this->addJavascript($this->gatewaymanager->config['jsUrl'].'mgr/gatewaymanager.js');
		$this->addHtml('<script type="text/javascript">
		Ext.onReady(function() {
			GatewayManager.config = '.$this->modx->toJSON($this->gatewaymanager->config).';
			GatewayManager.config.connector_url = "'.$this->gatewaymanager->config['connectorUrl'].'";
			GatewayManager.request = '.$this->modx->toJSON($_GET).';
		});
		</script>');
		return parent::initialize();
	}
	
	public function getLanguageTopics() {
		return array('gatewaymanager:default');
	}
	
	public function checkPermissions() { return true;}
}

class ControllersIndexManagerController extends GatewayManagerController
{
	public static function getDefaultController() { return 'home'; }
}

?>
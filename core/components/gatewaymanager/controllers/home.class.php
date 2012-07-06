<?php

class GatewayManagerHomeManagerController extends GatewayManagerController
{
    public function process(array $scriptProperties = array()) {
		
    }
	
    public function getPageTitle() { return $this->modx->lexicon('gatewaymanager'); }
    
	public function loadCustomCssJs() {
		$this->addJavascript($this->gatewaymanager->config['jsUrl'].'mgr/combos.js');
		$this->addJavascript($this->gatewaymanager->config['jsUrl'].'mgr/widgets/index.panel.js');
		$this->addJavascript($this->gatewaymanager->config['jsUrl'].'mgr/widgets/gateways.grid.js');
		$this->addLastJavascript($this->gatewaymanager->config['jsUrl'].'mgr/sections/index.js');
    }
	
    public function getTemplateFile() { return $this->gatewaymanager->config['templatesPath'].'home.tpl'; }
}

?>
<?php

require_once dirname(__FILE__) . '/base.class.php';

class GatewayManagerIndexManagerController extends GatewayManagerController
{
    public function getPageTitle()
    {
        return $this->modx->lexicon('gatewaymanager');
    }

    public function loadCustomCssJs()
    {
        $this->addJavascript($this->gatewaymanager->config['jsUrl'] . 'mgr/widgets/gateways.grid.js');
        $this->addJavascript($this->gatewaymanager->config['jsUrl'] . 'mgr/widgets/index.panel.js');
        $this->addLastJavascript($this->gatewaymanager->config['jsUrl'] . 'mgr/sections/index.js');
    }

    public function getTemplateFile()
    {
        return $this->gatewaymanager->config['templatesPath'] . 'index.tpl';
    }
}
<?php

class GatewaysCreateProcessor extends modObjectCreateProcessor {
	public $classKey = 'gatewayDomain';
	public $languageTopics = array('gatewaymanager:default');
	public $objectType = 'gatewaymanager.gatewaydomain';
	
	/**
     * Override in your derivative class to do functionality before the fields are set on the object
     * @return boolean
     */
    public function beforeSet() {
		$sitestart = $this->getProperty('sitestart');
		$this->setProperty('sitestart', (!empty($sitestart) ? $sitestart : null));
		
		$domain = $this->getProperty('domain');
		$this->setProperty('domain', str_replace(array('http://','https://','ftp://'), '', rtrim($domain, '/')));
		
		return parent::beforeSet();
	}
	
	/**
     * Override in your derivative class to do functionality after save() is run
     * @return boolean
     */
	public function beforeSave() {
		$domain = $this->getProperty('domain');
 
		if(empty($domain)) {
			$this->addFieldError('domain', $this->modx->lexicon('gatewaymanager.error.domain_ns'));
		} else if($this->doesAlreadyExist(array('domain' => $domain))) {
			$this->addFieldError('domain', $this->modx->lexicon('gatewaymanager.error.domain_ae'));
		}
		return parent::beforeSave();
	}
	
	/**
     * Override in your derivative class to do functionality before save() is run
     * @return boolean
     */
    public function afterSave() {
		$createCtxSettings = $this->getProperty('create-context-settings');
		if(!empty($createCtxSettings)) {
			$context = $this->getProperty('context');
			if(!empty($context) && $context != 'mgr') {
				$domain = $this->getProperty('domain');
				
				// SITE URL
				$exists = $this->modx->getObject('modContextSetting', array('context_key' => $context, 'key' => 'site_url'));
				if(empty($exists)) {
					$setting = $this->modx->newObject('modContextSetting');
					$setting->fromArray(array(
						'context_key' => $context, 
						'key' => 'site_url',
						'value' => 'http://'.$domain.'/',
						'xtype' => 'textfield',
						'namespace' => 'core',
						'area' => 'site',
					), '', true);
					$setting->save();
				}
				
				// BASE URL
				$exists = $this->modx->getObject('modContextSetting', array('context_key' => $context, 'key' => 'base_url'));
				if(empty($exists)) {
					$setting = $this->modx->newObject('modContextSetting');
					$setting->fromArray(array(
						'context_key' => $context, 
						'key' => 'base_url',
						'value' => '/',
						'xtype' => 'textfield',
						'namespace' => 'core',
						'area' => 'site',
					), '', true);
					$setting->save();
				}
				
				// HTTP HOST
				$exists = $this->modx->getObject('modContextSetting', array('context_key' => $context, 'key' => 'http_host'));
				if(empty($exists)) {
					$setting = $this->modx->newObject('modContextSetting');
					$setting->fromArray(array(
						'context_key' => $context, 
						'key' => 'http_host',
						'value' => $domain,
						'xtype' => 'textfield',
						'namespace' => 'core',
						'area' => 'site',
					), '', true);
					$setting->save();
				}
				
				// clear the cache to be sure
				$this->modx->cacheManager->refresh(array(
					'db' => array(),
					'context_settings' => array('contexts' => array($context)),
					'resource' => array('contexts' => array($context)),
				));
			}
		}
		return true;
	}
}
return 'GatewaysCreateProcessor';

?>
<?php

class GatewaysUpdateProcessor extends modObjectUpdateProcessor {
	public $classKey = 'gatewayDomain';
	public $languageTopics = array('gatewaymanager:default');
	public $objectType = 'gatewaymanager.gatewaydomain';
	public $oldDomain;
	
	/**
     * Override in your derivative class to do functionality before the fields are set on the object
     * @return boolean
     */
    public function beforeSet() {
		$this->oldDomain = $this->object->get('domain');
		$sitestart = $this->getProperty('sitestart');
		$this->setProperty('sitestart', (!empty($sitestart) ? $sitestart : null));
		
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
		} else if($domain != $this->oldDomain && $this->modx->getCount($this->classKey, array('domain' => $domain))) {
			$this->addFieldError('domain', $this->modx->lexicon('gatewaymanager.error.domain_ae'));
		}
		return parent::beforeSave();
	}
}
return 'GatewaysUpdateProcessor';

?>
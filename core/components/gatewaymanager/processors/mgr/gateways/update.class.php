<?php

class GatewaysUpdateProcessor extends modObjectUpdateProcessor
{
    public $classKey = 'gatewayDomain';
    public $languageTopics = array('gatewaymanager:default');
    public $objectType = 'gatewaymanager.gatewaydomain';

    public $oldDomain;
    public $oldContext;

    /**
     * Override in your derivative class to do functionality before the fields are set on the object
     *
     * @return boolean
     */
    public function beforeSet()
    {
        $this->oldDomain = $this->object->get('domain');
        $this->oldContext = $this->object->get('context');

        $sitestart = $this->getProperty('sitestart');
        $this->setProperty('sitestart', (!empty($sitestart) ? $sitestart : null));

        return parent::beforeSet();
    }

    /**
     * Override in your derivative class to do functionality after save() is run
     *
     * @return boolean
     */
    public function beforeSave()
    {
        $domain = $this->getProperty('domain');

        if (empty($domain)) {
            $this->addFieldError('domain', $this->modx->lexicon('gatewaymanager.error.domain_ns'));
            return false;
        }
        if ($domain != $this->oldDomain && $this->modx->getCount($this->classKey, array('domain' => $domain))) {
            $this->addFieldError('domain', $this->modx->lexicon('gatewaymanager.error.domain_ae'));
            return false;
        }

        $contextKey = $this->getProperty('context');
        if ($this->oldContext != $contextKey) {

            if (empty($contextKey) || $contextKey == 'mgr') {
                $this->addFieldError('context', $this->modx->lexicon('gatewaymanager.error.context_ns'));
                return false;
            }

            $context = $this->modx->getObject('modContext', array('key' => $contextKey));
            if (empty($context) || !is_object($context)) {
                $this->addFieldError('context', $this->modx->lexicon('gatewaymanager.error.context_ne'));
                return false;
            }

            $childResourceIDs = $this->modx->getChildIds(0, 10, array('context' => $contextKey));
            if (empty($childResourceIDs)) {
                $this->addFieldError('context', $this->modx->lexicon('gatewaymanager.error.context_no_resources'));
                return false;
            }
        }

        return parent::beforeSave();
    }
}

return 'GatewaysUpdateProcessor';
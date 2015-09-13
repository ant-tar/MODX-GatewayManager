<?php

class GatewaysCreateProcessor extends modObjectCreateProcessor
{
    public $classKey = 'gatewayDomain';
    public $languageTopics = array('gatewaymanager:default');
    public $objectType = 'gatewaymanager.gatewaydomain';

    /**
     * Override in your derivative class to do functionality before the fields are set on the object
     *
     * @return boolean
     */
    public function beforeSet()
    {
        $sitestart = $this->getProperty('sitestart');
        $this->setProperty('sitestart', (!empty($sitestart) ? $sitestart : null));

        $domain = $this->getProperty('domain');
        $this->setProperty('domain', $this->formatDomain($domain));

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

        if ($this->doesAlreadyExist(array('domain' => $domain))) {
            $this->addFieldError('domain', $this->modx->lexicon('gatewaymanager.error.domain_ae'));
            return false;
        }

        $contextKey = $this->getProperty('context');
        if (empty($contextKey) || $contextKey == 'mgr') {
            $this->addFieldError('context', $this->modx->lexicon('gatewaymanager.error.context_ns'));
            return false;
        }

        $context = $this->modx->getObject('modContext', array('key' => $contextKey));
        if (empty($context) || !is_object($context)) {
            $this->addFieldError('context', $this->modx->lexicon('gatewaymanager.error.context_ne'));
            return false;
        }

        $createCtxSettings = $this->getProperty('create-context-settings');
        $childResourceIDs = $this->modx->getChildIds(0, 10, array('context' => $contextKey));
        if (empty($createCtxSettings) && empty($childResourceIDs)) {
            $this->addFieldError('context', $this->modx->lexicon('gatewaymanager.error.context_no_resources'));
            return false;
        }

        $siteStartId = $this->getProperty('sitestart');
        if (!empty($siteStartId) && !in_array($siteStartId, $childResourceIDs)) {
            $this->addFieldError('sitestart', $this->modx->lexicon('gatewaymanager.error.context_rne'));
            return false;
        }

        return parent::beforeSave();
    }

    /**
     * Override in your derivative class to do functionality before save() is run
     *
     * @return boolean
     */
    public function afterSave()
    {
        $createCtxSettings = $this->getProperty('create-context-settings');
        if (!empty($createCtxSettings)) {

            $domain = $this->getProperty('domain');
            $contextKey = $this->getProperty('context');

            // create first resource if not at least one exists
            $childResourceIDs = $this->modx->getChildIds(0, 10, array('context' => $contextKey));
            if (empty($childResourceIDs)) {

                /** @var modResource $resource */
                $resource = $this->modx->newObject('modResource');
                $resource->fromArray(array(
                    'pagetitle' => 'Home',
                    'alias' => 'index',
                    'published' => true,
                    'publishedon' => time(),
                    'publishedby' => 0,
                    'template' => $this->modx->getOption('default_template', null, 1),
                    'context_key' => $contextKey,
                ));
                $resource->save();
            }

            /** @var modContextSetting $siteUrl */
            $siteUrl = $this->modx->getObject('modContextSetting', array('context_key' => $contextKey, 'key' => 'site_url'));
            if (empty($siteUrl)) {

                $siteUrl = $this->modx->newObject('modContextSetting');
                $siteUrl->fromArray(array(
                    'context_key' => $contextKey,
                    'key' => 'site_url',
                    'xtype' => 'textfield',
                    'namespace' => 'core',
                    'area' => 'site',
                ), '', true);
            }

            $siteUrl->set('value', 'http://' . $domain . '/');
            $siteUrl->save();

            /** @var modContextSetting $httpHost */
            $httpHost = $this->modx->getObject('modContextSetting', array('context_key' => $contextKey, 'key' => 'http_host'));
            if (empty($httpHost)) {

                $httpHost = $this->modx->newObject('modContextSetting');
                $httpHost->fromArray(array(
                    'context_key' => $contextKey,
                    'key' => 'http_host',
                    'xtype' => 'textfield',
                    'namespace' => 'core',
                    'area' => 'site',
                ), '', true);
            }

            $httpHost->set('value', $domain);
            $httpHost->save();

            /** @var modContextSetting $siteStart */
            $siteStart = $this->modx->getObject('modContextSetting', array('context_key' => $contextKey, 'key' => 'site_start'));
            if (empty($siteStart)) {

                $c = $this->modx->newQuery('modResource');
                $c->where(array('context_key' => $contextKey, 'parent' => 0));
                $c->sortby('menuindex ASC, id', 'ASC');
                $c->limit(1);

                /** @var modResource $resource */
                $resource = $this->modx->getObject('modResource', $c);
                if (!empty($resource)) {

                    $siteStart = $this->modx->newObject('modContextSetting');
                    $siteStart->fromArray(array(
                        'context_key' => $contextKey,
                        'key' => 'site_start',
                        'value' => $resource->get('id'),
                        'xtype' => 'textfield',
                        'namespace' => 'core',
                        'area' => 'site',
                    ), '', true);
                    $siteStart->save();
                }
            }

            // clear the cache to be sure
            $this->modx->cacheManager->refresh(array(
                'db' => array(),
                'context_settings' => array('contexts' => array($contextKey)),
                'resource' => array('contexts' => array($contextKey)),
            ));
        }
        return true;
    }

    public function formatDomain($domain)
    {
        $domain = str_replace(array('http','https','ftp','ssh','telnet'), '', $domain);
        $domain = str_replace(array('://', '/', '\\'), '', $domain);
        return $domain;
    }
}

return 'GatewaysCreateProcessor';
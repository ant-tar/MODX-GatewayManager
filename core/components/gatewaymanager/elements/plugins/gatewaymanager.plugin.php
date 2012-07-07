<?php
/**
 * GatewayManager
 * The manager for all you gateway domains
 *
 * @package gatewaymanager
 * @author Bert Oost at OostDesign.nl <bert@oostdesign.nl>
 */

if($modx->context->get('key') == 'mgr') { return; }

$gateway = $modx->getService('gatewaymanager', 'GatewayManager', $modx->getOption('gatewaymanager.core_path', null, $modx->getOption('core_path').'components/gatewaymanager/').'model/gatewaymanager/',$scriptProperties);
if (!($gateway instanceof GatewayManager)) return '';
$gateway->initialize($modx->context->get('key'));

// get the hostname
$hostname = parse_url($_SERVER['REQUEST_URI'], PHP_URL_HOST);
if(empty($hostname)) {
    $hostname = $modx->getOption('http_host');
}

// and find the GatewayManager record
$domain = $modx->getObject('gatewayDomain', array('domain' => $hostname, 'active' => true));

if(!empty($domain) && is_object($domain) && $domain instanceof gatewayDomain) {
    
    // the current context
    $currContext = $modx->context->get('key');
    
    // get the context from the setupped domain
    $context = $domain->getOne('Context');
    $domContext = $context->get('key');
    $sameContext = ($currContext == $domContext) ? true : false;
  
    if(!$sameContext) {
    
        // switch to the new context
        $modx->switchContext($domContext);
    }
      
    // when domain of context is different then a canonical should be created
    $ctxDomain = $modx->context->getOption('http_host');
    $sameDomain = ($hostname == $ctxDomain) ? true : false;
    if(!$sameDomain) { $currContext = $domContext; }
    
    // site start check
    $currSitestart = $modx->getOption('site_start');
    $sitestart = $domain->get('sitestart');
    $sameSitestart = ($currSitestart == $sitestart || empty($sitestart)) ? true : false;
    
    if(!$sameSitestart) {
        
        // when not in same context, set a canonical placeholder
        if($sameContext || !$sameDomain) {
            
            $url = $modx->makeUrl($sitestart, $currContext, '', 'full');
            $modx->setPlaceholder('gateway.canonical', $url);
        }
        
        // send to the new startpage
        $modx->sendForward($sitestart);
    }
}

?>
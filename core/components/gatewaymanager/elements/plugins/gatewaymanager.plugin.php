<?php
/**
 * GatewayManager
 * The manager for all you gateway domains
 *
 * @package gatewaymanager
 * @author Bert Oost at OostDesign.nl <bert@oostdesign.nl>
 *
 * @var modX|xPDO $modx
 * @var array $scriptProperties
 */

if ($modx->context->get('key') == 'mgr') {
    return;
}

$corePath = $modx->getOption('gatewaymanager.core_path', null, $modx->getOption('core_path') . 'components/gatewaymanager/');
$gateway = $modx->getService('gatewaymanager', 'GatewayManager', $corePath . 'model/gatewaymanager/', $scriptProperties);
if (!($gateway instanceof GatewayManager)) {
    return '';
}
$gateway->initialize($modx->context->get('key'));

// get the hostname
$hostname = $_SERVER['HTTP_HOST'];
if (empty($hostname)) {
    $hostname = parse_url($_SERVER['REQUEST_URI'], PHP_URL_HOST);
}
if (empty($hostname)) {
    $hostname = $modx->getOption('http_host');
}

// and find the GatewayManager record
$domain = $modx->getObject('gatewayDomain', array('domain' => $hostname, 'active' => true));

if (!empty($domain) && is_object($domain) && $domain instanceof gatewayDomain) {

    // the current context
    $currContext = $modx->context;
    $currContextKey = $currContext->get('key');

    // get the context from the setupped domain
    $domContext = $domain->getOne('Context');
    $domContextKey = $domContext->get('key');
    $sameContext = ($currContextKey == $domContextKey) ? true : false;

    if (!$sameContext) {

        // switch to the new context
        $modx->switchContext($domContextKey);
    }

    // when domain of context is different then a canonical should be created
    $sameDomain = ($currContext->getOption('http_host') == $domContext->getOption('http_host')) ? true : false;
    if (!$sameDomain) {
        $currContext = $domContext;
    }

    // site start check (only when trying to reach the homepage)
    $urlPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    if ($urlPath == '/' || empty($urlPath)) {

        $currSiteStart = $currContext->getOption('site_start');
        $siteStart = $domain->get('sitestart');
        $sameSiteStart = ($currSiteStart == $siteStart || empty($siteStart)) ? true : false;

        if (!$sameSiteStart) {

            // when not in same context, set a canonical placeholder
            if ($sameContext || !$sameDomain) {

                $url = $modx->makeUrl($sitestart, $currContext, '', 'full');
                $modx->setPlaceholder('gateway.canonical', $url);
            }

            // send to the new startpage
            $modx->sendForward($siteStart);
        }
    }
}

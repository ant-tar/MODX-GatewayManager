<?php

define('PKG_NAME', 'GatewayManager');
define('PKG_NAME_LOWER', strtolower(PKG_NAME));

require_once dirname(__FILE__).'/build.config.php';
include_once MODX_CORE_PATH . 'model/modx/modx.class.php';

$modx = new modX();
$modx->initialize('mgr');
$modx->loadClass('transport.modPackageBuilder','',false, true);
$modx->setLogLevel(modX::LOG_LEVEL_INFO);
$modx->setLogTarget('ECHO');

$sources = array(
    'model' => MODX_CORE_PATH.'components/'.PKG_NAME_LOWER.'/model/',
    'schema_file' => MODX_CORE_PATH.'components/'.PKG_NAME_LOWER.'/model/schema/'.PKG_NAME_LOWER.'.mysql.schema.xml',
);
$manager = $modx->getManager();
$generator = $manager->getGenerator();
 
if(!is_dir($sources['model'])) {
	$modx->log(modX::LOG_LEVEL_ERROR,'Model directory not found ('.$sources['model'].')!');
	die();
}

if(!file_exists($sources['schema_file'])) {
	$modx->log(modX::LOG_LEVEL_ERROR,'Schema file not found!');
	die();
}

$generator->parseSchema($sources['schema_file'], $sources['model']);

$modx->addPackage(PKG_NAME_LOWER, $sources['model']);
$manager->createObjectContainer('gatewayDomain');

//$manager->addField('gatewayDomain', 'active', array('after' => 'sitestart'));

?>

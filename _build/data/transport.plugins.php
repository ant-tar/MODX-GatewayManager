<?php

if (! function_exists('getPluginContent')) {
    function getpluginContent($filename) {
        $o = file_get_contents($filename);
        $o = str_replace('<?php','',$o);
        $o = str_replace('?>','',$o);
        $o = trim($o);
        return $o;
    }
}

$plugins = array();

$plugins[1]= $modx->newObject('modplugin');
$plugins[1]->fromArray(array(
    'id' => 1,
    'name' => 'GatewayManager',
    'description' => 'The manager for all you gateways',
    'plugincode' => getPluginContent($sources['source_core'].'/elements/plugins/gatewaymanager.plugin.php'),
),'',true,true);

return $plugins;
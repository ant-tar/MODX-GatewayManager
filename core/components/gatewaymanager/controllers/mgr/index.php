<?php

$modx->regClientStartupScript($gatewaymanager->config['jsUrl'].'mgr/combos.js');
$modx->regClientStartupScript($gatewaymanager->config['jsUrl'].'mgr/sections/index.js');
$modx->regClientStartupScript($gatewaymanager->config['jsUrl'].'mgr/widgets/index.panel.js');
$modx->regClientStartupScript($gatewaymanager->config['jsUrl'].'mgr/widgets/gateways.grid.js');

$output = '<div id="gatewaymanager-panel-index-div"></div>';

return $output;

?>
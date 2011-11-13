<?php

$modx->regClientStartupScript($gatewaymanager->config['jsUrl'].'mgr/gatewaymanager.js');
$modx->regClientStartupHTMLBlock('<script type="text/javascript">
Ext.onReady(function() {
    GatewayManager.config = '.$modx->toJSON($gatewaymanager->config).';
	GatewayManager.config.connector_url = "'.$gatewaymanager->config['connectorUrl'].'";
    GatewayManager.request = '.$modx->toJSON($_GET).';
});
</script>');

return '';

?>
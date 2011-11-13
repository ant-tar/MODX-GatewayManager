<?php

require_once dirname(dirname(__FILE__)).'/model/gatewaymanager/gatewaymanager.class.php';

$model = new GatewayManager($modx);
return $model->initialize('mgr');

?>
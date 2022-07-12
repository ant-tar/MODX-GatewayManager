<?php

/* load action into menu */
$menu= $modx->newObject('modMenu');
$menu->fromArray(array(
    'text' => 'gatewaymanager',
    'parent' => 'components',
    'description' => 'gatewaymanager.desc',
    'icon' => '',
    'menuindex' => 0,
    'action' => 'index',
    'namespace' => 'gatewaymanager',
    'params' => '',
    'handler' => '',
),'',true,true);

return $menu;

?>
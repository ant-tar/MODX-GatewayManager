<?php

if(empty($scriptProperties['id'])) return $modx->error->failure($modx->lexicon('gatewaymanager.error.id_ns'));
$domain = $modx->getObject('gatewayDomain', $scriptProperties['id']);
if(empty($domain)) return $modx->error->failure($modx->lexicon('gatewaymanager.error.nf'));

if($domain->remove() == false) {
    return $modx->error->failure($modx->lexicon('gatewaymanager.error.remove'));
}

return $modx->error->success('', $domain);

?>
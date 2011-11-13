<?php

if(empty($scriptProperties['id'])) return $modx->error->failure($modx->lexicon('gatewaymanager.error.id_ns'));
$domain = $modx->getObject('gatewayDomain', $scriptProperties['id']);
if(empty($domain)) return $modx->error->failure($modx->lexicon('gatewaymanager.error.nf'));

// when sitestart is empty; make it NULL
$scriptProperties['sitestart'] = (!empty($scriptProperties['sitestart'])) ? $scriptProperties['sitestart'] : null;

$domain->fromArray($scriptProperties);

if($domain->save() == false) {
    return $modx->error->failure($modx->lexicon('gatewaymanager.error.update'));
}

return $modx->error->success('', $domain);

?>
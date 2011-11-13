<?php

if(empty($scriptProperties['domain'])) {
    $modx->error->addField('domain', $modx->lexicon('gatewaymanager.error.domain_ns'));
} 
else {
    $alreadyExists = $modx->getObject('gatewayDomain', array('domain' => $scriptProperties['domain']));
    if($alreadyExists) {
        $modx->error->addField('domain', $modx->lexicon('gatewaymanager.error.domain_ae'));
    }
}
 
if($modx->error->hasError()) { return $modx->error->failure(); }

// when sitestart is empty; make it NULL
$scriptProperties['sitestart'] = (!empty($scriptProperties['sitestart'])) ? $scriptProperties['sitestart'] : null;

$domain = $modx->newObject('gatewayDomain');
$domain->fromArray($scriptProperties);
 
if($domain->save() == false) {
    return $modx->error->failure($modx->lexicon('gatewaymanager.error.save'));
}

return $modx->error->success('', $domain);

?>
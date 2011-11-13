<?php

$isLimit = !empty($_REQUEST['limit']);
$start = $modx->getOption('start', $_REQUEST, 0);
$limit = $modx->getOption('limit', $_REQUEST, 20);
$sort = $modx->getOption('sort', $_REQUEST, 'domain');
$dir = $modx->getOption('dir', $_REQUEST, 'ASC');
$query = $modx->getOption('query', $_REQUEST, '');

$c = $modx->newQuery('gatewayDomain');
$c->select('gatewayDomain.*');

if(!empty($query)) {
	$c->andCondition(array(
		'domain:LIKE' => '%'.$query.'%',
		'OR:context:LIKE' => '%'.$query.'%',
		'OR:sitestart:LIKE' => '%'.$query.'%'
	));
}

$count = $modx->getCount('gatewayDomain', $c);
$c->sortby($sort, $dir);
if($isLimit) {
	$c->limit($limit, $start);
}

$results = $modx->getCollection('gatewayDomain', $c);

$list = array();
foreach($results as $index => $entry) {
    $oneItem = $entry->toArray();
	
	// page
	$oneItem['startpage'] = '<span style="color:#8A8A8A;"><i>'.$modx->lexicon('gatewaymanager.startpage.default').'</i></span>';
	if(!empty($oneItem['sitestart'])) {
		$resource = $modx->getObject('modResource', $oneItem['sitestart']);
		$oneItem['startpage'] = $modx->lexicon('gatewaymanager.startpage.id').': '.$oneItem['sitestart'].' ('.$resource->get('pagetitle').')';
	}
	
	// right-mouse menu
    $oneItem['menu'] = array();
    $oneItem['menu'][] = array(
        'text' => $modx->lexicon('gatewaymanager.update'),
        'handler' => 'this.updateGateway'
    );
    $oneItem['menu'][] = '-';
    $oneItem['menu'][] = array(
        'text' => $modx->lexicon('gatewaymanager.remove'),
        'handler' => 'this.removeGateway'
    );
	
    $list[] = $oneItem;
}

return $this->outputArray($list, $count);

?>
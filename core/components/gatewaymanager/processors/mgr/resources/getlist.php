<?php

$isLimit = !empty($_REQUEST['limit']);
$start = $modx->getOption('start', $_REQUEST, 0);
$limit = $modx->getOption('limit', $_REQUEST, 20);
$context = $modx->getOption('cntx', $_REQUEST, 'web');
$query = $modx->getOption('query', $_REQUEST, '');

$c = $modx->newQuery('modResource');
$c->select('modResource.id, modResource.pagetitle');
$c->where(array('context_key' => $context));

if(!empty($query)) {
	$c->andCondition(array(
		'pagetitle:LIKE' => '%'.$query.'%'
	));
}

$count = $modx->getCount('modResource', $c);
if($isLimit) {
	$c->limit($limit, $start);
}

$results = $modx->getCollection('modResource', $c);

$list = array();
foreach($results as $index => $entry) {
    $oneItem = $entry->toArray();
	
    $list[] = $oneItem;
}

return $this->outputArray($list, $count);

?>
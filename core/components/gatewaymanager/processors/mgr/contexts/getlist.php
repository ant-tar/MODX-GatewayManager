<?php

$isLimit = !empty($_REQUEST['limit']);
$start = $modx->getOption('start', $_REQUEST, 0);
$limit = $modx->getOption('limit', $_REQUEST, 20);
$query = $modx->getOption('query', $_REQUEST, '');

$c = $modx->newQuery('modContext');
$c->select('modContext.*');
$c->where(array(
	'key:!=' => 'mgr'
));

if(!empty($query)) {
	$c->andCondition(array(
		'key:LIKE' => '%'.$query.'%'
	));
}

$count = $modx->getCount('modContext', $c);
if($isLimit) {
	$c->limit($limit, $start);
}

$results = $modx->getCollection('modContext', $c);

$list = array();
foreach($results as $index => $entry) {
    $oneItem = $entry->toArray();
	
    $list[] = $oneItem;
}

return $this->outputArray($list, $count);

?>
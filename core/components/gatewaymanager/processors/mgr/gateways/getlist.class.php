<?php

class GatewaysGetListProcessor extends modObjectGetListProcessor {
	public $classKey = 'gatewayDomain';
	public $languageTopics = array('gatewaymanager:default');
	public $defaultSortField = 'domain';
	public $defaultSortDirection = 'ASC';
	public $objectType = 'gatewaymanager.gatewaydomain';
	
	/**
     * Can be used to adjust the query prior to the COUNT statement
     *
     * @param xPDOQuery $c
     * @return xPDOQuery
     */
    public function prepareQueryBeforeCount(xPDOQuery $c) {
		$query = $this->getProperty('query');
		if(!empty($query)) {
			$c->andCondition(array(
				'domain:LIKE' => '%'.$query.'%',
				'OR:context:LIKE' => '%'.$query.'%',
				'OR:sitestart:LIKE' => '%'.$query.'%'
			));
		}
		return $c;
    }
	
	/**
     * Prepare the row for iteration
     * @param xPDOObject $object
     * @return array
     */
    public function prepareRow(xPDOObject $object) {
        $arr = $object->toArray();
		$arr['startpage'] = '';
		$arr['sitestart'] = (string) $arr['sitestart'];
		if(!empty($arr['sitestart'])) {
			$resource = $this->modx->getObject('modResource', $arr['sitestart']);
			$arr['startpage'] = $resource->get('pagetitle');
		}
		return $arr;
    }
}
return 'GatewaysGetListProcessor';

?>
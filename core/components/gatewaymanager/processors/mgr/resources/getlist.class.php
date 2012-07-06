<?php

class ResourcesGetListProcessor extends modObjectGetListProcessor {
	public $classKey = 'modResource';
	public $languageTopics = array('gatewaymanager:default');
	public $defaultSortField = 'id';
	public $defaultSortDirection = 'ASC';
	public $objectType = 'modresource';
	
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
				'pagetitle:LIKE' => '%'.$query.'%'
			));
		}
		return $c;
    }
}
return 'ResourcesGetListProcessor';

?>
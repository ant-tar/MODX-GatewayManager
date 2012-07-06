<?php

class ContextsGetListProcessor extends modObjectGetListProcessor {
	public $classKey = 'modContext';
	public $languageTopics = array('gatewaymanager:default');
	public $defaultSortField = 'key';
	public $defaultSortDirection = 'ASC';
	public $objectType = 'modcontext';
	
	/**
     * Can be used to adjust the query prior to the COUNT statement
     *
     * @param xPDOQuery $c
     * @return xPDOQuery
     */
    public function prepareQueryBeforeCount(xPDOQuery $c) {
		$c->where(array('key:!=' => 'mgr'));
		
		$query = $this->getProperty('query');
		if(!empty($query)) {
			$c->andCondition(array(
				'key:LIKE' => '%'.$query.'%'
			));
		}
		return $c;
    }
}
return 'ContextsGetListProcessor';

?>
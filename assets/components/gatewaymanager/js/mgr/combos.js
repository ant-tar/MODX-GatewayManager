/**
 * Context list combobox
 */
GatewayManager.combo.ContextList = function(config) {
    config = config || {};
    Ext.applyIf(config, {
        name: 'context',
		hiddenName: 'context',
		displayField: 'key',
		valueField: 'key',
		fields: ['key'],
		forceSelection: true,
		typeAhead: true,
		editable: true,
		allowBlank: false,
		autocomplete: true,
		url: GatewayManager.config.connector_url,
		baseParams: {
            action: 'mgr/contexts/getList',
			combo: true
        }
    });
	
    GatewayManager.combo.ContextList.superclass.constructor.call(this, config);
};

Ext.extend(GatewayManager.combo.ContextList, MODx.combo.ComboBox);
Ext.reg('gatewaymanager-combo-contextlist', GatewayManager.combo.ContextList);

/**
 * Resources autocompleter combobox
 */
GatewayManager.combo.ResourcesList = function(config) {
    config = config || {};
    Ext.applyIf(config, {
        name: 'sitestart',
		hiddenName: 'sitestart',
		displayField: 'pagetitle',
		valueField: 'id',
		fields: ['id','pagetitle'],
		forceSelection: true,
		typeAhead: true,
		editable: true,
		allowBlank: true,
		autocomplete: true,
		queryParam: 'query',
		url: GatewayManager.config.connector_url,
		baseParams: {
            action: 'mgr/resources/getList',
			combo: true
        }
    });
	
    GatewayManager.combo.ResourcesList.superclass.constructor.call(this, config);
};

Ext.extend(GatewayManager.combo.ResourcesList, MODx.combo.ComboBox);
Ext.reg('gatewaymanager-combo-resourceslist', GatewayManager.combo.ResourcesList);
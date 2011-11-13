Ext.onReady(function() {
    MODx.load({ xtype: 'gatewaymanager-page-index' });
});

// index page
GatewayManager.page.Index = function(config) {
	config = config || {};

	Ext.applyIf(config,{
		buttons: {
			text: _('help_ex'),
			handler: MODx.loadHelpPane
		},
		components: [{
			xtype: 'gatewaymanager-panel-index',
			renderTo: 'gatewaymanager-panel-index-div'
		}]
	});

	GatewayManager.page.Index.superclass.constructor.call(this, config);
};

Ext.extend(GatewayManager.page.Index, MODx.Component);
Ext.reg('gatewaymanager-page-index', GatewayManager.page.Index);
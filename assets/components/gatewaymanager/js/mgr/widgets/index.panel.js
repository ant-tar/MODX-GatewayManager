GatewayManager.panel.Index = function(config) {
    config = config || {};
    Ext.apply(config, {
        border: false,
		baseCls: 'modx-formpanel',
		items: [{
				html: '<h2>'+_('gatewaymanager.manage')+'</h2>',
				border: false,
				cls: 'modx-page-header'
			},{
				xtype: 'modx-tabs',
				bodyStyle: 'padding: 10px',
				defaults: { border: false, autoHeight: true },
				border: true,
				stateful: true,
				stateId: 'gatewaymanager-orders-tabpanel',
				stateEvents: ['tabchange'],
				getState: function() {
					return { activeTab:this.items.indexOf(this.getActiveTab()) };
				},
				items: [{
					title: _('gatewaymanager.gateways'),
					defaults: { autoHeight: true },
					items: [
						{
							html: '<p>'+_('gatewaymanager.gateways.desc')+'</p><br />',
							border: false
						},{
							xtype: 'gatewaymanager-grid-gateways',
							preventRender: true
						}
					]
				}]
			}
		]
    });

    GatewayManager.panel.Index.superclass.constructor.call(this, config);
};

Ext.extend(GatewayManager.panel.Index, MODx.Panel);
Ext.reg('gatewaymanager-panel-index', GatewayManager.panel.Index);
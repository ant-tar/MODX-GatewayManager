GatewayManager.panel.Index = function(config) {
    config = config || {};
    Ext.apply(config, {
        border: false,
		baseCls: 'modx-formpanel',
		cls: 'container',
		defaults: { collapsible: false ,autoHeight: true },
		items: [{
			html: '<h2>'+_('gatewaymanager.manage')+'</h2>',
			border: false,
			cls: 'modx-page-header'
		},{
			defaults: { border: false, autoHeight: true },
			items: [{
				html: '<p>' + _('gatewaymanager.gateways.desc') + '</p>',
				bodyCssClass: 'panel-desc'
			},{
				xtype: 'gatewaymanager-grid-gateways',
				preventRender: true,
				cls: 'main-wrapper'
			}]
		}]
    });

    GatewayManager.panel.Index.superclass.constructor.call(this, config);
};

Ext.extend(GatewayManager.panel.Index, MODx.Panel);
Ext.reg('gatewaymanager-panel-index', GatewayManager.panel.Index);
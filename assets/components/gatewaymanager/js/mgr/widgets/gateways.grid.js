GatewayManager.grid.Gateways = function(config) {
    config = config || {};

    Ext.applyIf(config, {
        id: 'gatewaymanager-grid-statuses',
		url: GatewayManager.config.connector_url,
		baseParams: { action: 'mgr/gateways/getlist' },
		fields: ['id','domain','context','sitestart','startpage','menu'],
		paging: true,
		remoteSort: true,
		anchor: '97%',
		autoExpandColumn: 'domain',
		columns: [{
				header: _('gatewaymanager.domain'),
				dataIndex: 'domain',
				sortable: true
			},{
				header: _('gatewaymanager.context'),
				dataIndex: 'context',
				sortable: true
			},{
				header: _('gatewaymanager.startpage'),
				dataIndex: 'startpage',
				sortable: true
			}
		],
		tbar: [{
				text: _('gatewaymanager.create'),
				handler: {
					xtype: 'gatewaymanager-window-create',
					blankValues: true
				}
			},{
				xtype: 'tbfill'
			},{
				xtype: 'textfield',
				id: 'gateways-search-filter',
				emptyText: _('gatewaymanager.search'),
				listeners: {
					'change': { fn: this.search, scope:this },
					'render': { fn: function(tf) {
							tf.getEl().addKeyListener(Ext.EventObject.ENTER, function() {
								this.search(tf);
							}, this);
						},
						scope: this
					}
				}
			}
		]
    });

    GatewayManager.grid.Gateways.superclass.constructor.call(this, config);
};

Ext.extend(GatewayManager.grid.Gateways, MODx.grid.Grid, {
	search: function(tf, nv, ov) {
        var s = this.getStore();
        s.baseParams.query = tf.getValue();
        this.getBottomToolbar().changePage(1);
        this.refresh();
    },
	updateGateway: function(btn, e) {
		if(!this.updateGatewayWindow) {
			this.updateGatewayWindow = MODx.load({
				xtype: 'gatewaymanager-window-update',
				record: this.menu.record,
				listeners: {
					'success': { fn: this.refresh, scope: this }
				}
			});
		} else {
			this.updateGatewayWindow.setValues(this.menu.record);
		}
		this.updateGatewayWindow.show(e.target);
	},
	removeGateway: function(btn, e) {
		MODx.msg.confirm({
			title: _('gatewaymanager.remove', { title: this.menu.record.title }),
			text: _('gatewaymanager.remove_confirm', { title: this.menu.record.title }),
			url: this.config.url,
			params: {
				action: 'mgr/gateways/remove',
				id: this.menu.record.id
			},
			listeners: {
				'success': { fn:this.refresh, scope:this }
			}
		});
	}
});

Ext.reg('gatewaymanager-grid-gateways', GatewayManager.grid.Gateways);

// ------------------
// Create window
GatewayManager.window.CreateGateway = function(config) {
	config = config || {};
	Ext.applyIf(config,{
		title: _('gatewaymanager.create'),
		url: GatewayManager.config.connector_url,
		baseParams: {
			action: 'mgr/gateways/create'
		},
		fields: [{
			xtype: 'textfield',
			fieldLabel: _('gatewaymanager.domain'),
			name: 'domain',
			width: 300,
			allowBlank: false
		},{
			xtype: 'gatewaymanager-combo-contextlist',
			id: 'gatewaymanager-contextlist',
			fieldLabel: _('gatewaymanager.context'),
			name: 'context',
			width: 300,
			allowBlank: false,
			listeners: {
				'select': {
					fn: this.onSelectContext,
					scope: this
				}
			}
		},{
			xtype: 'gatewaymanager-combo-resourceslist',
			id: 'gatewaymanager-resourcelist',
			fieldLabel: _('gatewaymanager.startpage'),
			name: 'sitestart',
			width: 300,
			allowBlank: true
		}]
	});
	GatewayManager.window.CreateGateway.superclass.constructor.call(this,config);
};
Ext.extend(GatewayManager.window.CreateGateway, MODx.Window, {
	onSelectContext: function(cb) {
		var rl = Ext.getCmp('gatewaymanager-resourcelist');
		var s = rl.getStore();
        s.baseParams.cntx = cb.getValue();
        s.load();
		rl.clearValue();
	}
});
Ext.reg('gatewaymanager-window-create', GatewayManager.window.CreateGateway);

// ------------------
// Update window
GatewayManager.window.UpdateGateway = function(config) {
	config = config || {};
	Ext.applyIf(config,{
		title: _('gatewaymanager.update'),
		url: GatewayManager.config.connector_url,
		baseParams: {
			action: 'mgr/gateways/update'
		},
		fields: [{
			xtype: 'textfield',
			name: 'id',
			hidden: true
		},{
			xtype: 'textfield',
			fieldLabel: _('gatewaymanager.domain'),
			name: 'domain',
			width: 300,
			allowBlank: false
		},{
			xtype: 'gatewaymanager-combo-contextlist',
			id: 'gatewaymanager-contextlist-upd',
			fieldLabel: _('gatewaymanager.context'),
			name: 'context',
			width: 300,
			allowBlank: false,
			listeners: {
				'render': {
					fn: this.onSelectContext,
					scope: this
				},
				'select': {
					fn: this.onSelectContext,
					scope: this
				}
			}
		},{
			xtype: 'gatewaymanager-combo-resourceslist',
			id: 'gatewaymanager-resourcelist-upd',
			fieldLabel: _('gatewaymanager.startpage'),
			name: 'sitestart',
			width: 300,
			allowBlank: true
		}]
	});
	GatewayManager.window.UpdateGateway.superclass.constructor.call(this,config);
};
Ext.extend(GatewayManager.window.UpdateGateway, MODx.Window, {
	onSelectContext: function(cb) {
		var rl = Ext.getCmp('gatewaymanager-resourcelist-upd');
		var s = rl.getStore();
        s.baseParams.cntx = cb.getValue();
        s.load();
		rl.clearValue();
	}
});
Ext.reg('gatewaymanager-window-update', GatewayManager.window.UpdateGateway);
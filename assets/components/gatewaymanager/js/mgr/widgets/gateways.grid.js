GatewayManager.grid.Gateways = function(config) {
    config = config || {};

    Ext.applyIf(config, {
        id: 'gatewaymanager-grid-statuses',
		url: GatewayManager.config.connector_url,
		baseParams: { action: 'mgr/gateways/getList' },
		save_action: 'mgr/gateways/updateFromGrid',
		autosave: true,
		
		fields: ['id','domain','context','sitestart','startpage','active'],
		paging: true,
		remoteSort: true,
		anchor: '97%',
		autoExpandColumn: 'domain',
		columns: [{
			header: _('gatewaymanager.domain'),
			dataIndex: 'domain',
			sortable: true,
			editor: { xtype: 'textfield', allowBlank: false }
		},{
			header: _('gatewaymanager.context'),
			dataIndex: 'context',
			sortable: true,
			editor: { xtype: 'gatewaymanager-combo-contextlist' }
		},{
			header: _('gatewaymanager.startpage'),
			dataIndex: 'sitestart',
			sortable: true,
			renderer: this.renderResourceList.createDelegate(this,[this],true),
			editor: { xtype: 'gatewaymanager-combo-resourceslist' }
		},{
			header: _('gatewaymanager.active'),
			dataIndex: 'active',
			sortable: true,
			width: 40,
			renderer: this.renderYNfield.createDelegate(this,[this],true),
			editor: { xtype: 'combo-boolean' }
		}],
		tbar: [{
			text: _('gatewaymanager.create'),
			handler: {
				xtype: 'gatewaymanager-window-create',
				blankValues: true
			}
		},'->',{
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
		}],
		listeners: {
			'afterAutoSave': {
				fn: function(response) {
					if(response.success) {
						this.refresh();
					}
				},
				scope: this
			}
		}
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
	renderYNfield: function(v,md,rec,ri,ci,s,g) {
        var r = s.getAt(ri).data;
        v = Ext.util.Format.htmlEncode(v);
        var f = MODx.grid.Grid.prototype.rendYesNo;
        return f(v,md,rec,ri,ci,s,g);
    },
	renderResourceList: function(v,md,rec,ri,ci,s,g) {
		if(v.length == 0) {
			return '<span style="color:#8A8A8A;"><i>' + _('gatewaymanager.startpage.default') + '</i></span>';
		}
		var r = s.getAt(ri).data;
		return r.startpage + ' (' + _('gatewaymanager.startpage.id') + ': ' + v + ')';
	},
	getMenu: function() {
		var m = [{
			text: _('gatewaymanager.remove'),
			handler: this.removeGateway
		}];
		return m;
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
		modal: true,
		width: 450,
		fields: [{
			xtype: 'textfield',
			fieldLabel: _('gatewaymanager.domain'),
			name: 'domain',
			anchor: '100%',
			allowBlank: false
		},{
			xtype: 'gatewaymanager-combo-contextlist',
			id: 'gatewaymanager-contextlist',
			fieldLabel: _('gatewaymanager.context'),
			name: 'context',
			anchor: '100%',
			allowBlank: false,
			listeners: {
				'select': { fn: this.onSelectContext, scope: this }
			}
		},{
			xtype: 'gatewaymanager-combo-resourceslist',
			id: 'gatewaymanager-resourcelist',
			fieldLabel: _('gatewaymanager.startpage'),
			name: 'sitestart',
			anchor: '100%',
			allowBlank: true
		},{
			xtype: 'xcheckbox',
			hideLabel: true,
			boxLabel: _('gatewaymanager.context.createsettings'),
			description: _('gatewaymanager.context.createsettings.desc'),
			name: 'create-context-settings'
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
GatewayManager.grid.Gateways = function(config) {
    config = config || {};
    this.ident = config.ident || Ext.id();

    Ext.applyIf(config, {
        id: 'gatewaymanager-grid-statuses'
		,url: GatewayManager.config.connectorUrl
		,baseParams: { action: 'mgr/gateways/getlist' }
		,save_action: 'mgr/gateways/updatefromgrid'
		,autosave: true

		,fields: ['id','domain','context','sitestart','startpage','active']
		,paging: true
		,remoteSort: true
		,anchor: '97%'
		,autoExpandColumn: 'domain'
		,columns: [{
			header: _('gatewaymanager.domain')
			,dataIndex: 'domain'
			,sortable: true
			,editor: { xtype: 'textfield', allowBlank: false }
		},{
			header: _('gatewaymanager.context')
			,dataIndex: 'context'
			,sortable: true
		},{
			header: _('gatewaymanager.startpage')
			,dataIndex: 'sitestart'
			,sortable: true
			,renderer: this.renderResourceList.createDelegate(this,[this],true)
		},{
			header: _('gatewaymanager.active')
			,dataIndex: 'active'
			,sortable: true
			,width: 40
			,renderer: this.renderYNfield.createDelegate(this,[this],true)
			,editor: { xtype: 'combo-boolean' }
		}]
        ,tbar: [{
			text: _('gatewaymanager.create')
            ,cls: 'primary-button'
            ,handler: {
				xtype: 'gatewaymanager-window-createupdate'
                ,blankValues: true
                ,update: false
			}
		},'->',{
			xtype: 'textfield'
            ,id: 'gateways-search-filter'
            ,emptyText: _('gatewaymanager.search')
            ,listeners: {
				'change': { fn: this.search, scope:this }
                ,'render': { fn: function(tf) {
						tf.getEl().addKeyListener(Ext.EventObject.ENTER, function() {
							this.search(tf);
						}, this);
					},
					scope: this
				}
			}
		}]
        ,listeners: {
			'afterAutoSave': {
				fn: function(response) {
					if(response.success) {
						this.refresh();
					}
				}
                ,scope: this
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
    }
    ,getMenu: function() {
		var m = [{
			text: _('gatewaymanager.update')
            ,handler: this.updateGateway
		},'-',{
			text: _('gatewaymanager.remove')
            ,handler: this.removeGateway
		}];
		return m;
	}
    ,updateGateway: function(btn, e) {
        var w = MODx.load({
            xtype: 'gatewaymanager-window-createupdate'
            ,record: this.menu.record
            ,update: true
            ,listeners: {
                'success': { fn: this.refresh, scope: this }
                ,'hide': { fn: function() { this.destroy(); }}
            }
        });
        w.setTitle(_('gatewaymanager.update'));
        w.setValues(this.menu.record);
        w.show(e.target, function() {
            Ext.isSafari ? w.setPosition(null,30) : w.center();
        }, this);
    }
	,removeGateway: function(btn, e) {
		MODx.msg.confirm({
			title: _('gatewaymanager.remove', { title: this.menu.record.title })
            ,text: _('gatewaymanager.remove_confirm', { title: this.menu.record.title })
            ,url: this.config.url
            ,params: {
				action: 'mgr/gateways/remove'
                ,id: this.menu.record.id
			}
            ,listeners: {
				'success': { fn: this.refresh ,scope: this }
			}
		});
	}
    /** SOME RENDERS **/
    ,renderYNfield: function(v,md,rec,ri,ci,s,g) {
        var r = s.getAt(ri).data;
        v = Ext.util.Format.htmlEncode(v);
        var f = MODx.grid.Grid.prototype.rendYesNo;
        return f(v,md,rec,ri,ci,s,g);
    }
    ,renderResourceList: function(v,md,rec,ri,ci,s,g) {
        if(v.length == 0) {
            return '<span style="color:#8A8A8A;"><i>' + _('gatewaymanager.startpage.default') + '</i></span>';
        }
        var r = s.getAt(ri).data;
        return r.startpage + ' (' + _('gatewaymanager.startpage.id') + ': ' + v + ')';
    }
});

Ext.reg('gatewaymanager-grid-gateways', GatewayManager.grid.Gateways);

// ------------------
// Create window
GatewayManager.window.CreateUpdateGateway = function(config) {
	config = config || {};
    this.ident = config.ident || Ext.id();

	Ext.applyIf(config,{
		title: _('gatewaymanager.create')
        ,url: GatewayManager.config.connectorUrl
        ,baseParams: {
			action: (config.update) ? 'mgr/gateways/update' : 'mgr/gateways/create'
		}
        ,modal: true
        ,width: 450
        ,autoHeight: true
        ,fields: [{
            xtype: 'hidden'
            ,name: 'id'
        },{
			xtype: 'textfield'
            ,fieldLabel: _('gatewaymanager.domain')
            ,name: 'domain'
            ,anchor: '100%'
            ,allowBlank: false
		},{
            xtype: 'label'
            ,html: _('gatewaymanager.domain_desc')
            ,cls: 'desc-under'
        },{
			xtype: 'gatewaymanager-combo-contextlist'
            ,id: 'gatewaymanager-contextlist-' + this.ident
            ,fieldLabel: _('gatewaymanager.context')
            ,name: 'context'
            ,anchor: '100%'
            ,allowBlank: false
            ,listeners: {
				'select': { fn: this.onSelectContext, scope: this }
			}
		},{
            xtype: 'label'
            ,html: _('gatewaymanager.context_desc')
            ,cls: 'desc-under'
        },{
			xtype: 'gatewaymanager-combo-resourceslist'
            ,id: 'gatewaymanager-resourcelist-' + this.ident
            ,fieldLabel: _('gatewaymanager.startpage')
            ,name: 'sitestart'
            ,anchor: '100%'
            ,allowBlank: true
            ,listeners: {
                'afterrender': { fn: this.onResourceList, scope: this }
            }
		},{
            xtype: 'label'
            ,html: _('gatewaymanager.startpage_desc')
            ,cls: 'desc-under'
        },{
			xtype: 'xcheckbox'
            ,hideLabel: true
            ,boxLabel: _('gatewaymanager.context.createsettings')
            ,name: 'create-context-settings'
		},{
            xtype: 'label'
            ,html: _('gatewaymanager.context.createsettings.desc')
            ,cls: 'desc-under'
        }]
	});
	GatewayManager.window.CreateUpdateGateway.superclass.constructor.call(this,config);
};
Ext.extend(GatewayManager.window.CreateUpdateGateway, MODx.Window, {
    onResourceList: function(cb) {
        var contextBox = Ext.getCmp('gatewaymanager-contextlist-' + this.ident);
        var s = cb.getStore();
            s.baseParams.cntx = contextBox.getValue();
            s.load();
    }
	,onSelectContext: function(cb) {
        var resourcesBox = Ext.getCmp('gatewaymanager-resourcelist-' + this.ident);
        this.onResourceList(resourcesBox);
        resourcesBox.clearValue();
	}
});
Ext.reg('gatewaymanager-window-createupdate', GatewayManager.window.CreateUpdateGateway);
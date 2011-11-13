var GatewayManager = function(config) {
    config = config || {};
    GatewayManager.superclass.constructor.call(this, config);
};

Ext.extend(GatewayManager, Ext.Component,{
    page:{}, window:{}, grid:{}, tree:{}, panel:{}, combo:{}, config:{}
});

Ext.reg('gatewaymanager', GatewayManager);
GatewayManager = new GatewayManager();
MODx.config.help_url = 'http://rtfm.modx.com/display/ADDON/GatewayManager';
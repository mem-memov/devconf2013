Ext.define('Doctor.view.HtmlPanel', {
    
    extend: 'Ext.panel.Panel',
    
    alias: 'widget.app-html-panel',
    
    layout: 'fit',
    
    initComponent: function() {
        
        this.isUpdated = false;
        
        if (Ext.isString(this.store) || (Ext.isObject(this.store) && !this.store.isStore) ) {
            this.store = Ext.StoreMgr.lookup(this.store);
        }
        
        this.callParent(arguments);
        
    }
    
});
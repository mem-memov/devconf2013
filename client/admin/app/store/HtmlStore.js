Ext.define('Admin.store.HtmlStore', {
    
    extend: 'Ext.data.Store',
    
    alias: 'store.app-html-store',

    model: 'Admin.model.HtmlModel',
    
    proxy: {
        
        type: 'direct',
        
        api: {
            
            read: 'Ext.remote.Html.read'
            
        },
        
        reader: {
            type: 'json'
        }
        
    }
    
});
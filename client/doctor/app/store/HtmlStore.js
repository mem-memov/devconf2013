Ext.define('Doctor.store.HtmlStore', {
    
    extend: 'Ext.data.Store',
    
    alias: 'store.app-html-store',

    model: 'Doctor.model.HtmlModel',
    
    proxy: {
        
        type: 'direct',
        
        directFn: 'Ext.remote.Html.read',
        
        reader: {
            type: 'json'
        }
        
    }
    
});
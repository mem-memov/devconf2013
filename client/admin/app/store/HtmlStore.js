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
        
    }//,
    
//    data: [
//        { id: 1, html: '<img src="resources/images/portret.png" />' },
//        { id: 2, html: '<p>Lorem ipsum</p>' },
//        { id: 3, html: '<p>ляляляля</p>' }
//    ]
    
});
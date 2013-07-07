Ext.define('Admin.model.HtmlModel', {
    
    extend: 'Ext.data.Model',
    
    idProperty: 'id',

    fields: [
        
        { name:'id', type: 'int', useNull: true }, 
        { name:'html', type: 'string' }
        
    ],
    
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
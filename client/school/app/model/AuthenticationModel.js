Ext.define('school.model.AuthenticationModel', {
    
    extend: 'Ext.data.Model',
    
    idProperty: 'id',
    
    fields: [
        { name: 'id', type: 'int', useNull: true },
        { name: 'password', type: 'string' }
    ]
    
//    proxy: {
//        
//        type: 'direct',
//        
//        api: {
//
//            create: 'Ext.remote.Authentication.login', // строка!!!
//            read: 'Ext.remote.Authentication.login', // строка!!!
//            update: 'Ext.remote.Authentication.login', // строка!!!
//            destroy: 'Ext.remote.Authentication.login' // строка!!!
//            
//        },
//        
//        reader: {
//            type: 'json',
//            root: 'data'
//        }
//        
//    }
    
});


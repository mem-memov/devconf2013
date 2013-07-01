Ext.define('Admin.store.MenuStore', {
    
    extend: 'Ext.data.TreeStore',
    
    alias: 'store.app-menu-store',
    
    require: ['Admin.model.MenuModel'],

    model: 'Admin.model.MenuModel',
    
//    autoSync: true,
    //defaultRootId: 'root',
    autoLoad: true,
    
    root: {
        expanded: true,
        text: 'ttt',
        id: null
    },


    proxy: {
        
        type: 'direct',
        
        api: {

//            create: function(newNodeData, requestCallBack, directProxy) {
//
//                if (newNodeData.leaf) {
//                    
//                    Ext.remote.Menu.appendReference(
//                        newNodeData.parentId,
//                        newNodeData.text,
//                        requestCallBack
//                    );
//                    
//                } else {
//                    
//                    Ext.remote.Menu.appendList(
//                        newNodeData.parentId,
//                        newNodeData.text,
//                        requestCallBack
//                    );
//                        
//                }
//                
//            },
            
            
            read: 'Ext.remote.Menu.readMenu'//,
            
            
//            update: function(data, requestCallBack, directProxy) {
//
//                Ext.remote.Menu.updateMenu(
//                    data['id'],
//                    data['text'],
//                    'dashboard', //data['link_type'],
//                    data['link_id'],
//                    requestCallBack
//                );
//                    
//            },
//            
//            destroy : function(data, requestCallBack, directProxy) {
//
//                Ext.remote.Menu.destroyMenu(
//                    data['id'],
//                    requestCallBack
//                );
//                
//            }
            
        },
        
        reader: {
            type: 'json',
            root: 'children' // ответ сервера должен содержать такой ключ, чтобы клиент смог прочитать его
        }
        
    }
    
});
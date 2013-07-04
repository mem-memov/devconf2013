Ext.define('Admin.store.MenuStore', {
    
    extend: 'Ext.data.TreeStore',
    
    alias: 'store.app-menu-store',

    model: 'Admin.model.MenuModel',
    
    autoSync: true, // автоматическая синхронизация данных с сервером

    root: {
        text: 'Меню',
        id: '0',
        expanded: true // значение ИСТИНА запускает загрузку дочерних узлов с сервера, поскольку они не заданы. В ответе сервера корневой узел должен иметь признак loaded = true
    },

    proxy: {
        
        type: 'direct',
        
        api: {

            create: 'Ext.remote.Menu.createMenuItem',
            read: 'Ext.remote.Menu.readMenu',
            update: 'Ext.remote.Menu.updateMenuItem',
            destroy : 'Ext.remote.Menu.deleteMenuItem'
            
        },
        
        reader: {
            type: 'json',
            root: 'children' // ответ сервера должен содержать такой ключ, чтобы клиент смог прочитать его.
        }
        
    }
    
});
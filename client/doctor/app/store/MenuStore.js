Ext.define('Doctor.store.MenuStore', {
    
    extend: 'Ext.data.TreeStore',
    
    alias: 'store.app-menu-store',

    model: 'Doctor.model.MenuModel',

    proxy: {
        
        type: 'direct',
        
        directFn: 'Ext.remote.Menu.readMenu',
        
        reader: {
            type: 'json',
            root: 'children' // ответ сервера должен содержать такой ключ, чтобы клиент смог прочитать его
        }
        
    }
    
});
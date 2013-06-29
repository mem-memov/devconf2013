Ext.define('doctor.store.MenuStore', {
    
    extend: 'Ext.data.TreeStore',
    
    alias: 'store.app-menu-store',

    model: 'doctor.model.MenuModel',
    
    proxy: {
        type: 'memory',
        reader: {
            type: 'json',
            root: 'children'
        }
    }
    
});
Ext.define('Admin.view.menu.ContextMenuForReference', {
    
    extend: 'Ext.menu.Menu',
    
    alias: 'widget.app-context-menu-for-reference',
    
    items: [{        
        text: 'Переименовать',
        itemId: 'rename-button',
        icon: 'resources/images/icons/edit.png'     
    },{        
        text: 'Удалить',
        itemId: 'delete-button',
        icon: 'resources/images/icons/delete.png'     
    }]

    
});
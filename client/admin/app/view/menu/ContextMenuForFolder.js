Ext.define('Admin.view.menu.ContextMenuForFolder', {
    
    extend: 'Ext.menu.Menu',
    
    alias: 'widget.app-context-menu-for-folder',
    
    items: [{                                
        text: 'Создать раздел',
        itemId: 'create-folder-button',
        icon: 'resources/images/icons/folder.gif'
    },{        
        text: 'Создать пункт',
        itemId: 'create-reference-button',
        icon: 'resources/images/icons/leaf.gif'    
    },{        
        text: 'Переименовать',
        itemId: 'rename-button',
        icon: 'resources/images/icons/edit.png'     
    },{        
        text: 'Удалить',
        itemId: 'delete-button',
        icon: 'resources/images/icons/delete.png'     
    }]

    
});
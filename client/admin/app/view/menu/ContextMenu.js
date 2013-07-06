Ext.define('Admin.view.menu.ContextMenu', {
    
    extend: 'Ext.menu.Menu',
    
    alias: 'widget.app-menu-context-menu',
    
    closeAction: 'hide',
    
    items: [{                                
        text: 'Создать раздел',
        itemId: 'create-folder-button',
        icon: 'resources/images/icons/folder.gif'
    },{        
        text: 'Создать пункт',
        icon: 'resources/images/icons/leaf.gif',
        itemId: 'create-reference-button-list',
        menu: [
            {
                text: 'HTML',
                itemId: 'create-html-button'
            }
        ]
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
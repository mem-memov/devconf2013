Ext.define('Admin.view.menu.ContextMenuForTopFolder', {
    
    extend: 'Ext.menu.Menu',
    
    alias: 'widget.app-context-menu-for-top-folder',
    
    items: [{                                
        text: 'Создать раздел',
        itemId: 'create-folder-button',
        icon: 'resources/images/icons/folder.gif'
    },{        
        text: 'Создать пункт',
        itemId: 'create-reference-button',
        icon: 'resources/images/icons/leaf.gif'    
    }]

    
});
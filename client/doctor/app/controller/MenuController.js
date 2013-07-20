Ext.define('Doctor.controller.MenuController', {
    
    extend: 'Ext.app.Controller',
    
    init: function () {

        this.listen({
            component: {
                'app-menu [ItemId="app-menu-list"]': {
                    expand: this.onListExpand
                },
                'app-menu [ItemId="app-menu-item"]': {
                    click: this.onItemClick
                }
            }
        });
        
    },
    
    onListExpand: function(menuItemList) {
        
        Ext.Array.each(Ext.ComponentQuery.query('app-menu [ItemId="app-menu-item"]'), function(menuItem) {
            menuItem.isSelected = false;
        });
        
        this.fireEvent('menu-division-expanded', menuItemList.node);
        
    },
    
    onItemClick: function(menuItem) {

        if (menuItem.isSelected) { // предотвращаем повторные срабатывания
            return;
        }

        Ext.Array.each(Ext.ComponentQuery.query('app-menu [ItemId="app-menu-item"]'), function(menuItem) {
            menuItem.isSelected = false;
        });
        
        menuItem.isSelected = true;
        
        this.fireEvent('menu-item-selected', menuItem.node);
        
    }
    
    
});

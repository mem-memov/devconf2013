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
        
        this.fireEvent('menu-division-expanded', menuItemList.node);
        
    },
    
    onItemClick: function(menuItem) {

        this.fireEvent('menu-item-selected', menuItem.node);
        
    }
    
    
});

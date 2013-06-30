Ext.define('Doctor.view.Viewport', {
    
    extend: 'Ext.container.Viewport',
    
    alias: 'widget.app-viewport',

    layout: {
        type: 'absolute'
    },

    items: [{
        xtype: 'panel',
        ItemId: 'menu-container',
        width: 250, 
        x: -250, // скрываем, чтобы показать с анимацией
        anchor: 'auto 0', 
        layout: 'fit',
        items: [{
            xtype: 'app-menu',
            store: {
                type: 'app-menu-store'
            }
        }]
    },{
        border: 10,
        ItemId: 'content-container',
        anchor: '0 0', 
        x: 0,
        animCollapse: true,
        layout: 'fit',
        items: [
            {
                xtype: 'app-html-panel'
            }
        ]
    }]

});

Ext.define('doctor.view.Viewport', {
    
    extend: 'Ext.container.Viewport',
    
    alias: 'widget.app-viewport',

    layout: {
        type: 'absolute'
    },

    items: [{
        xtype: 'panel',
        componentCls: 'menu-container',
        width: 150, 
        x: -150, // скрываем, чтобы показать с анимацией
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
        componentCls: 'content-container',
        anchor: '0 0',
        x: 0,
        html: 'lalala',
        animCollapse: true
    }]

});

Ext.define('Admin.view.Viewport', {
    
    extend: 'Ext.container.Viewport',
    
    alias: 'widget.app-viewport',

    layout: {
        type: 'fit'
    },

    items: [
        {
            title: 'Меню',
            xtype: 'app-menu-editor'
        }, {
            title: 'HTML',
            xtype: 'app-html-editor'
        }
    ]
});

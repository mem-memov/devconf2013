Ext.define('Admin.view.Viewport', {
    
    extend: 'Ext.container.Viewport',
    
    alias: 'widget.app-viewport',

    layout: {
        type: 'fit'
    },

    items: [{
        xtype: 'tabpanel',
        items: [
            {
                title: 'Меню'
            }, {
                title: 'HTML',
                xtype: 'app-html-editor'
            }
        ]
    }]
});

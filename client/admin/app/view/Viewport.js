Ext.define('Admin.view.Viewport', {
    
    extend: 'Ext.container.Viewport',
    
    alias: 'widget.app-viewport',

    layout: {
        type: 'fit'
    },

    items: [
        {
            id: 'menu-editor',
            xtype: 'app-menu-editor',
            hidden: false
        }, {
            id: 'html-editor',
            xtype: 'app-html-editor',
            hidden: true
        }
    ]
});

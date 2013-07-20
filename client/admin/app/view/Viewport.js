Ext.define('Admin.view.Viewport', {
    
    extend: 'Ext.container.Viewport',
    
    alias: 'widget.app-viewport',

    layout: {
        type: 'fit'
    },

    items: [
        {
            id: 'authentication',
            xtype: 'app-authentication',
            hidden: false
        }, {
            id: 'menu-editor',
            xtype: 'app-menu-editor',
            hidden: true
        }, {
            id: 'html-editor',
            xtype: 'app-html-editor',
            hidden: true
        }
    ]
});

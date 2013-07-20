Ext.define('Admin.controller.ViewportController', {
    
    extend: 'Ext.app.Controller',

    init: function() {
        
        this.listen({
            component: {
                'app-viewport': {
                    
                }
            },
            controller: {
                '*': {
                    'admin-authenticated': this.onAdminAuthenticated
                }
            }
        });
        
    },
    
    onAdminAuthenticated: function() {
        
        Ext.getCmp('menu-editor').show();
        
    }
    
});
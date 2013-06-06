Ext.define('school.controller.AuthenticationController', {
	
	extend: 'Ext.app.Controller',
	
	init: function() {
        
        this.listen({
            component: {
                'school-authentication': {
                    added: this.onAuthenticationAdded
                }
            }
        });
        
    },
    
    onAuthenticationAdded: function(authenticationWindow) {

        var record = this.getModel('school.model.AuthenticationModel').create();
        
        authenticationWindow.down('[componentCls=authentication-form]').loadRecord(record);
        
        authenticationWindow.down('[componentCls=professor-name-list]').getStore().load();
        
    }
	
});
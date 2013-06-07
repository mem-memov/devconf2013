Ext.define('school.controller.AuthenticationController', {
	
	extend: 'Ext.app.Controller',
	
	init: function() {
        
        this.listen({
            component: {
                'school-authentication': {
                    added: this.onAuthenticationAdded
                },
                'school-authentication [componentCls=submit-button]': {
                    click: this.onSubmitButtonClick
                }
            }
        });
        
    },
    
    onAuthenticationAdded: function(authenticationWindow) {

        authenticationWindow.down('[componentCls=professor-name-list]').getStore().load();
        
    },
    
    onSubmitButtonClick: function(submitButton) {

        var formPanel = submitButton.up('school-authentication').down('[componentCls=authentication-form]');
        var basicForm = formPanel.getForm();

        basicForm.submit({
            params: {}
        });
        
    }
	
});
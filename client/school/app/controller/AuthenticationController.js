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

        var authenticationWindow = submitButton.up('school-authentication');
        var formPanel = authenticationWindow.down('[componentCls=authentication-form]');
        var basicForm = formPanel.getForm();

        basicForm.submit({
            params: {},
            success: function(form, action) {
                authenticationWindow.close();
            },
            failure: function(form, action) {
                
            }
        });
        
    }
	
});
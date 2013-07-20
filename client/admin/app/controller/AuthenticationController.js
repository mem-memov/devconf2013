Ext.define('Admin.controller.AuthenticationController', {
	
	extend: 'Ext.app.Controller',
	
	init: function() {
        
        this.listen({
            component: {
                'app-authentication [itemId="submit-button"]': {
                    click: this.onSubmitButtonClick
                }
            }
        });
        
    },
    
    onSubmitButtonClick: function(submitButton) {

        var authenticationWindow = submitButton.up('app-authentication');
        var formPanel = authenticationWindow.down('[itemId="authentication-form"]');
        var basicForm = formPanel.getForm();
        var passwordField = formPanel.down('[itemId="password-field"]');

        if (!passwordField.getValue()) {
            Ext.Msg.alert('Ошибка', 'Назовите пароль');
            return;
        }

        basicForm.submit({
            params: {},
            success: function(form, action) {

                this.fireEvent('admin-authenticated');
                
                authenticationWindow.close();
                
            },
            failure: function(form, action) {
                
            },
            scope: this
        });
        
    }
	
});
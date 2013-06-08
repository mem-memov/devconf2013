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
        var professorField = formPanel.down('[componentCls=professor-name-list]');
        var passwordField = formPanel.down('[componentCls=password-field]');
        
        if (!professorField.getValue()) {
            Ext.Msg.alert('Ошибка', 'Назовите своё имя');
            return;
        }

        if (!passwordField.getValue()) {
            Ext.Msg.alert('Ошибка', 'Назовите пароль');
            return;
        }

        basicForm.submit({
            params: {},
            success: function(form, action) {

                var professorId = professorField.getValue();
               
                var professorRecord = professorField.findRecordByValue(professorId);
                
                this.fireEvent('professor-authenticated', professorRecord.getData());
                
                authenticationWindow.close();
                
            },
            failure: function(form, action) {
                
            },
            scope: this
        });
        
    }
	
});
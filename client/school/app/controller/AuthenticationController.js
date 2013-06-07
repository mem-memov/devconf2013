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

        //var record = this.getModel('school.model.AuthenticationModel').create();
        
        //authenticationWindow.down('[componentCls=authentication-form]').loadRecord(record);
        
        authenticationWindow.down('[componentCls=professor-name-list]').getStore().load();
        
    },
    
    onSubmitButtonClick: function(submitButton) {

        var formPanel = submitButton.up('school-authentication').down('[componentCls=authentication-form]');
        var basicForm = formPanel.getForm();
        //var record = formPanel.getRecord();
        //console.log(record);
        basicForm.submit({
            params: {
                    foo: 'bar',
                    uid: 34
//                id: record.get('id'),
//                password: record.get('password')
            }
        });
        
//        
//                basicForm.submit({
//                    success: function(form, action) {
//                       Ext.Msg.alert('Success', action.result.message);
//                    },
//                    failure: function(form, action) {
//                        Ext.Msg.alert('Failed', action.result ? action.result.message : 'No response');
//                    }
//                });
        
    }
	
});
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

        var record = this.getModel('school.model.AuthenticationModel').create();
        
        authenticationWindow.down('[componentCls=authentication-form]').loadRecord(record);
        
        authenticationWindow.down('[componentCls=professor-name-list]').getStore().load();
        
    },
    
    onSubmitButtonClick: function(submitButton) {

        var record = submitButton.up('school-authentication').down('[componentCls=authentication-form]').getRecord();
console.log(record);
        record.save();
        
    }
	
});
Ext.define('school.controller.ViewportController', {
	
	extend: 'Ext.app.Controller',
	
	init: function() {
        
        Ext.remote.TimeMachine.getCurrentDate({
            success: function(date) {
                this.fireEvent('date-defined', date);
            },
            scope: this
        });
        
    }
	
});

Ext.define('school.controller.ProfileController', {
    
	extend: 'Ext.app.Controller',
	
	init: function() {
        
        this.listen({
            controller: {
                '*': {
                    'student-selected': this.onStudentSelected
                }
            }
        });
        
    },
    
    onStudentSelected: function(student) {
        
        var studentCards = Ext.ComponentQuery.query('school-student-card');

        Ext.Array.each(studentCards, function(studentCard) {
            
            studentCard.update(student);
            
        });
        
    }
    
});
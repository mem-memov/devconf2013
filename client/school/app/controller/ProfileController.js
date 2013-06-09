Ext.define('school.controller.ProfileController', {
    
	extend: 'Ext.app.Controller',
    
    currentProfessor: null,
    currentStudent: null,
	
	init: function() {
        
        this.listen({
            controller: {
                '*': {
                    'professor-authenticated': this.onProfessorAuthenticated,
                    'student-selected': this.onStudentSelected,
                    'assessment-removed': this.onAssessmentChange,
                    'assessment-edited': this.onAssessmentChange
                }
            }
        });
        
    },
    
    onProfessorAuthenticated: function(professor) {
        
        this.currentProfessor = professor;
        
    },
    
    onStudentSelected: function(student) {
        
        this.currentStudent = student;
        
        var studentCards = Ext.ComponentQuery.query('school-student-card');

        Ext.Array.each(studentCards, function(studentCard) {

            studentCard.update(student);
            
        });
        
        this.updateActivityCharts();
        
    },
    
    onAssessmentChange: function() {
        
        this.updateActivityCharts();
        
    },
    
    
    updateActivityCharts: function() {
        
        var studentActivityCharts = Ext.ComponentQuery.query('school-student-activity-chart');

        Ext.Array.each(studentActivityCharts, function(studentActivityChart) {
            
            studentActivityChart.getStore().load({
                params: {
                    studentId: this.currentStudent.id
                }
            });
            
        }, this);
        
    }
    
    
    
});
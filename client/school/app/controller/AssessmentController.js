Ext.define('school.controller.AssessmentController', {
	
	extend: 'Ext.app.Controller',
	
	init: function() {
        
        this.listen({
            component: {
                'school-grade-list': {
                    added: this.onSchoolGradeListAdded
                },
                'school-student-list': {
                    added: this.onSchoolStudentListAdded
                }
            }
        });
        
    },
    
    onSchoolGradeListAdded: function(schoolGradeList) {
        
        schoolGradeList.getStore().load();
        
    },
    
    onSchoolStudentListAdded: function(schoolStudentList) {
        
        schoolStudentList.getStore().load();
        
    }
	
});
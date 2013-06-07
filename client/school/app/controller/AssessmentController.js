Ext.define('school.controller.AssessmentController', {
	
	extend: 'Ext.app.Controller',
	
	init: function() {
        
        this.listen({
            component: {
                'school-grade-list': {
                    added: this.onSchoolGradeListAdded
                },
                'school-student-list': {
                    added: this.onSchoolStudentListAdded,
                    itemclick: this.onStudentItemClick
                }
            }
        });
        
    },
    
    onSchoolGradeListAdded: function(schoolGradeList) {
        
        schoolGradeList.getStore().load();
        
    },
    
    onSchoolStudentListAdded: function(schoolStudentList) {
        
        schoolStudentList.getStore().load();
        
    },
    
    onStudentItemClick: function(schoolStudentList, record) {
        
        this.fireEvent('student-selected', record.getData());
        
    }
	
});
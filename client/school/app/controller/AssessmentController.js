Ext.define('school.controller.AssessmentController', {
	
	extend: 'Ext.app.Controller',
	
	init: function() {
        
        this.listen({
            component: {
                'school-grade-list': {
                    added: this.onSchoolGradeListAdded
                }
            }
        });
        
    },
    
    onSchoolGradeListAdded: function(schoolGradeList) {
        
        schoolGradeList.getStore().load();
        
    }
	
});
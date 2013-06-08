Ext.define('school.controller.AssessmentController', {
	
	extend: 'Ext.app.Controller',
    
    currentProfessor: null,
	
	init: function() {
        
        this.listen({
            component: {
                'school-student-list': {
                    itemclick: this.onStudentItemClick
                },
                'school-assessment-list': {
                    edit: this.onGradeListEdit,
                    'school-grade-selected': this.onGradeSelected
                },
                'school-assessment-list [componentCls=add-button]': {
                    click: this.onAddGradeButtonClick
                }
            },
            controller: {
                '*': {
                    'professor-authenticated': this.onProfessorAuthenticated
                }
            }
        });
        
    },
    
    onStudentItemClick: function(schoolStudentList, record) {
        
        this.fireEvent('student-selected', record.getData());
        
        var assessmentTool = Ext.ComponentQuery.query('school-assessment-tool')[0];
        var gradeList = assessmentTool.down('school-assessment-list');
        
        gradeList.getStore().load({
            params: {
                studentId: record.get('id'),
                subjectId: this.currentProfessor.subject_id
            }
        });
        
    },
    
    onProfessorAuthenticated: function(professor) {
        
        this.currentProfessor = professor;

        var assessmentTool = Ext.ComponentQuery.query('school-assessment-tool')[0];
        var studentList = assessmentTool.down('school-student-list');

        assessmentTool.show();
        
        studentList.getStore().load();

    },
    
    onAddGradeButtonClick: function(addGradeButton) {
        
        
        
    },
    
    onGradeSelected: function(assessmentList, assessmentRecord, gradeId) {

        assessmentRecord.set('grade_id', gradeId);
        
    },
    
    onGradeListEdit: function(editor, editEvent) {

        editEvent.grid.setLoading('Изменения сохраняются...');

        editEvent.store.sync({
            success: function() {
                
                editEvent.grid.setLoading(false);
                
            },
            scope: this
        });
        
    }
	
});
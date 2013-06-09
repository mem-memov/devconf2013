Ext.define('school.controller.AssessmentController', {
	
	extend: 'Ext.app.Controller',
    
    currentProfessor: null,
    currentStudent: null,
    currentDate: null,
	
	init: function() {
        
        this.listen({
            component: {
                'school-student-list': {
                    itemclick: this.onStudentItemClick
                },
                'school-assessment-list': {
                    edit: this.onAssessmentListEdit,
                    validateedit: this.onGradeListValidateReady,
                    canceledit: this.onAssessmnetListCancelEdit,
                    'school-grade-selected': this.onGradeSelected,
                    selectionchange: this.onAssessmentSelectionChange
                },
                'school-assessment-list [componentCls=add-button]': {
                    click: this.onAddAssessmnetButtonClick
                },
                'school-assessment-list [componentCls=remove-button]': {
                    click: this.onRemoveAssessmnetButtonClick
                }
            },
            controller: {
                '*': {
                    'professor-authenticated': this.onProfessorAuthenticated,
                    'date-defined': this.onDateDefined
                }
            }
        });
        
    },
    
    onDateDefined: function(date) {
        
        this.currentDate = date;
        
    },
    
    onStudentItemClick: function(schoolStudentList, record) {
        
        this.currentStudent = record.getData();
        
        this.fireEvent('student-selected', record.getData());
        
        var assessmentTool = Ext.ComponentQuery.query('school-assessment-tool')[0];
        var gradeList = assessmentTool.down('school-assessment-list');
        gradeList.show();
        
        gradeList.getStore().load({
            params: {
                studentId: record.get('id'),
                subjectId: this.currentProfessor.subject_id
            }
        });
        
        var studentProfile = assessmentTool.down('school-student-profile');
        studentProfile.show();
        
    },
    
    onProfessorAuthenticated: function(professor) {
        
        this.currentProfessor = professor;

        var assessmentTool = Ext.ComponentQuery.query('school-assessment-tool')[0];
        var studentList = assessmentTool.down('school-student-list');
        
        assessmentTool.setTitle(professor.subject);

        assessmentTool.show();
        
        studentList.getStore().load();

    },
    
    onAddAssessmnetButtonClick: function(addAssessmentButton) {
        
        var assessmentList = addAssessmentButton.up('school-assessment-list');
        var rowEditingPlugin = assessmentList.getPlugin('school-assessment-edit-plugin-id');
        var assessmentStore = assessmentList.getStore();
        var record = Ext.create('school.model.AssessmentModel', {
                date: this.currentDate,
                subject_id: this.currentProfessor.subject_id,
                student_id: this.currentStudent.id,
                teacher_id: this.currentProfessor.id
        });
        
        rowEditingPlugin.cancelEdit();

        assessmentStore.insert(0, record);

        rowEditingPlugin.startEdit(record, 1);
        
    },
    
    onRemoveAssessmnetButtonClick: function(removeAssessmentButton) {
        
        var assessmentList = removeAssessmentButton.up('school-assessment-list');
        var selectionModel = assessmentList.getSelectionModel();
        var rowEditingPlugin = assessmentList.getPlugin('school-assessment-edit-plugin-id');
        var assessmentStore = assessmentList.getStore();
        
        rowEditingPlugin.cancelEdit();
        assessmentStore.remove(selectionModel.getSelection());
        
        assessmentList.setLoading('Изменения сохраняются...');

        assessmentStore.sync({
            success: function() {
                
                assessmentList.setLoading(false);
                this.fireEvent('assessment-removed');
                
            },
            scope: this
        });
        
    },
    
    onGradeSelected: function(assessmentList, gradeCombobox, gradeRecord, assessmentRecord) {

        assessmentRecord.set('grade_id', gradeRecord.get('id'));
        gradeCombobox.setRawValue(gradeRecord.get('grade'));
        
    },
    
    onGradeListValidateReady: function(editor, editEvent) {
        
        if (!editEvent.record.get('grade_id')) {
            Ext.Msg.alert('Ошибка', 'Выберите оценку');
            return false;
        }
        
    },
    
    onAssessmentListEdit: function(editor, editEvent) {

        editEvent.grid.setLoading('Изменения сохраняются...');

        editEvent.store.sync({
            success: function() {
                
                editEvent.grid.setLoading(false);
                editEvent.store.sort();
                this.fireEvent('assessment-edited');
                
            },
            scope: this
        });
        
    },
    
    onAssessmnetListCancelEdit: function(editor, editEvent) {

        if (editEvent.record.get('id') === null) {
            editEvent.store.remove(editEvent.record);
        }

    },
    
    onAssessmentSelectionChange: function(selectionModel, selectedRecords) {
        
        var assessmentLists = Ext.ComponentQuery.query('school-assessment-tool school-assessment-list');
        
        Ext.Array.each(assessmentLists, function(assessmentList) {
            
            if (assessmentList.getSelectionModel() === selectionModel) {
                
                var destroyButton = assessmentList.down('[componentCls=remove-button]');

                if (selectedRecords.length > 0) {

                    destroyButton.enable();

                } else {

                    destroyButton.disable();

                }
                
            }
            
        });

    }
	
});
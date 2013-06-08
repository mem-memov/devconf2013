Ext.define('school.model.AssessmentModel', {
    
    extend: 'Ext.data.Model',
    
    idProperty: 'id',
    
    fields: [
        { name: 'id', type: 'int', useNull: true },
        { name: 'date', type: 'date' },
        { name: 'subject_id', type: 'int', useNull: true },
        { name: 'student_id', type: 'int', useNull: true },
        { name: 'teacher_id', type: 'int', useNull: true },
        { name: 'grade_id', type: 'int', useNull: true },
        { name: 'grade', type: 'string' }
    ]
    
});
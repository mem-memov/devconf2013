Ext.define('school.model.AssessmentModel', {
    
    extend: 'Ext.data.Model',
    
    idProperty: 'id',
    
    fields: [
        { name: 'id', type: 'int', useNull: true },
        { name: 'date', type: 'date' },
        { name: 'grade_id', type: 'int' },
        { name: 'grade', type: 'string' }
    ]
    
});
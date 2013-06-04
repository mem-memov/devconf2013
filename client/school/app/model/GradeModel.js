Ext.define('school.model.GradeModel', {
    
    extend: 'Ext.data.Model',
    
    idProperty: 'id',
    
    fields: [
        { name: 'id', type: 'int', useNull: true },
        { name: 'grade', type: 'string' },
        { name: 'passing', type: 'boolean' },
        { name: 'position', type: 'int', useNull: true }
    ]
    
});
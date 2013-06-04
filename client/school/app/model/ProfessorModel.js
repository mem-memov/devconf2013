Ext.define('school.model.ProfessorModel', {
    
    extend: 'Ext.data.Model',
    
    idProperty: 'id',
    
    fields: [
        { name: 'id', type: 'int', useNull: true },
        { name: 'first_name', type: 'string' },
        { name: 'last_name', type: 'string' }
    ]
    
});
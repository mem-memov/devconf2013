Ext.define('school.model.StudentModel', {
    
    extend: 'Ext.data.Model',
    
    idProperty: 'id',
    
    fields: [
        { name: 'id', type: 'int', useNull: true },
        { name: 'year', type: 'int', useNull: true },
        { name: 'house', type: 'string' },
        { name: 'first_name', type: 'string' },
        { name: 'last_name', type: 'string' }
    ]
    
});
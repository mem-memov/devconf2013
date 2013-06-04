Ext.define('school.model.AuthenticationModel', {
    
    extend: 'Ext.data.Model',
    
    idProperty: 'id',
    
    fields: [
        { name: 'id', type: 'int', useNull: true },
        { name: 'password', type: 'string' }
    ]
    
});


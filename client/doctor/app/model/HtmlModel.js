Ext.define('Doctor.model.HtmlModel', {
    
    extend: 'Ext.data.Model',
    
    idProperty: 'id',

    fields: [
        
        { name:'id', type: 'int', useNull: true }, 
        { name:'html', type: 'string' }
        
    ]

});
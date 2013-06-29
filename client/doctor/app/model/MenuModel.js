/**
 * Модель для элементов меню
 */
Ext.define('doctor.model.MenuModel', {
    
    extend: 'Ext.data.Model',
    
    idProperty: 'id',

    fields: [
        
        { name:'id', type: 'int', useNull: true }, 
        { name:'text', type: 'string' }, 
        { name:'linkId', type: 'int', useNull: true },
        { name:'linkType', type: 'string' },
        { name:'leaf', type: 'boolean', defaultValue: false }
        
    ]

});
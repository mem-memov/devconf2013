/**
 * Модель для элементов меню
 */
Ext.define('doctor.model.MenuModel', {
    
    extend: 'Ext.data.Model',
    
    idProperty: 'id',

    fields: [
        
        { name:'id', type: 'int', useNull: true }, 
        { name:'text', type: 'string' }, 
        { name:'link_id', type: 'int', useNull: true },
        { name:'link_type_id', type: 'int', useNull: true },
        { name:'link_type', type: 'string' },
        { name:'leaf', type: 'boolean', defaultValue: false }
        
    ]

});
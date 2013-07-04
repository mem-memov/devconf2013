/**
 * Модель для элементов меню
 */
Ext.define('Admin.model.MenuModel', {
    
    extend: 'Ext.data.TreeModel',
    
    idProperty: 'id',

    fields: [
        
        { name:'id', type: 'int', useNull: true }, 
        { name:'text', type: 'string' }, 
        { name:'link_id', type: 'int', useNull: true },
        { name:'link_type', type: 'string' },
        { name:'leaf', type: 'boolean', defaultValue: false }
        
    ]

});
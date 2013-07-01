Ext.define('Admin.view.menu.MenuEditor', {
    
    extend: 'Ext.tree.Panel',
    
    alias: 'widget.app-menu-editor',
    
    require: ['Ext.tree.plugin.TreeViewDragDrop'],

    border: false,
    hideHeaders: true,
    rootVisible: true,
    
    viewConfig: {
        markDirty: false,
//        plugins: [{
//            ptype: 'treeviewdragdrop',
//            containerScroll: true
//        }],
        animate: false
    },
    
//    plugins: [{
//        ptype: 'cellediting',
//        pluginId: 'menuEditorCellEditingPlugin'
//    }],

    selType: 'cellmodel',

    columns: [{
        header: 'Пункт меню',  
        dataIndex: 'text', 
        cls: 'theTreeColumn',
        xtype: 'treecolumn', // этот столбец отображаем в виде дерева
        editor: {
            xtype: 'textfield',
            allowBlank: false
        },
        flex: 1
    }, {
        xtype:'actioncolumn',
        itemId: 'menuManagerTreeLinkColumn',
        width: 50,
        items: [{
            icon: 'resources/images/icons/magnifying_glass.png',
            isDisabled: function(view, rowIndex, colIndex, item, record) {
                return !record.get('leaf');
            }
        }]
    }],

    dockedItems: [{
        xtype: 'toolbar',
        items: [{
            text: 'Развернуть все',
            cls: 'menuManagerTreeExpandAllButton'
        }, {
            text: 'Свернуть все',
            cls: 'menuManagerTreeCollapseAllButton'
        }]
    }],

    
    initComponent: function() {
        
        this.store = Ext.create('Admin.store.MenuStore'); // store указан в документации как обязательный параметр, тип этого параметра не допускает передачу конфигурационного объекта (ленивое создание экземпляра невозможно, это находится в противоречии с рекомендациями по написанию кода для более эффективной компиляции при помощи Sencha Cmd)
        
        this.callParent();
        
    }
    
});
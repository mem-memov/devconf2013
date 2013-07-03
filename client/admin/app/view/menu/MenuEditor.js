Ext.define('Admin.view.menu.MenuEditor', {
    
    extend: 'Ext.tree.Panel',
    
    alias: 'widget.app-menu-editor',
    
    require: ['Ext.tree.plugin.TreeViewDragDrop', 'Ext.grid.plugin.CellEditing'],

    border: false,
    hideHeaders: true,
    rootVisible: true,
    
    viewConfig: {
        plugins: [{
            ptype: 'treeviewdragdrop', // во время разработки необходимо подключать класс ext-all-dev.js, иначе возникает ошибка "config is null" в PluginManager
            containerScroll: true
        }]
    },
    
    plugins: [{
        ptype: 'cellediting', // во время разработки необходимо подключать класс ext-all-dev.js, иначе возникает ошибка "config is null" в PluginManager
        pluginId: 'menuEditorCellEditingPlugin'
    }],

    selModel: {
        selection: 'treemodel',
        mode: 'MULTI'
    },

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
            itemId: 'expand-all-button'
        }, {
            text: 'Свернуть все',
            itemId: 'collapse-all-button'
        }, {
            xtype: 'app-menu-context-menu',
            floating: true,
            hidden: true
        }]
    }],

    items: [
        {
            xtype: 'app-context-menu-for-folder',
            floating: false
        }, {
            xtype: 'app-context-menu-for-reference'
        }, {
            xtype: 'app-context-menu-for-top-folder'
        }
    ],
    
    initComponent: function() {
        
        this.store = Ext.create('Admin.store.MenuStore'); // store указан в документации как обязательный параметр, тип этого параметра не допускает передачу конфигурационного объекта (ленивое создание экземпляра невозможно, это находится в противоречии с рекомендациями по написанию кода для более эффективной компиляции при помощи Sencha Cmd)

        this.callParent();
        
    }
    
});
Ext.define('Admin.view.MenuEditor', {
    
    extend: 'Ext.tree.Panel',
    
    alias: 'widget.app-menu-editor',
    

    border: false,
    hideHeaders: true,

    viewConfig: {
        markDirty: false,
        plugins: [{
            ptype: 'treeviewdragdrop',
            containerScroll: true
        }],
        animate: true
    },
    
    plugins: [{
        ptype: 'cellediting',
        pluginId: 'menuEditorCellEditingPlugin'
    }],

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
            icon: 'client_admin/icons/magnifying_glass.png',
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

    store: {
        type: 'app-menu-store',
        autoLoad: true
    }
    
});
Ext.define('Admin.controller.MenuController', {
    
    extend: 'Ext.app.Controller',

    init: function() {
        
        this.listen({
            component: {
                'app-menu-editor [itemId="expand-all-button"]': {
                    click: this.onExpandAllButtonClick
                },
                'app-menu-editor [itemId="collapse-all-button"]': {
                    click: this.onCollapseAllButtonClick
                },
                'app-menu-editor > treeview': {
                    drop: this.onDrop
                },
                'app-menu-editor': {
                    itemcontextmenu: this.onItemContextMenu,
                    selectionchange: this.onSelectionChange,
                    render: this.onRender
                },
                'app-menu-editor app-menu-context-menu': {
                    click: this.onContextMenuClick
                }
            }
        });
/*

        this.control({
            '#menuManagerTree': {
                beforeitemcontextmenu: this.beforeContextMenu,
                beforeedit: this.beforeTreeEdit,
                validateedit: this.onTreeEditValidation,
                edit: this.onTreeEdit
            },
            '#menuManagerContextMenuForFolder': {
                click: this.onContextMenuClick
            },
            '#menuManagerContextMenuForTopFolder': {
                click: this.onContextMenuClick
            },
            '#menuManagerContextMenuForReference': {
                click: this.onContextMenuClick
            },
            '#menuManagerTreeDashboardCombobox': {
                added: this.dashboardComboboxAdded
            },
            '#menuManagerTreeLinkColumn': {
                click: this.onLinkColumnClick
            }
        });
        
        this.application.on({
            dashboardListChanged: this.refreshDashboardList,
            dashboardRemoved: this.refreshDashboardList,
            scope: this
        });
*/        
    },
    
    onRender: function(menuEditor) {
        
        //menuEditor.getStore().getRootNode().expand();
        
    },
    
    onExpandAllButtonClick: function(expandAllButton) {
        
        var menuEditor = expandAllButton.up('app-menu-editor');
        var toolbar = expandAllButton.up('toolbar');
        
        toolbar.disable();

        menuEditor.getEl().mask('Развёртывание меню...');

        menuEditor.expandAll(function() {
            menuEditor.getEl().unmask();
            toolbar.enable();
        });
        
    },
    
    onCollapseAllButtonClick: function(collapseAllButton) {
        
        var menuEditor = collapseAllButton.up('app-menu-editor');
        var toolbar = collapseAllButton.up('toolbar');
        
        toolbar.disable();

        menuEditor.collapseAll(function() {
            toolbar.enable();
        });
        
    },
    
    onDrop: function(node, data, overModel, dropPosition, dropHandler) {
        
        var targetId = overModel.get('id');
        
        var movedIds = [];
        Ext.Array.each(data.records, function(record) {
            movedIds.push(record.get('id'));
        });

        Ext.remote.Menu.updatePositions(
            targetId,
            movedIds,
            dropPosition
        );
        
    },
    
    onSelectionChange: function(selectionModel, selectedRecords) {
        
        this.currentSelectionModel = selectionModel;
        
    },
    
    onItemContextMenu: function(treeview, record, item, index, e) {

        e.stopEvent();

        var menuEditor = treeview.up('app-menu-editor');
        var contextMenu = menuEditor.down('app-menu-context-menu');
        var renameButton = contextMenu.down('[itemId="rename-button"]');
        var deleteButton = contextMenu.down('[itemId="delete-button"]');
        var createFolderButton = contextMenu.down('[itemId="create-folder-button"]');
        var createReferenceButton = contextMenu.down('[itemId="create-reference-button"]');

        if (record.get('leaf')) {
            
            renameButton.show();
            deleteButton.show();
            createFolderButton.hide();
            createReferenceButton.hide();
            
        } else {
            
            if (record.get('id') == 0) {
                
                renameButton.hide();
                deleteButton.hide();
                createFolderButton.show();
                createReferenceButton.show();
                
            } else {
                
                renameButton.show();
                deleteButton.show();
                createFolderButton.show();
                createReferenceButton.show();
                
            }
            
        }

        contextMenu.showAt(e.getXY());
        
    },

    onContextMenuClick: function(menu, item, e) {
        
        var menuEditor = Ext.ComponentQuery.query('app-menu-editor{isVisible()}')[0];
        
        var selectionModel = menuEditor.getSelectionModel();
        
        if (!selectionModel.hasSelection()) {
            return;
        }
        
        var selectedNodes = selectionModel.getSelection();
        var selectedNode = selectedNodes[0];
        selectionModel.deselectAll();

        if (item.is('[itemId="rename-button"]') && !selectedNode.isRoot()) {

            menuEditor.getPlugin('menuEditorCellEditingPlugin').startEdit(selectedNode, 0);

        } else if (item.is('[itemId="delete-button"]') && !selectedNode.isRoot()) {

            selectionModel.select(selectedNode);
            var message = 'Удалить "' + selectedNode.get('text') + '"?';
            Ext.MessageBox.confirm('Запрос подтверждения', message, function(buttonId) {
                if (buttonId === 'yes') {
                    selectedNode.remove();
                }
            });

        } else if (item.is('[itemId="create-folder-button"]') && !selectedNode.isLeaf()) {

            this.mon(menuEditor.getView(), 'afteritemexpand', function(node, index, item, eOpts) {
                var newNode = selectedNode.appendChild({
                    id: null,
                    text: '',
                    leaf: false,
                    loaded: true
                });
                menuEditor.getPlugin('menuEditorCellEditingPlugin').startEdit(newNode, 0);
            }, this, {single: true});
            selectedNode.expand();
            
            
        } else if (item.is('[itemId="create-reference-button"]') && !selectedNode.isLeaf()) {

            this.mon(menuEditor.getView(), 'afteritemexpand', function(node, index, item, eOpts) {
                var newNode = selectedNode.appendChild({
                    id: null,
                    text: '',
                    leaf: true,
                    loaded: true
                });
                menuEditor.getPlugin('menuEditorCellEditingPlugin').startEdit(newNode, 0);
            }, this, {single: true});
            selectedNode.expand();

        }

    },
    
    
    
    
    
    

    
    refreshDashboardList: function() {

        var dashboardCombobox = Ext.ComponentQuery.query('#menuManagerTreeDashboardCombobox')[0];
        
        if (dashboardCombobox) {
            var store = dashboardCombobox.getStore();
            store.reload({
                scope: this,
                callback: function(records, operation, success) {
                    this.insertEmptyRecordIntoDashboardStore(store);
                }
            });
        }

    },
    
    insertEmptyRecordIntoDashboardStore: function(store) {
        
        var emptyText = '-- не назначен --';
        
        if (store.query('name', emptyText).getCount() == 0) {
            
            store.insert(0, [{'id': null, 'name': emptyText}]);
            
        }
        
    },
    
    beforeTreeEdit: function(editor, editEvent) {
        
        // запрещаем назначать дэшборды папкам
        if (!editEvent.record.get('leaf') && editEvent.field == 'link_id') {
            editEvent.cancel = true;
            return false;
        }
        
    },
    
    onTreeEditValidation: function(editor, editEvent) {
        

        
    },
    
    onTreeEdit: function(editor, editEvent) {

        if (editEvent.record.get('leaf') && editEvent.field == 'link_id') {

            if (editEvent.value === null) {
                
                // удаление дэшборда из пункта меню
                editEvent.record.set('link_title', '');
                
            } else {
                
                // назначение дэшборда
                
                var combobox = Ext.ComponentQuery.query('#menuManagerTreeDashboardCombobox')[0];
                var record = combobox.findRecordByValue(editEvent.value);

                editEvent.record.set('link_title', record.get('name'));
                
            }

        }
        
    },
    
    onLinkColumnClick: function(treeView, cellElement, num1, num2, clickEvent, menuRecord, rowElement, menuManagerTree) {
        
        if (!menuRecord.get('leaf')) {
            return false;
        }
        
        this.application.fireEvent('menuLinkClick', {
            
            id: menuRecord.get('link_id'),
            type: menuRecord.get('link_type')
            
        });
        
    }
    
    
});
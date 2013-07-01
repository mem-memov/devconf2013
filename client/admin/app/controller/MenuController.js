Ext.define('Admin.controller.MenuController', {
    
    extend: 'Ext.app.Controller',
    
    /**
     * порядковый номер строки на экране (а не в дереве)
     * null|int
     */ 
    selectedRowIndex: null,

    init: function() {
        
        this.listen({
            component: {
                'app-menu-editor': {
                    
                }
            }
        });

        this.control({
            '#menuManagerTree > treeview': {
                drop: this.onDrop
            },
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
            '#menuManagerTree [cls~=menuManagerTreeExpandAllButton]': {
                click: this.onExpandAllButtonClick
            },
            '#menuManagerTree [cls~=menuManagerTreeCollapseAllButton]': {
                click: this.onCollapseAllButtonClick
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
        
    },
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    onExpandAllButtonClick: function(expandAllButton) {
        
        var menuManagerTree = Ext.ComponentQuery.query('#menuManagerTree')[0];
        
        menuManagerTree.getEl().mask('Развёртывание меню...');
        var toolbar = expandAllButton.up('toolbar');
        toolbar.disable();

        menuManagerTree.expandAll(function() {
            menuManagerTree.getEl().unmask();
            toolbar.enable();
        });
        
    },
    
    onCollapseAllButtonClick: function(collapseAllButton) {
        
        var menuManagerTree = Ext.ComponentQuery.query('#menuManagerTree')[0];
        
        var toolbar = collapseAllButton.up('toolbar');
        toolbar.disable();

        menuManagerTree.collapseAll(function() {
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
    
    beforeContextMenu: function(tree, record, item, index, e) {

        e.stopEvent();

        if (record.get('leaf')) {
            
            var contextMenu = Ext.ComponentQuery.query('#menuManagerContextMenuForReference')[0];
            
        } else {
            
            if (record.get('id') == 0) {
                var contextMenu = Ext.ComponentQuery.query('#menuManagerContextMenuForTopFolder')[0];
            } else {
                var contextMenu = Ext.ComponentQuery.query('#menuManagerContextMenuForFolder')[0];
            }
            
        }

        contextMenu.showAt(e.getXY());
        
        this.selectedRowIndex = index;
        
    },
    
    onContextMenuClick: function(menu, item, e) {
       
        if (item.hasCls('menu-manager-context-menu-create-folder-button')) {
           
            this.addMenuItem(false, 'Новый раздел меню');

        }
        
        if (item.hasCls('menu-manager-context-menu-create-reference-button')) {
            
            this.addMenuItem(true, 'Новый пункт меню');

        }
        
        if (item.hasCls('menu-manager-context-menu-rename-button')) {

            var menuManagerTree = Ext.ComponentQuery.query('#menuManagerTree')[0];
            var selectionModel = menuManagerTree.getSelectionModel();
            
            if (selectionModel.hasSelection()) {
                var selectedNode = selectionModel.getSelection()[0];
                this.openEditor(menuManagerTree, selectedNode);
            }
            
        }
        
        if (item.hasCls('menu-manager-context-menu-delete-button')) {

            var menuManagerTree = Ext.ComponentQuery.query('#menuManagerTree')[0];
            var selectionModel = menuManagerTree.getSelectionModel();
            
            if (selectionModel.hasSelection()) {

                var selectedNode = selectionModel.getSelection()[0];
                var message = 'Удалить "' + selectedNode.get('text') + '"?';
                
                Ext.MessageBox.confirm('Запрос подтверждения', message, function(buttonId) {
                    if (buttonId === 'yes') {
                        selectedNode.remove();
                    }
                });
                
            }
            
        }

    },
    
    addMenuItem: function(isLeaf, defaultText) {
        
        var menuManagerTree = Ext.ComponentQuery.query('#menuManagerTree')[0];
        var selectionModel = menuManagerTree.getSelectionModel();

        if (!selectionModel.hasSelection()) {
            return;
        }
        
        var selectedNode = selectionModel.getSelection()[0];

        if (selectedNode.get('leaf')) {
            return;
        }

        if (selectedNode.isExpanded()) {

            this.appendNewMenuItem(selectedNode, isLeaf, defaultText);

            this.openEditor(menuManagerTree, selectedNode);

        } else {

            this.openEditorAfterNodeExpand(menuManagerTree, selectedNode);

            selectedNode.expand(false, function() {

                this.appendNewMenuItem(selectedNode, isLeaf, defaultText);

            }, this);

        }
        
    },
    
    appendNewMenuItem: function(parentNode, isLeaf, text) {
        
        return parentNode.appendChild({
            id: null,
            text: text,
            leaf: isLeaf,
            loaded: true
        });
                
    },
    
    openEditorAfterNodeExpand: function(menuManagerTree, selectedNode) {
        
        menuManagerTree.getView().on(
            'afteritemexpand',
            function() {

                this.openEditor(menuManagerTree, selectedNode);

            },
            this,
            {
                single: true
            }
        );
        
    },
    
    openEditor: function(menuManagerTree, selectedNode) {
      
        if (this.selectedRowIndex === null) {
            return;
        }
        
        var cellEditingPlugin = menuManagerTree.getPlugin('menuManagerTreeCellEditingPlugin');

        cellEditingPlugin.startEditByPosition({
            row: this.selectedRowIndex + selectedNode.indexOf(selectedNode.lastChild)+1,
            column: 0
        });
        
        this.selectedRowIndex = null;
        
    },
    
    dashboardComboboxAdded: function(dashboardCombobox) {

        var store = dashboardCombobox.getStore();
        
        store.load();

        this.insertEmptyRecordIntoDashboardStore(store);
        
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
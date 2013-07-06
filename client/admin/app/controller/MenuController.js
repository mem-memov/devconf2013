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
                    selectionchange: this.onSelectionChange
                },
                'app-menu-editor app-menu-context-menu [itemId="rename-button"]': {
                    click: this.onRenameButtonClick
                },
                'app-menu-editor app-menu-context-menu [itemId="delete-button"]': {
                    click: this.onDeleteButtonClick
                },
                'app-menu-editor app-menu-context-menu [itemId="create-folder-button"]': {
                    click: this.onCreateFolderButtonClick
                },
                'app-menu-editor app-menu-context-menu [itemId="create-html-button"]': {
                    click: this.onCreateReferenceButtonClick
                }
            }
        });
   
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
        var createReferenceButton = contextMenu.down('[itemId="create-reference-button-list"]');

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
    
    onRenameButtonClick: function(button, event) {
        
        var menuEditor = this.getActiveMenuEditor();
        
        var selectionModel = menuEditor.getSelectionModel();
        
        if (!selectionModel.hasSelection()) {
            return;
        }
        
        var selectedNodes = selectionModel.getSelection();
        var selectedNode = selectedNodes[0];
        selectionModel.deselectAll();
        
        menuEditor.getPlugin('menuEditorCellEditingPlugin').startEdit(selectedNode, 0);

    },
    
    onDeleteButtonClick: function(button, event) {
        
        var menuEditor = this.getActiveMenuEditor();
        
        var selectionModel = menuEditor.getSelectionModel();
        
        if (!selectionModel.hasSelection()) {
            return;
        }
        
        var selectedNodes = selectionModel.getSelection();
        var selectedNode = selectedNodes[0];
        selectionModel.deselectAll();
        
        selectionModel.select(selectedNode);
        var message = 'Удалить "' + selectedNode.get('text') + '"?';
        Ext.MessageBox.confirm('Запрос подтверждения', message, function(buttonId) {
            if (buttonId === 'yes') {
                selectionModel.deselect(selectedNode);
                selectedNode.remove();
            }
        });
        
    },
    
    onCreateFolderButtonClick: function(button, event) {
        
        var menuEditor = this.getActiveMenuEditor();
        
        var selectionModel = menuEditor.getSelectionModel();
        
        if (!selectionModel.hasSelection()) {
            return;
        }
        
        var selectedNodes = selectionModel.getSelection();
        var selectedNode = selectedNodes[0];
        selectionModel.deselectAll();
        
        var createBranch = (function(menuEditor, selectedNode) { 
            return function() {
                var newNode = selectedNode.appendChild({
                    id: null,
                    text: '',
                    leaf: false
                });
                menuEditor.getPlugin('menuEditorCellEditingPlugin').startEdit(newNode, 0);
            }
        })(menuEditor, selectedNode);

        if (selectedNode.isExpanded()) {

            createBranch();

        } else {

            this.mon(menuEditor.getView(), 'afteritemexpand', function(node, index, item, eOpts) {
                createBranch();
            }, this, {single: true});
            selectedNode.expand();

        }
        
    },
    
    onCreateReferenceButtonClick: function(button, event) {
        
        var menuEditor = this.getActiveMenuEditor();
        
        var selectionModel = menuEditor.getSelectionModel();
        
        if (!selectionModel.hasSelection()) {
            return;
        }
        
        var selectedNodes = selectionModel.getSelection();
        var selectedNode = selectedNodes[0];
        selectionModel.deselectAll();
        
        var linkType;
        switch (button.getItemId()) {
            case 'create-html-button':
                linkType = 'html';
                break;
            default:
                Ext.Error.raise('Неизвестный тип кнопки меню');
                break;
        }
        
        var createLeaf = (function(menuEditor, selectedNode) { 
            return function() {
                var newNode = selectedNode.appendChild({
                    id: null,
                    text: '',
                    leaf: true,
                    link_type: linkType
                });
                menuEditor.getPlugin('menuEditorCellEditingPlugin').startEdit(newNode, 0);
            }
        })(menuEditor, selectedNode);

        if (selectedNode.isExpanded()) {

            createLeaf();

        } else {

            this.mon(menuEditor.getView(), 'afteritemexpand', function(node, index, item, eOpts) {
                createLeaf();
            }, this, {single: true});
            selectedNode.expand();

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
        
    },
    
    getActiveMenuEditor: function() {
        
        var menuEditor = Ext.ComponentQuery.query('app-menu-editor{isVisible()}')[0];
        
        if (!menuEditor) {
            Ext.error.raise('Не обнаружен активный редактор меню');
        }
        
        return menuEditor;
        
    }
    
    
});
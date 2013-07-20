Ext.define('Admin.controller.HtmlEditorController', {
    
    extend: 'Ext.app.Controller',

    init: function() {
        
        this.listen({
            component: {
                'app-html-editor': {
                    dirtychange: this.onDirtyChange
                },
                'app-html-editor [itemId="html-editor-field"]': {
                    render: this.listenToKeyEvents
                },
                'app-html-editor [itemId="menu-button"]': {
                    click: this.onMenuButtonClick
                },
                'app-html-editor [itemId="save-button"]': {
                    click: this.onSaveButtonClick
                },
                'app-html-editor [itemId="cancel-button"]': {
                    click: this.onCancelButtonClick
                }
            },
            controller: {
                '*': {
                    'menu-link-click': this.onMenuLinkClick
                }
            }
        });
        
    },
    
    listenToKeyEvents: function(htmlEditorField) {
        
        htmlEditorField.getEl().down('textarea').on('keyup', function() {
            
            htmlEditorField.checkDirty();
            
        });
        
    },
    
    onMenuLinkClick: function(linkId, linkType, text) {

        if (linkType != 'html') {
            return;
        }
        
        this.getModel('Admin.model.HtmlModel').load(linkId, {
            
            success: function(record, operation) {
                
                var editor = Ext.getCmp('html-editor');
                editor.down('[itemId="document-title"]').setText(text);
                editor.loadRecord(record);
                editor.show();

                this.fireEvent('editor-active');
                
            },
            scope: this
            
        });

    },
    
    onMenuButtonClick: function(button) {

        var editor = button.up('app-html-editor');
        
        if (!editor.isDirty()) {
            editor.hide();
            this.fireEvent('editor-not-active');
            return;
        }
        
        Ext.Msg.alert('Внимание', 'Не сохранены изменения');

    },
    
    onDirtyChange: function(basicForm, isDirty) {

        var formPanel = basicForm.owner;
        
        var menuButton = formPanel.down('[itemId="menu-button"]');
        var saveButton = formPanel.down('[itemId="save-button"]');
        var cancelButton = formPanel.down('[itemId="cancel-button"]');
        
        if (isDirty) {
            
            menuButton.disable();
            saveButton.enable();
            cancelButton.enable();
            
        } else {
            
            menuButton.enable();
            saveButton.disable();
            cancelButton.disable();
            
        }
        
    },
    
    onSaveButtonClick: function(button) {
        
        var formPanel = button.up('app-html-editor');
        var record = formPanel.getRecord();
        var values = formPanel.getValues();
        
        record.set(values); // изменяем значения записи, чтобы сработал метод save()
        
        record.save({
            success: function(record, operation) {
                formPanel.loadRecord(record); // загружаем запись в форму повторно, чтобы форма перестала быть dirty
            }
        });
        
    },
    
    onCancelButtonClick: function(button) {
        
        var formPanel = button.up('app-html-editor');
        formPanel.getForm().reset();

        formPanel.loadRecord(formPanel.getRecord()); // загружаем запись в форму повторно, чтобы правильно выставлялся пизнак dirty
        
    }
    
});
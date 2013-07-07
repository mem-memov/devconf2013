Ext.define('Admin.controller.HtmlEditorController', {
    
    extend: 'Ext.app.Controller',

    init: function() {
        
        this.listen({
            component: {
                'app-html-editor [itemId="menu-button"]': {
                    click: this.onMenuButtonClick
                }
            },
            controller: {
                '*': {
                    'menu-link-click': this.onMenuLinkClick
                }
            }
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
    
    onMenuButtonClick: function() {
        
        Ext.getCmp('html-editor').hide();
        
        this.fireEvent('editor-not-active');
        
    }
    
});
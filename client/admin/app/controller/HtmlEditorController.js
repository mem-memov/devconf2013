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
        
        var editor = Ext.getCmp('html-editor');
        editor.down('[itemId="document-title"]').setText(text);
        editor.show();
        
        this.fireEvent('editor-active');

    },
    
    onMenuButtonClick: function() {
        
        Ext.getCmp('html-editor').hide();
        
        this.fireEvent('editor-not-active');
        
    }
    
});
Ext.define('Admin.view.HtmlEditor', {
    
    extend: 'Ext.form.Panel',
    
    alias: 'widget.app-html-editor',
    
    maskOnDisable: true,
    disabled: false,
    
    trackResetOnLoad: true, // позволяет следить за изменениями в полях формы через событие dirtychange
    
    layout: 'fit',
    
    items: [
        {
            xtype: 'htmleditor',
            enableKeyEvents: true,
            name: 'html'
        }
    ],
    
    tbar: [
        {
            xtype: 'button',
            itemId: 'menu-button',
            text: 'В меню',
            icon: 'resources/images/icons/arrow_left.png',
            disabled: false
        }, {
            xtype: 'tbtext',
            itemId: 'document-title',
            style: {
                fontWeight: 'bold'
            },
            text: 'HTML-документ'
        }, '->', {
            xtype: 'button',
            itemId: 'save-button',
            text: 'Сохранить',
            icon: 'resources/images/icons/save.png',
            disabled: true
        }, {
            xtype: 'button',
            itemId: 'cancel-button',
            text: 'Отменить',
            icon: 'resources/images/icons/cancel.png',
            disabled: true
        }
    ]
    
});
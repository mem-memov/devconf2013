Ext.define('doctor.view.Viewport', {
    
    extend: 'Ext.container.Viewport',
    
    alias: 'widget.app-viewport',

    layout: {
        type: 'hbox',
        align: 'stretch'
    },

    items: [{
        //xtype: 'app-menu',
        title: 'Меню',
        componentCls: 'left-part',
        width: 150, 
        hidden: true // скрываем, чтобы показать с анимацией

    },{
        border: 10,
        componentCls: 'right-part',
        title: '1111',
        flex: 1
    }]

});

Ext.define('doctor.view.Menu', {
    
    extend: 'Ext.panel.Panel',
    
    alias: 'widget.app-menu',

    layout: {
        type: 'accordion',
        titleCollapse: false,
        animate: true,
        activeOnTop: false
    },

    items: [{
        title: 'Panel 1',
        html: 'Panel content!'
    },{
        title: 'Panel 2',
        html: 'Panel content!'
    },{
        title: 'Panel 3',
        html: 'Panel content!'
    }]

});
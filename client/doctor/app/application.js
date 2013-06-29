Ext.define('doctor.Application', {
    name: 'doctor',

    extend: 'Ext.app.Application',

    views: [
        'doctor.view.Viewport',
        'doctor.view.Menu',
        'doctor.view.HtmlPanel'
    ],

    controllers: [
        'doctor.controller.ViewportController',
        'doctor.controller.MenuController',
        'doctor.controller.HtmlPanelController'
    ],

    stores: [
        'doctor.store.MenuStore',
        'doctor.store.HtmlStore'
    ],
    
    models: [
        'doctor.model.MenuModel',
        'doctor.model.HtmlModel'
    ]
    
});

Ext.define('doctor.Application', {
    name: 'doctor',

    extend: 'Ext.app.Application',

    views: [
        'doctor.view.Viewport',
        'doctor.view.Menu'
    ],

    controllers: [
        'doctor.controller.ViewportController',
        'doctor.controller.MenuController'
    ],

    stores: [
        'doctor.store.MenuStore'
    ],
    
    models: [
        'doctor.model.MenuModel'
    ]
    
});

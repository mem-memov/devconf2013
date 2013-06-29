Ext.define('doctor.Application', {
    name: 'doctor',

    extend: 'Ext.app.Application',
    
    requires: [
        'Ext.direct.*' // эти классы должны быть загружены до запуска конструктора
    ],
    
    autoCreateViewport: true,
    
    constructor: function(config) {
        
        config = config || {};

        // Даём возможность вызывать методы серверной части приложения
        // Выполняется в конструкторе, т.к. он запускается до создания каких-либо хранилищ, моделей и контроллеров
        // В противном случае вызов удалённых процедур будет невозможен.
        // Работает как в режиме динамической загрузки, так и после компиляции в Sencha Cmd
        (function applyMultipleNamespacesOfRemoteApi (apiNamespace){

            Ext.Object.each(apiNamespace, function(key, value, object) {

                if (key == 'REMOTING_API') {
                    Ext.direct.Manager.addProvider(value);
                } else {
                    applyMultipleNamespacesOfRemoteApi(value); // recursive call
                }


            });

        })(Ext.remote);


        this.callParent([config]);

    },

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

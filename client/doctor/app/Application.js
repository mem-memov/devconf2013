Ext.define('Doctor.Application', {
    name: 'Doctor',

    extend: 'Ext.app.Application',

    autoCreateViewport: true,
    
    requires: [
        'Ext.direct.*' // эти классы должны быть загружены до запуска конструктора
    ],
    
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
        'Doctor.view.Viewport',
        'Doctor.view.Menu',
        'Doctor.view.HtmlPanel'
    ],

    controllers: [
        'Doctor.controller.ViewportController',
        'Doctor.controller.MenuController',
        'Doctor.controller.HtmlPanelController'
    ],

    stores: [
        'Doctor.store.MenuStore',
        'Doctor.store.HtmlStore'
    ],
    
    models: [
        'Doctor.model.MenuModel',
        'Doctor.model.HtmlModel'
    ]
    
});

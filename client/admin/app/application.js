Ext.define('Admin.Application', {
    name: 'Admin',

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
        'Admin.view.HtmlEditor',
        'Admin.view.menu.MenuEditor',
        'Admin.view.menu.ContextMenu',
        'Admin.view.Viewport'
    ],

    controllers: [
        'Admin.controller.ViewportController',
        'Admin.controller.MenuController',
        'Admin.controller.HtmlEditorController'
    ],
    
    models: [
        'Admin.model.HtmlModel',
        'Admin.model.MenuModel'
    ],

    stores: [
        'Admin.store.HtmlStore',
        'Admin.store.MenuStore'
    ]
});

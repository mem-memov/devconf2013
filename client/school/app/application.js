Ext.define('school.Application', {
    
    name: 'school',

    extend: 'Ext.app.Application',
    
    requires: ['Ext.direct.*'], // эти классы должны быть загружены до запуска конструктора
    
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
        'school.view.Viewport',
        'school.view.Authentication',
        'school.view.assessment.StudentList',
        'school.view.assessment.AssessmentTool',
        'school.view.assessment.GradeList'
    ],

    controllers: [
		'school.controller.ViewportController',
        'school.controller.AssessmentController',
        'school.controller.AuthenticationController'
    ],
    
    models: [
        'school.model.ProfessorModel',
        'school.model.GradeModel'
    ],

    stores: [
        'school.store.ProfessorStore',
        'school.store.StudentStore',
        'school.store.GradeStore'
    ]
    
});

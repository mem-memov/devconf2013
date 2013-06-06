Ext.define('school.Application', {
    
    name: 'school',

    extend: 'Ext.app.Application',
    
    autoCreateViewport: true,
    
    requires: ['Ext.direct.*'],
    
    launch: function() {
        
        // Даём возможность вызывать методы серверной части приложения
        (function applyMultipleNamespacesOfRemoteApi (apiNamespace){

            Ext.Object.each(apiNamespace, function(key, value, object) {

                if (key == 'REMOTING_API') {
                    Ext.direct.Manager.addProvider(value);
                } else {
                    applyMultipleNamespacesOfRemoteApi(value); // recursive call
                }


            });

        })(Ext.remote);
        
        Ext.remote.Grade.readAll();
        
    },

    views: [
        'school.view.Viewport',
        'school.view.Authentication',
        'school.view.assessment.StudentList',
        'school.view.assessment.AssessmentTool',
        'school.view.assessment.GradeList'
    ],

    controllers: [
		'school.controller.ViewportController'
    ],
    
    models: [
        'school.model.ProfessorModel',
        'school.model.AuthenticationModel',
        'school.model.GradeModel'
    ],

    stores: [
        'school.store.ProfessorStore',
        'school.store.StudentStore',
        'school.store.GradeStore'
    ]
    
});

Ext.define('school.Application', {
    
    name: 'school',

    extend: 'Ext.app.Application',
    
    autoCreateViewport: true,

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

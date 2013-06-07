Ext.define('school.store.StudentActivityStore', {
    
    extend: 'Ext.data.Store',
    
    alias: 'store.school-student-activity-store',
    
//    model: 'school.model.GradeModel',
//
//    proxy: {
//        
//        type: 'direct',
//        
//        directFn: 'Ext.remote.Student.readActivity' // string!!!
//        
//   }

    fields: ['name', 'data'],
    data: [
        { 'name': 'metric one',   'data': 10 },
        { 'name': 'metric two',   'data':  7 },
        { 'name': 'metric three', 'data':  5 },
        { 'name': 'metric four',  'data':  2 },
        { 'name': 'metric five',  'data': 27 }
    ]

    
});
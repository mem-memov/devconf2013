Ext.define('school.store.StudentActivityStore', {
    
    extend: 'Ext.data.Store',
    
    alias: 'store.school-student-activity-store',
    
    fields: ['subject', 'activity', 'color'],

    proxy: {
        
        type: 'direct',
        
        directFn: 'Ext.remote.Statistics.getStudentActivityData' // string!!!
        
   }

});
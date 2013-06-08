Ext.define('school.store.AssessmentStore', {
    
    extend: 'Ext.data.Store',
    
    alias: 'store.school-assessment-store',
    
    model: 'school.model.AssessmentModel',

    proxy: {
        
        type: 'direct',
        
        api: {
            
            read: 'Ext.remote.Assessment.read'  // string!!!
            
        },
        
        reader: {
            type: 'json',
            root: 'data'
        }
        
   }
    
});
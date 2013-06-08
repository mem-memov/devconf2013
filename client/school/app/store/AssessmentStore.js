Ext.define('school.store.AssessmentStore', {
    
    extend: 'Ext.data.Store',
    
    alias: 'store.school-assessment-store',
    
    model: 'school.model.AssessmentModel',

    proxy: {
        
        type: 'direct',
        
        api: {
            
            create: 'Ext.remote.Assessment.create',  // string!!!
            read: 'Ext.remote.Assessment.read',  // string!!!
            update: 'Ext.remote.Assessment.update',  // string!!!
            destroy: 'Ext.remote.Assessment.destroy'  // string!!!
            
        },
        
        reader: {
            type: 'json',
            root: 'data'
        }
        
   }
    
});
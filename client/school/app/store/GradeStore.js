Ext.define('school.store.GradeStore', {
    
    extend: 'Ext.data.Store',
    
    alias: 'store.school-grade-store',
    
    model: 'school.model.GradeModel',

    proxy: {
        
        type: 'direct',
        
        directFn: 'Ext.remote.Grade.readAll' // string!!!
        
   }
    
//    proxy: {
//        
//        type: 'direct',
//        
//        api: {
//
//            read: 'Ext.remote.Grade.getAll'
//            
//        },
//        
//        reader: {
//            type: 'json',
//            root: 'data'
//        }
//        
//    }
    
//    data: [
//        { id: 1, grade: 'Outstanding', passing: true, position: 1 },
//        { id: 2, grade: 'Exceeds Expectations', passing: true, position: 2 },
//        { id: 3, grade: 'Acceptable', passing: true, position: 3 },
//        { id: 4, grade: 'Poor', passing: false, position: 4 },
//        { id: 5, grade: 'Dreadful', passing: false, position: 5 },
//        { id: 6, grade: 'Troll', passing: false, position: 6 }
//    ]
    
});
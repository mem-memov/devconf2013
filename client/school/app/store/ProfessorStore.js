Ext.define('school.store.ProfessorStore', {
    
    extend: 'Ext.data.Store',
    
    alias: 'store.school-professor-store',
    
    model: 'school.model.ProfessorModel',

    proxy: {
        
        type: 'direct',
        
        directFn: 'Ext.remote.Professor.readNameList' // string!!!
        
   }
   
    
//    data: [
//        { id: 1, first_name: 'Minerva', last_name: 'McGonagall' },
//        { id: 2, first_name: 'Quirinus', last_name: 'Quirrell' },
//        { id: 3, first_name: 'Charity', last_name: 'Burbage' },
//        { id: 4, first_name: 'Silvanus', last_name: 'Kettleburn' }
//    ]
    
});
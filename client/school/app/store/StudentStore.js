Ext.define('school.store.StudentStore', {
    
    extend: 'Ext.data.Store',
    
    alias: 'store.school-student-store',
    
    model: 'school.model.StudentModel',
    
    data: [
        { id: 1, year: 1991, house: 'Gryffindor', first_name: 'Lavender', last_name: 'Brown' },
        { id: 20, year: 1991, house: 'Hufflepuff', first_name: 'Megan', last_name: 'Jones' }
    ]
    
});
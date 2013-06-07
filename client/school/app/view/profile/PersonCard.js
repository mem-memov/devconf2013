Ext.define('school.view.profile.PersonCard', {
    
    extend: 'Ext.Component',
    
    alias: 'widget.school-student-card',
    
    tpl: [
        '<h1 class="title">{first_name} {last_name}</h1>'
    ],
    
    data: {
        first_name: ''
    }
});
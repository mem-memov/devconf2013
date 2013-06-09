Ext.define('school.view.profile.PersonCard', {
    
    extend: 'Ext.Component',
    
    alias: 'widget.school-student-card',
    
    tpl: [
        '<table><tr>',
        '<td><img src="{image}" style="width: 100px;" /></td>',
        '<td><h1 class="title">{first_name} {last_name}</h1></td>',
        '</tr><table>'
    ]
    
});
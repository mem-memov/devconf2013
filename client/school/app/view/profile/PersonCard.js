Ext.define('school.view.profile.PersonCard', {
    
    extend: 'Ext.Component',
    
    alias: 'widget.school-student-card',
    
    tpl: [
        '<table style="width: 100%; height: 100%;"><tr>',
        '<td style="width: 50%;"><img src="{image}" style="width: 100%;" /></td>',
        '<td style="width: 50%;"><h1 class="title">{first_name} {last_name}</h1></td>',
        '</tr><table>'
    ]
    
});
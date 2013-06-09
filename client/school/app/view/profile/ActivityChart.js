Ext.define('school.view.profile.ActivityChart', {
    
    extend: 'Ext.chart.Chart',
    
    requires: [
        'Ext.util.Point' // http://www.sencha.com/forum/showthread.php?259304-Error-in-onMouseEnter-on-Sprites
    ],
    
    alias: 'widget.school-student-activity-chart',

    animate: true,
    
    store: {
        type: 'school-student-activity-store'
    },
    
    legend: {
        position: 'right',
        boxStrokeWidth: 0
    },
    
    series: [{
        type: 'pie',
        angleField: 'activity',
        donut: 30,
        //showInLegend: true,
        label: {
            field: 'subject'
        },
        renderer: function(sprite, record, attributes, index, store) {

            return Ext.apply(attributes, {
                fill: record.get('color')
            });
            
        },
        tips: {
            trackMouse: true,
            width: 140,
            height: 28,
            renderer: function(storeItem, item) {
                this.setTitle(storeItem.get('subject').replace(' ', '<br />'));
            }
        }
    }]
    
});
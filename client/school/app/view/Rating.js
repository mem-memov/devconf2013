Ext.define('school.view.Rating', {
    
    extend: 'Ext.chart.Chart',
    
    alias: 'widget.school-rating',
    
    store: {
        type: 'school-rating-store'
    },
    
    axes: [
        {
            title: 'Рейтинг',
            type: 'Numeric',
            position: 'left',
            fields: ['rating'],
            minimum: 0
        },
        {
            title: 'Факультет',
            type: 'Category',
            position: 'bottom',
            fields: ['house']
        }
    ],
    
    series: [
        {
            type: 'column',
            xField: 'house',
            yField: 'rating'
        }
    ]
    
});
Ext.define('school.controller.RatingController', {
    
    extend: 'Ext.app.Controller',
    
    init: function() {
        
        this.listen({
            component: {
                'school-rating': {
                    added: this.onAdded
                }
            },
            controller: {
                '*': {
                    'student-selected': this.onStudentSelected
                }
            }
        });
        
    },
    
    onAdded: function(ratingView) {
        
        ratingView.getStore().load();
        
    },
    
    onStudentSelected: function(student) {
        
        var ratingViews = Ext.ComponentQuery.query('school-rating');
        
        Ext.Array.each(ratingViews, function(ratingView) {
            
            var name = student.house,
                series = ratingView.series.get(0),
                i, items, l;

            series.highlight = true;
            series.unHighlightItem();
            series.cleanHighlights();
            for (i = 0, items = series.items, l = items.length; i < l; i++) {
                if (name == items[i].storeItem.get('house')) {
                    series.highlightItem(items[i]);
                    break;
                }
            }
            series.highlight = false;
            
        });
        
        
        
    }
    
});
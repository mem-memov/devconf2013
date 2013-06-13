Ext.define('school.store.RatingStore', {
    
    extend: 'Ext.data.Store',
    
    alias: 'store.school-rating-store',
    
    model: 'school.model.RatingModel',
    
    proxy: {
        
        type: 'direct',
        
        directFn: 'Ext.remote.Statistics.getHouseRating'
        
    }
    
});
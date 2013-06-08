<?php
class School_DataAccess_TimeMachine extends School_DataAccess_Abstract_Provider {
    
    public function getCurrentDate() {
        
        // сохраняем хронологию произведения
        if (empty($request->date)) {
            $now = new DateTime();
            $year = ($now->format('n') > 7) ? '1991' : '1992';
            $then = new DateTime( $year . '-' . $now->format('m') . '-' . $now->format('d') );
            $date = $then->format('Y-m-d');
        }
        
        return $date;
        
    }
    
}
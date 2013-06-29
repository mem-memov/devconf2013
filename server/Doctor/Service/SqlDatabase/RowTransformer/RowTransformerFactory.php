<?php
/**
 * Фабрика преобразователей табличных данных
 */
class Doctor_Service_SqlDatabase_RowTransformer_RowTransformerFactory {
    
    /**
     * Создаёт преобразователь табличных данных
     * @param array $rows массив, состоящий из однотипных ассоциативных массивов
     * @return Doctor_Service_SqlDatabase_RowTransformer_RowTransformer
     */
    public function makeRowTransformer(array $rows) {
        
        return new Doctor_Service_SqlDatabase_RowTransformer_RowTransformer($rows);
        
    }
    
}
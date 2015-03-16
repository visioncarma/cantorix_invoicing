<?php
App::uses('AppModel', 'Model');
/**
 * SbsDowngradeRequest Model
 *
 */
class SbsDowngradeRequest extends AppModel {
    public function savemethod($array) {
        
        
        $this->create();
        //$dataSource = $this->getDataSource('default');
        $dataSource = $this->getDataSource();
        debug($dataSource);
        $dataSource->begin();
        if($this->save($array)) {
            debug('11111');
            debug($dataSource->rollback());
            $dataSource->rollback();
        } else {
            debug('22222');
            $dataSource->commit();
        }
        return;
    }    
} 
?>
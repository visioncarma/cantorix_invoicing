<?php 
App::uses('AppModel','Model');
Class ServerDetail extends AppModel {
    public function getServerDetail() {
        return $this->find('first');
    }
}
?>

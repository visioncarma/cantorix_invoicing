<?php
    App::uses('AppModel', 'Model');
    Class AcrClientCreditnoteProduct extends AppModel {
    /**
     * belongsTo associations
     *
     * @var array
     */
        public $belongsTo = array(
            'AcrClientCreditnote' => array(
                'className' => 'AcrClientCreditnote',
                'foreignKey' => 'acr_client_creditnote_id',
                'conditions' => '',
                'fields' => '',
                'order' => ''
            )
        );
    }
?>
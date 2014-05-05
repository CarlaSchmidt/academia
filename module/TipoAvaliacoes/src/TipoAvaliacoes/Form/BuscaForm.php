<?php
namespace TipoAvaliacoes\Form;

use Zend\Form\Form;

class BuscaForm extends Form {

    public function __construct($name = null) {
        parent::__construct('index');

        $this->setAttribute('method', 'post');
        
        $this->add(array(
            'name' => 'busca',
            'type' => 'text',
            'options' => array(
                'label' => 'Busca:',
            ),
        ));
        
        $this->add(array(
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => array(
                'value' => 'Buscar',
                'tpaval_id' => 'submitbutton',
            ),
        ));
    }

}
<?php
namespace TipoAvaliacoes\Form;

use Zend\Form\Form;

class AvaliacoesForm extends Form {

    public function __construct($name = null) {
        parent::__construct('index');

        $this->setAttribute('method', 'post');

        $this->add(array(
            'name' => 'tpaval_id',
            'type' => 'Hidden',
        ));
        
        $this->add(array(
            'name' => 'cd',
            'type' => 'text',
            'options' => array(
                'label' => 'Codigo',
            ),
        ));

        $this->add(array(
            'name' => 'descr',
            'type' => 'Textarea',
            'options' => array(
                'label' => 'Descrição',
            ),
        ));

        $this->add(array(
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => array(
                'value' => 'Enviar',
                'tpaval_id' => 'submitbutton',
            ),
        ));
    }

}

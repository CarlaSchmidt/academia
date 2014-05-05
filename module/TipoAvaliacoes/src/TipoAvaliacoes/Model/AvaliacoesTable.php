<?php

// namespace de localizacao do nosso model

namespace TipoAvaliacoes\Model;

// import Zend\Db
use Zend\Db\TableGateway\TableGateway;
use TipoAvaliacoes\Model\Avaliacoes;

class AvaliacoesTable {

    protected $tableGateway;

    /**
     * Contrutor com dependencia do Adapter do Banco
     *
     * @param \Zend\Db\Adapter\Adapter $adapter
     */
    
    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll() {        
        $resultSet = $this->tableGateway->select();
        //var_dump($resultSet);exit;
        return $resultSet;
    }

    public function getAvaliacoes($id) {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(array('tpaval_id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveAvaliacoes($contato) {

        $data = array(
            'cd' => $contato->cd,
            'descr' => $contato->descr,
        );

        $id = (int) $contato->tpaval_id;
        
        if ($id == 0) {           
            $this->tableGateway->insert($data);
        } else {
            if ($this->getAvaliacoes($id)) {
                $this->tableGateway->update($data, array('tpaval_id' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }

    public function deleteAvaliacoes($id) {
        $this->tableGateway->delete(array('tpaval_id' => $id));
    }

}

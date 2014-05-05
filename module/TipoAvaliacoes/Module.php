<?php

namespace TipoAvaliacoes;

// import Model\Contato
use TipoAvaliacoes\Model\Avaliacoes,
    TipoAvaliacoes\Model\AvaliacoesTable;
// import Zend\Db
use Zend\Db\ResultSet\ResultSet,
    Zend\Db\TableGateway\TableGateway;

class Module {

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    /**
     * Register Services
     */
    public function getServiceConfig() {
        return array(
            'factories' => array(
                'AvaliacoesTableGateway' => function ($sm) {
                    // obter adapter db atraves do service manager
                    $adapter = $sm->get('AdapterDb');
                    // configurar ResultSet com nosso model avaliacoes
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Avaliacoes());
                    //return TableGateway configurado para nosso model Avaliacoes
                    return new TableGateway('tipo_avaliacoes', $adapter, null, $resultSetPrototype);
                },
                'ModelAvaliacoes' => function ($sm) {
                    // return instacia Model ContatoTable
                    return new AvaliacoesTable($sm->get('AvaliacoesTableGateway'));
                }
            )
        );
    }
}
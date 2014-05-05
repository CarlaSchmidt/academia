<?php

/**
 * namespace de localizacao do nosso controller
 */

namespace TipoAvaliacoes\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use TipoAvaliacoes\Model\Avaliacoes;
use TipoAvaliacoes\Form\AvaliacoesForm,
    TipoAvaliacoes\Form\BuscaForm;

class HomeController extends AbstractActionController {

    protected $avaliacoesTable;

    /**
     * action index
     * @return \Zend\View\Model\ViewModel
     */
    public function indexAction() 
    {
        $form = new BuscaForm();
        $form->get('submit')->setValue('Enviar');

        $request = $this->getRequest();
        
        if ($request->isPost()) {
        
            $form->setData($request->getPost());
            
            if ($form->isValid()) {
                $data = $form->getData();
                $result = $this->getAvaliacoesTable()->getBusca($data['busca']);
            }
        }else{
            $result = $this->getAvaliacoesTable()->fetchAll();
        }
        return array('form' => $form, 'avaliacoes' => $result);
        // enviar para view o array com key contatos e value com todos os contatos
    }

    // GET /contatos/novo
    public function novoAction() {
        $form = new AvaliacoesForm();
        $form->get('submit')->setValue('Enviar');
        $request = $this->getRequest();
            if ($request->isPost()) {
                $contato = new Avaliacoes();
                $form->setData($request->getPost());

            if ($form->isValid()) {
                $contato->exchangeArray($form->getData());
                $this->getAvaliacoesTable()->saveAvaliacoes($contato);
                $values = $request->getPost();
                    try {
                        return $this->redirect()->toRoute('novo');
                    } catch (\Exception $e) {
                        return $this->redirect()->toRoute('home');
                    }
                }
            }
        return array('form' => $form);
    }

// GET /contatos/detalhes/id
    public function detalhesAction() {
        // filtra id passsado pela url
        $id = (int) $this->params()->fromRoute('tpaval_id', 0);

        // se id = 0 ou não informado redirecione para contatos
        if (!$id) {
            // adicionar mensagem
            $this->flashMessenger()->addMessage("Tipo não encontrado");

            // redirecionar para action index
            return $this->redirect()->toRoute('home');
        }

        try {
            $form = (array) $this->getAvaliacoesable()->getAvaliacoes($id);
        } catch (\Exception $exc) {
            // adicionar mensagem
            $this->flashMessenger()->addErrorMessage($exc->getMessage());

            // redirecionar para action index
            return $this->redirect()->toRoute('home');
        }

        // dados eviados para detalhes.phtml
        return array('tpaval_id' => $id, 'form' => $form);
    }

    // GET /contatos/editar/id
    public function editarAction() {
        
        $request = $this->getRequest();
        if($request->isPost()) {
            $this->getAvaliacoesTable()->saveAvaliacoes($request->getPost());
            return $this->redirect()->toRoute('home');
        }

        // filtra id passsado pela url
        $id = (int) $this->params()->fromRoute('tpaval_id', 0);

       $album = $this->getAvaliacoesTable()->getAvaliacoes($id);

        $form  = new AvaliacoesForm();
        $form->bind($album);
        //$form->get('submit')->setAttribute('value', 'Edit');

        return array(
            'tpaval_id' => $id,
            'form' => $form,
        );
    }

    // PUT /contatos/editar/id
    public function atualizarAction() {
        // obtém a requisição
        $request = $this->getRequest();

        // verifica se a requisição é do tipo post
        if ($request->isPost()) {
            // obter e armazenar valores do post
            $postData = $request->getPost()->toArray();
            $formularioValido = true;

            // verifica se o formulário segue a validação proposta
            if ($formularioValido) {
                // aqui vai a lógica para editar os dados à tabela no banco
                // 1 - solicitar serviço para pegar o model responsável pela atualização
                // 2 - editar dados no banco pelo model
                // adicionar mensagem de sucesso
                $this->flashMessenger()->addSuccessMessage("Contato editado com sucesso");

                // redirecionar para action detalhes
                return $this->redirect()->toRoute('home', array("action" => "detalhes", "id" => $postData['id'],));
            } else {
                // adicionar mensagem de erro
                $this->flashMessenger()->addErrorMessage("Erro ao editar contato");

                // redirecionar para action editar
                return $this->redirect()->toRoute('home', array('action' => 'editar', "id" => $postData['id'],));
            }
        }
    }

    // DELETE /contatos/deletar/id
    public function deletarAction() {

        $id = (int) $this->params()->fromRoute('tpaval_id', 0);

        if (!$id) {
            throw new \Exception('o tpaval_id e vazio');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('deletar', 'No');

            if ($del == 'Sim') { 
                $id = (int) $request->getPost('tpaval_id');
                $this->getAvaliacoesTable()->deleteAvaliacoes($id);
            }

            // Redirect to list of home
            return $this->redirect()->toRoute('home');
        }

        return array(
            'tpaval_id' => $id,
            'tpaval' => $this->getAvaliacoesTable()->getAvaliacoes($id)
        );
    }

    private function getAvaliacoesTable() {
        // adicionar service ModelContato a variavel de classe
        if (!$this->avaliacoesTable) {
            $this->avaliacoesTable = $this->getServiceLocator()->get('ModelAvaliacoes');
        }

        // return vairavel de classe com service ModelContato
        return $this->avaliacoesTable;
    }

}

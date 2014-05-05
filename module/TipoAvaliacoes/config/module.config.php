<?php

return array(
    # definir e gerenciar controllers
    'controllers' => array(
        'invokables' => array(
            'HomeController' => 'TipoAvaliacoes\Controller\HomeController'
        ),
    ),
    # definir e gerenciar rotas
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/home[/:action][/:tpaval_id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'tpaval_id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'HomeController',
                        'action' => 'index',
                    ),
                ),
            ),
            'novo' => array(
              'type' => 'Literal',
                'options' => array(
                    'route' => '/home/novo',
                    'defaults' => array(
                        'controller' => 'HomeController',
                        'action' => 'novo',
                    ),
                ),
            ),
           
           'editar' => array(
              'type' => 'Literal',
                'options' => array(
                    'route' => '/home/editar',
                    'defaults' => array(
                        'controller' => 'HomeController',
                        'action' => 'editar',
                    ),
                ),
            ),
        ),
    ),
    
    # definir e gerenciar servicos
    'service_manager' => array(
        'factories' => array(
        #'translator' => 'Zend\I18n\Translator\TranslatorServiceFactory',
        ),
    ),
    # definir e gerenciar layouts, erros, exceptions, doctype base
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => array(
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'tipo-avaliacoes/home/index' => __DIR__ . '/../view/tipo-avaliacoes/home/index.phtml',
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);

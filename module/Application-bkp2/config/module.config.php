<?php
/**
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @copyright Copyright (c) 2014 Zend Technologies USA Inc. (http://www.zend.com)
 */

return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
            'zf-apigility' => array(
                    'child_routes' => array(
                        'swagger' => array(
                            'type' => 'Zend\Mvc\Router\Http\Segment',
                            'options' => array(
                                'route'    => '/swagger',
                                'defaults' => array(
                                    'controller' => 'ZF\Apigility\Documentation\Swagger\SwaggerUi',
                                    'action'     => 'list',
                                ),
                            ),
                            'may_terminate' => true,
                            'child_routes' => array(
                                'api' => array(
                                    'type' => 'Segment',
                                    'options' => array(
                                        'route' => '/:api',
                                        'defaults' => array(
                                            'action' => 'show',
                                        ),
                                    ),
                                    'may_terminate' => true,
                                ),
                            ),
                        ),
                    ),
            ),


        ),
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Db\Adapter\AdapterAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'factories' => array(
            'ZF\Apigility\Documentation\Swagger\SwaggerViewStrategy' => 'ZF\Apigility\Documentation\Swagger\SwaggerViewStrategyFactory',
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Application\Controller\Index' => 'Application\Controller\IndexController',
        ),
        'factories' => array(
            'ZF\Apigility\Documentation\Swagger\SwaggerUi' => 'ZF\Apigility\Documentation\Swagger\SwaggerUiControllerFactory',
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),

    'asset_manager' => array(
        'resolver_configs' => array(
            'paths' => array(
                __DIR__ . '/../asset',
            ),
        ),
    ),
    'zf-content-negotiation' => array(
        'accept_whitelist' => array(
            'ZF\Apigility\Documentation\Controller' => array(
                0 => 'application/vnd.swagger+json',
            ),
        ),
        'selectors' => array(
            'Documentation' => array(
                'ZF\Apigility\Documentation\Swagger\ViewModel' => array(
                    'application/vnd.swagger+json',
                ),
            )
        )
    ),
);

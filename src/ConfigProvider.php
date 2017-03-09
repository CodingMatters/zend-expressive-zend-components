<?php

declare(strict_types = 1);

namespace Zend\Component;

use Zend\ServiceManager\AbstractFactory\ConfigAbstractFactory;
use Zend\View\HelperPluginManager;
use Zend\Expressive\Router;
use Zend\Expressive\Template;
use Zend\Expressive\ZendView;
use Zend\Expressive\Container;

final class ConfigProvider
{
    /** @return array */
    public function __invoke() : array
    {
        return [
            "dependencies" => $this->getServiceConfig()
        ];
    }

    /**
     * Dependency mapping configuration.
     *
     * Recommendation: Using fully-qualified class names whenever possible as service names.
     * @example Fully\Qualified\InterfaceName::class => Fully\Qualified\ClassName::class
     *
     * @return array
     */
    public function getServiceConfig() : array
    {
        return [
            // This allows you to define services using a configuration map.
            // Rather than having to create separate factories for each of your services.
            // @see https://docs.zendframework.com/zend-servicemanager/config-abstract-factory/
            'abstract_factories' => [
                ConfigAbstractFactory::class,
            ],
            // Use 'invokables' for constructor-less (do not require arguments ) services,
            'invokables'    => [
                Router\RouterInterface::class => Router\ZendRouter::class,
            ],

            // Use 'factories' for services provided by callbacks/factory classes.
            'factories'     => [
                // Templating
                Template\TemplateRendererInterface::class   => ZendView\ZendViewRendererFactory::class,
                HelperPluginManager::class                  => ZendView\HelperPluginManagerFactory::class,
            ]
        ];
    }
}

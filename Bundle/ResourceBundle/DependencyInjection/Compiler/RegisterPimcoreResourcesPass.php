<?php

namespace CoreShop\Bundle\ResourceBundle\DependencyInjection\Compiler;

use CoreShop\Component\Resource\Model\ResourceInterface;
use CoreShop\Component\Resource\Pimcore\Model\PimcoreModelInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;

final class RegisterPimcoreResourcesPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        try {
            $resources = $container->getParameter('coreshop.pimcore');
            $registry = $container->findDefinition('coreshop.resource_registry');
        } catch (InvalidArgumentException $exception) {
            return;
        }

        foreach ($resources as $alias => $configuration) {
            $this->validateCoreShopPimcoreModel($configuration['classes']['model'], $configuration['classes']['interface']);
            $registry->addMethodCall('addFromAliasAndConfiguration', [$alias, $configuration]);
        }
    }

    /**
     * @param $class
     * @param $interface
     */
    private function validateCoreShopPimcoreModel($class, $interface)
    {
        if (!in_array($interface, class_implements($class), true)) {
            throw new InvalidArgumentException(sprintf(
                'Class "%s" must implement "%s" to be registered as a CoreShop Pimcore model.',
                $class,
                $interface
            ));
        }

        if (!in_array(PimcoreModelInterface::class, class_implements($class), true)) {
            throw new InvalidArgumentException(sprintf(
                'Class "%s" must implement "%s" to be registered as a CoreShop Pimcore model.',
                $class,
                PimcoreModelInterface::class
            ));
        }
    }
}

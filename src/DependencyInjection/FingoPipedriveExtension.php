<?php declare(strict_types=1);
namespace Fingo\Bundle\PipedriveBundle\DependencyInjection;

use Exception;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class FingoPipedriveExtension extends Extension
{
    /**
     * @throws Exception
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new XmlFileLoader($container, new FileLocator(dirname(__DIR__).'/Resources/config'));
        $loader->load('services.xml');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $registryDefinition = $container->getDefinition('fingo_bundle.services.pipedrive_provider_registry');

        foreach($config['providers'] as $name => $provider) {
            $providerId = 'fingo_bundle.services.provider.' . $name;
            $providerDef = $container->register($providerId, 'Fingo\Bundle\PipedriveBundle\Services\PipedriveProvider');
            $providerDef->setArguments([
                $provider['client_id'],
                $provider['client_secret'],
                $provider['redirect_uri'],
                $provider['secret']
            ]);
            $registryDefinition->addMethodCall('registerProvider', [
                new Reference($providerId),
                $name
            ]);
        }
    }

    public function getAlias(): string
    {
        return 'fingo_pipedrive';
    }
}
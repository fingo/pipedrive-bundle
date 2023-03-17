<?php declare(strict_types=1);
namespace Fingo\PipedriveBundle\Tests;

use Exception;
use Fingo\Bundle\PipedriveBundle\FingoPipedriveBundle;
use Fingo\Bundle\PipedriveBundle\Services\PipedriveProvider;
use Fingo\Bundle\PipedriveBundle\Services\PipedriveProviderRegistry;
use PHPUnit\Framework\TestCase;
use Pipedrive\Client;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;

class FingoPipedriveBundleTest extends TestCase
{
    public function testBundleIsInitializedProperly()
    {
        $kernel = new FingoPipedriveBundleTestingKernel('test', true);
        $kernel->boot();
        $container = $kernel->getContainer();

        $registry = $container->get('fingo_bundle.services.pipedrive_provider_registry');
        $this->assertInstanceOf(PipedriveProviderRegistry::class, $registry);

        $provider = $registry->getProvider('provider_one');
        $this->assertInstanceOf(PipedriveProvider::class, $provider);

        $client = $provider->getClient();
        $this->assertInstanceOf(Client::class, $client);

        $provider = $registry->getProvider('provider_two');
        $this->assertInstanceOf(PipedriveProvider::class, $provider);

        $client = $provider->getClient();
        $this->assertInstanceOf(Client::class, $client);
    }
}

class FingoPipedriveBundleTestingKernel extends Kernel
{
    public function registerBundles(): array
    {
        return [
            new FingoPipedriveBundle(),
        ];
    }

    /**
     * @throws Exception
     */
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/test_config.yaml');
    }
}
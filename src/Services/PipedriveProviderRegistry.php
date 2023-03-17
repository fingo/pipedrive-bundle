<?php declare(strict_types=1);
namespace Fingo\Bundle\PipedriveBundle\Services;

use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;

class PipedriveProviderRegistry
{
    private array $providers;

    public function registerProvider(PipedriveProviderInterface $provider, $name): void
    {
        $this->providers[$name] = $provider;
    }

    public function getProvider(string $name): PipedriveProviderInterface
    {
        if (!isset($this->providers[$name])) {
            throw new InvalidConfigurationException(
                sprintf(
                    'No provider declared with name "%s" under fingo_pipedrive.providers configuration option',
                    $name
                )
            );
        }

        return $this->providers[$name];
    }
}
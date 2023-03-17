<?php declare(strict_types=1);
namespace Fingo\Bundle\PipedriveBundle\Services;

use Pipedrive\Client;

interface PipedriveProviderInterface
{
    public function getClient(): Client;
}
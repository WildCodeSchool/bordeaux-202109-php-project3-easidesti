<?php

namespace App\Tests\Service;

use App\Service\Definition;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpClient\MockHttpClient;

class DefinitionTest extends KernelTestCase
{
    public function testGenerateDefinition(): void
    {
        self::bootKernel();
        $container = static::getContainer();
        $definition = $container->get(Definition::class);
        $this->assertEquals('L est la 12e lettre et la 9e consonne de l\'alphabet latin.', $definition->generateDefinition('l'));
    }
}

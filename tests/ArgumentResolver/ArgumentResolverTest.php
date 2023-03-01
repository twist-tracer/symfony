<?php

namespace App\Tests\ArgumentResolver;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class ArgumentResolverTest extends WebTestCase
{
    public function testArgumentResolved(): void
    {
        $client = static::createClient();

        $client->jsonRequest(Request::METHOD_GET, 'argument-resolver', [
            'id' => 100500,
            'name' => 'Argument name',
        ]);

        $this->assertEquals(
            '{"id":100500,"name":"Argument name"}',
            $client->getResponse()->getContent()
        );
    }
}
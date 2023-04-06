<?php

namespace App\Tests\Security;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\InMemoryUser;

class SecurityTest extends WebTestCase
{
    public function testPublic(): void
    {
        $client = static::createClient();

        $client
            ->jsonRequest(Request::METHOD_GET, 'unsafety/public');

        $this->assertEquals(
            '{"user":null}',
            $client->getResponse()->getContent()
        );
    }

    public function testUnauthorized(): void
    {
        $client = static::createClient();

        $client
            ->jsonRequest(Request::METHOD_GET, 'security/user');

        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
    }

    public function testAuthorized(): void
    {
        $client = static::createClient();

        $client
            ->loginUser(new InMemoryUser('user', 'user'))
            ->jsonRequest(Request::METHOD_GET, 'security/user');

        $this->assertEquals(
            '{"user":{}}',
            $client->getResponse()->getContent()
        );
    }

    public function testForbidden(): void
    {
        $client = static::createClient();

        $client
            ->loginUser(new InMemoryUser('user', 'user'))
            ->jsonRequest(Request::METHOD_GET, 'security/admin');

        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }
}

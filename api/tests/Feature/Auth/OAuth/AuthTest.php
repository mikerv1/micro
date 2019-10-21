<?php

declare(strict_types=1);

namespace Api\Test\Feature\Auth\OAuth;

use Api\Test\Feature\WebTestCase;
use DMS\PHPUnitExtensions\ArraySubset\Assert;
use DMS\PHPUnitExtensions\ArraySubset\ArraySubsetAsserts;

class AuthTest extends WebTestCase
{
    use ArraySubsetAsserts;
    
    protected function setUp(): void
    {
        $this->loadFixtures([
            AuthFixture::class,
        ]);

        parent::setUp();
    }

    public function testMethod(): void
    {
        $response = $this->post('/oauth/auth');
        self::assertEquals(400, $response->getStatusCode());
    }

    public function testSuccess(): void
    {
        $response = $this->post('/oauth/auth', [
            'grant_type' => 'password',
            'username' => 'oauth@example.com',
            'password' => 'password',
            'client_id' => 'app',
            'client_secret' => '',
            'access_type' => 'offline',
        ]);

        self::assertEquals(200, $response->getStatusCode());

        self::assertJson($content = $response->getBody()->getContents());

        $data = json_decode($content, true);
        
        //\Symfony\Component\VarDumper\VarDumper::dump($data);exit();

        self::assertArraySubset([
            'token_type' => 'Bearer',
        ], $data);

        self::assertArrayHasKey('expires_in', $data);
        self::assertNotEmpty($data['expires_in']);

        self::assertArrayHasKey('access_token', $data);
        self::assertNotEmpty($data['access_token']);

        self::assertArrayHasKey('refresh_token', $data);
        self::assertNotEmpty($data['refresh_token']);
    }

    public function testInvalid(): void
    {
        $response = $this->post('/oauth/auth', [
            'grant_type' => 'password',
            'username' => 'oauth@example.com',
            'password' => 'invalid',
            'client_id' => 'app',
            'client_secret' => '',
        ]);

        self::assertEquals(400, $response->getStatusCode());
    }
}

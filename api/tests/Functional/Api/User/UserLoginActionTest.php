<?php

declare(strict_types=1);

namespace Test\Functional\Api\User;

use Psr\Http\Message\ResponseInterface;
use Test\Functional\WebTestCase;

class UserLoginActionTest extends WebTestCase
{
    private string $url = '/v1/users/login';

    protected function setUp(): void
    {
        parent::setUp();
    }


    public function testMethod(): void
    {
        $response = $this->app()->handle(self::json('GET', $this->url));

        self::assertEquals(405, $response->getStatusCode());
    }

    public function testSuccess(): void
    {
        $response = $this->app()->handle(
            self::json(
                'POST',
                $this->url,
                $this->getPostData()
            )
        );

        self::assertEquals(200, $response->getStatusCode());
        self::assertJson($content = $response->getBody()->getContents());

        self::checkOAuthData($response);
    }

    public function testInvalidCredentials(): void
    {
        $data = $this->getPostData();
        $data['password'] = '123456789';

        $response = $this->app()->handle(
            self::json(
                'POST',
                $this->url,
                $data
            )
        );

        $data = json_decode($response->getBody()->getContents(), true);

        self::assertEquals(400, $response->getStatusCode());
        self::assertEquals(
            'The User Entity not found, check user, domain credentials.',
            $data['message']
        );
    }


    public function testEmptyLoginValue(): void
    {
        $data = $this->getPostData();
        $data['login'] = '';

        $response = $this->app()->handle(
            self::json(
                'POST',
                $this->url,
                $data
            )
        );

        $data = json_decode($response->getBody()->getContents(), true);

        self::assertEquals(422, $response->getStatusCode());
        self::assertEquals(
            'This value should not be blank.',
            $data['errors']['login']
        );
    }

    public function testShortLoginValue(): void
    {
        $data = $this->getPostData();
        $data['login'] = 'AS';

        $response = $this->app()->handle(
            self::json(
                'POST',
                $this->url,
                $data
            )
        );

        $data = json_decode($response->getBody()->getContents(), true);

        self::assertEquals(422, $response->getStatusCode());
        self::assertEquals(
            'This value is too short. It should have 3 characters or more.',
            $data['errors']['login']
        );
    }

    public function testEmptyPasswordValue(): void
    {
        $data = $this->getPostData();
        $data['password'] = '';

        $response = $this->app()->handle(
            self::json(
                'POST',
                $this->url,
                $data
            )
        );

        $data = json_decode($response->getBody()->getContents(), true);

        self::assertEquals(422, $response->getStatusCode());
        self::assertEquals(
            'This value should not be blank.',
            $data['errors']['password']
        );
    }

    public function testShortPasswordValue(): void
    {
        $data = $this->getPostData();
        $data['password'] = 'PASS';

        $response = $this->app()->handle(
            self::json(
                'POST',
                $this->url,
                $data
            )
        );

        $data = json_decode($response->getBody()->getContents(), true);

        self::assertEquals(422, $response->getStatusCode());
        self::assertEquals(
            'This value is too short. It should have 6 characters or more.',
            $data['errors']['password']
        );
    }

    private function getPostData(): array
    {
        return [
            "login" => 'admin@test.com',
            "password" => '123456'
        ];
    }

    private function checkOAuthData(ResponseInterface $response): void
    {
        self::checkLocalStorageOAuth($response);
    }

//    private function checkCookieOAuth(ResponseInterface $response): void
//    {
//        $headers = $response->getHeaders();
//        self::assertArrayHasKey('Set-Cookie', $headers);
//
//        $oauthCookie = FigResponseCookies::get($response, 'oauth');
//        self::assertNotEmpty($oauthCookie->getValue());
//    }

    private function checkLocalStorageOAuth(ResponseInterface $response): void
    {
        self::assertArrayHasKey('X-Satrap-1', $response->getHeaders());
        self::assertArrayHasKey('X-Satrap-2', $response->getHeaders());

        $satrap1 = $response->getHeader('X-Satrap-1');
        $satrap2 = $response->getHeader('X-Satrap-2');

        self::assertNotEmpty($satrap1);
        self::assertNotEmpty($satrap2);
    }
}

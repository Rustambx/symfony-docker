<?php

namespace App\Tests\Functional\User\Controller;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class UserControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = $this->createClientForAdmin();
        $client->followRedirect();
        $client->request('GET', '/user');
        $this->assertEquals('Users index', $client->getCrawler()->filter('html h1')->first()->text());
    }

    public function testEdit()
    {
        $client = $this->createClientForAdmin();
        $client->request('GET', '/user/edit/1');
        $this->assertEquals('Edit User', $client->getCrawler()->filter('html h1')->first()->text());
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $client->submitForm('Update', [
            'user_edit[email]' => 'test@mail.ru',
            'user_edit[roles][0]' => 'ROLE_ADMIN',
        ]);
    }

    public function testDelete()
    {
        $client = $this->createClientForAdmin();
        $client->request('GET', '/user/edit/1');
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $client->submit($client->getCrawler()->filter('#delete-form')->form());
    }

    /**
     * @return KernelBrowser
     */
    protected function createClientForAdmin(): KernelBrowser
    {
        static::ensureKernelShutdown();
        $client = static::createClient();

        $client->request('GET', '/');
        $this->assertEquals(Response::HTTP_FOUND, $client->getResponse()->getStatusCode());

        $client->followRedirect();
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());

        $client->submitForm('Login', [
            'email' => 'admin@mail.ru',
            'password' => '12345678',
        ]);

        return $client;
    }
}
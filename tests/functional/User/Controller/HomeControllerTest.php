<?php

namespace App\Tests\Functional\User\Controller;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class HomeControllerTest extends WebTestCase
{
    public function testHome()
    {
        $client = $this->createClientForAdmin();
        $this->assertEquals('Hello', $client->getCrawler()->filter('html h1')->first()->text());
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
        $crawler = $client->followRedirect();
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->assertEquals('Hello', $crawler->filter('h1')->first()->text());

        return $client;
    }
}

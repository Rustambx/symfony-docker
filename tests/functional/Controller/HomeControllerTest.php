<?php

namespace App\Controller;

use App\User\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeControllerTest extends WebTestCase
{
    /**
     * @test
     * @param UserRepository $userRepository
     */
    public function testHome()
    {
        $this->markTestSkipped();
        $client = static::createClient();
        /*$userRepository = static::$container->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneBy(['email' => 'admin@mail.ru']);

        // simulate $testUser being logged in
        $client->loginUser($testUser);*/
        $client->request('GET', '/');

        /*$this->assertEquals(200, $client->getResponse()->getStatusCode());*/
        $this->assertSelectorTextContains('html h1', 'Hello');
    }
}
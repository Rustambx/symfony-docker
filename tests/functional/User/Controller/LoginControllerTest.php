<?php

namespace App\Tests\Functional\User\Controller;

use App\Tests\Functional\WebTestCase;

class LoginControllerTest extends WebTestCase
{
    public function testLogin()
    {
        $client = $this->createClientForAdmin();
    }
}

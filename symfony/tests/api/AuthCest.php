<?php

namespace App\Tests;

use App\Entity\User;
use App\Tests\ApiTester;

class AuthCest
{
    public function _before(ApiTester $I)
    {
        $I->haveInRepository(User::class, ['id' => 1, 'name' => 'a', 'email' => 'asdfsd@asdf.cz', 'accessToken' => 'abcd']);
    }


    public function testSuccesfulAuth(ApiTester $I)
    {
        $I->haveHttpHeader('X-AUTH-TOKEN', 'abcd');
        $I->sendGET('monitored-endpoints');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }

    public function testUnsuccesfulAuth(ApiTester $I)
    {
        $I->haveHttpHeader('X-AUTH-TOKEN', '');
        $I->sendGET('monitored-endpoints');
        $I->seeResponseCodeIs(401);
    }

}

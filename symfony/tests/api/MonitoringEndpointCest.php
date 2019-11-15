<?php

namespace App\Tests;

use App\Entity\MonitoredEndpoint;
use App\Entity\User;
use DateTime;


class MonitoringEndpointCest {

    // tests
    public function testCreate(ApiTester $I) {
        $I->haveInRepository(User::class, ['name' => 'a', 'email' => 'asdfsd@asdf.cz', 'accessToken' => 'abcd']);
        $I->haveHttpHeader('X-AUTH-TOKEN', 'abcd');

        $I->sendPOST('monitored-endpoint', json_encode(
            $this->getEndpointArray()
            )
        );

        $I->seeResponseCodeIs(201);
        $I->seeResponseIsJson();

        $I->seeResponseMatchesJsonType(['status' => 'string', 'id' => 'integer']);

    }

    // tests
    public function testUpdate(ApiTester $I) {
        $userId = $I->haveInRepository(User::class, ['name' => 'a', 'email' => 'asdfsd@asdf.cz', 'accessToken' => 'abcd']);
        $user = $I->grabEntityFromRepository(User::class, ['id' => $userId]);

        $id = $I->haveInRepository(
            MonitoredEndpoint::class,
            $this->getEndpointArrayWithUser($user)
        );

        $I->haveHttpHeader('X-AUTH-TOKEN', 'abcd');

        $I->sendPUT('monitored-endpoint/' . $id, json_encode(
            $this->getEndpointArray()
            )
        );

        $I->seeResponseCodeIs(201);
        $I->seeResponseIsJson();

        $I->seeResponseMatchesJsonType(['status' => 'string', 'id' => 'string']);
    }

    // tests
    public function testDelete(ApiTester $I) {
        $userId = $I->haveInRepository(User::class, ['name' => 'a', 'email' => 'asdfsd@asdf.cz', 'accessToken' => 'abcd']);
        $user = $I->grabEntityFromRepository(User::class, ['id' => $userId]);

        $id = $I->haveInRepository(
            MonitoredEndpoint::class,
            $this->getEndpointArrayWithUser($user)
        );

        $I->haveHttpHeader('X-AUTH-TOKEN', 'abcd');
        $I->sendDelete('monitored-endpoint/' . $id);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->cantSeeInRepository(MonitoredEndpoint::class, ['id' => $id]);
        $I->seeResponseMatchesJsonType(['status' => 'string', 'id' => 'string']);
    }

    // tests
    public function testGetMethods(ApiTester $I) {
        $userId = $I->haveInRepository(User::class, ['name' => 'a', 'email' => 'asdfsd@asdf.cz', 'accessToken' => 'abcd']);
        $user = $I->grabEntityFromRepository(User::class, ['id' => $userId]);

        $id = $I->haveInRepository(
            MonitoredEndpoint::class,
            $this->getEndpointArrayWithUser($user)
        );

        $I->haveHttpHeader('X-AUTH-TOKEN', 'abcd');
        $I->sendGet('monitored-endpoint/' . $id);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->canSeeResponseContains('name');
        $I->canSeeResponseContains('url');
        $I->canSeeResponseContains('monitoredInterval');

        $I->haveHttpHeader('X-AUTH-TOKEN', 'abcd');
        $I->sendGet('monitored-endpoints');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->canSeeResponseContains('name');
        $I->canSeeResponseContains('url');
        $I->canSeeResponseContains('monitoredInterval');
    }

    /**
     * @param $user
     * @return array
     * @throws \Exception
     */
    protected function getEndpointArrayWithUser($user)
    {
        return [
            'name' => 'nazdar',
            'owner' => $user,
            'url' => 'http://vokurka.xz',
            'dateCreated' => new Datetime('2019-01-01 01:00:00'),
            'dateLastChecked' => new Datetime('2019-01-01 01:00:00'),
            'monitoredInterval' => 1
        ];
    }

    /**
     * @return array
     */
    protected function getEndpointArray()
    {
        return [
            'dateCreated' => '2019-01-01 00:00:01',
            'name' => 'test',
            'url' => 'http://alfabeta.cz',
            'dateLastChecked' => '2019-01-01 00:00:01',
            'monitoredInterval' => 1
        ];
    }

}

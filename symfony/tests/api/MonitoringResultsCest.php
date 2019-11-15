<?php

namespace App\Tests;

use App\Entity\MonitoredEndpoint;
use App\Entity\MonitoringResult;
use App\Entity\User;
use App\Repository\MonitoringResultRepository;
use App\Tests\ApiTester;
use DateTime;

class MonitoringResultsCest
{

    // tests
    public function testMissingResource(ApiTester $I)
    {
        $I->haveInRepository(User::class, ['name' => 'a', 'email' => 'asdfsd@asdf.cz', 'accessToken' => 'abcd']);
        $I->haveHttpHeader('X-AUTH-TOKEN', 'abcd');
        $I->sendGET('monitoring-results/9999999999');
        $I->seeResponseCodeIs(400);
    }

    // tests
    public function testExistingResource(ApiTester $I)
    {
        $I->haveHttpHeader('X-AUTH-TOKEN', 'abcd');

        $ownerId = $I->haveInRepository(User::class, ['name' => 'a', 'email' => 'asdfsd@asdf.cz', 'accessToken' => 'abcd']);

        $endpoint = [
            'id' => 1,
            'owner' => $I->grabEntityFromRepository(User::class, ['id' => $ownerId]),
            'name' => 'nazdar',
            'url' => 'http://vokurka.xz',
            'dateCreated' => new Datetime('2019-01-01 01:00:00'),
            'dateLastChecked' => new Datetime('2019-01-01 01:00:00'),
            'monitoredInterval' => 1
        ];

        $resultId = $I->haveInRepository(
            MonitoringResult::class,
            [
                'id' => 1,
                'monitoredEndpoint' => $endpoint,
                'checkDate' => new Datetime('2019-01-01 01:00:00'),
                'returnHttpStatusCode' => 201,
                'returnedPayload' => 'ahoj'
            ]
        );


        $I->canSeeInRepository(MonitoringResult::class, ['id' => $resultId]);
        $entity = $I->grabEntityFromRepository(MonitoringResult::class, ['id' => $resultId]);

        $I->sendGET('/monitoring-results/' . $entity->getMonitoredEndpoint()->getId());
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }

}

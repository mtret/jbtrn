<?php

namespace App\Event;

use App\Entity\MonitoringResult;
use App\Repository\MonitoredEndpointRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class ApiControllerRequest implements EventSubscriberInterface
{

    /**
     * @var MonitoredEndpointRepository
     */
    private $repository;
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * ApiControllerRequest constructor.
     * @param MonitoredEndpointRepository $repository
     * @param EntityManagerInterface $em
     */
    public function __construct(MonitoredEndpointRepository $repository, EntityManagerInterface $em) {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @param FilterResponseEvent $event
     * @throws \Exception
     */
    public function onControllerResponse(FilterResponseEvent $event){
        if (strpos($event->getRequest()->getRequestUri(), '/api/monitored-endpoint') !== 0) {
            return;
        }

        $contentDecoded = json_decode($event->getResponse()->getContent());

        if (!$contentDecoded || (!isset($contentDecoded->id))) {
            return;
        }

        $monitoredEndpoint = $this->repository->find($contentDecoded->id);

        if ($monitoredEndpoint) {
            $monitoringResult = new MonitoringResult();
            $monitoringResult
                ->setCheckDate(new DateTime())
                ->setReturnHttpStatusCode($event->getResponse()->getStatusCode())
                ->setReturnedPayload($event->getResponse()->getContent())
                ->setMonitoredEndpoint($monitoredEndpoint)
                ->getReturnHttpStatusCode();

            $this->em->persist($monitoringResult);
            $this->em->flush();
        }

    }

    public static function getSubscribedEvents() {
        return array(
            KernelEvents::RESPONSE => array('onControllerResponse', -1000),
        );
    }
}
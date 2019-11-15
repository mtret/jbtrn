<?php

namespace App\Controller;

use App\Entity\MonitoredEndpoint;
use App\Entity\MonitoringResult;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * @Route("/api")
 */
class MonitoringResultController extends FOSRestController {

    /**
     * @Rest\Get("/monitoring-results/{id}"), requirements={"id" = "\d+"})
     */
    public function getMonitoringResults($id)
    : \Symfony\Component\HttpFoundation\Response {
        $repository= $this->getDoctrine()->getRepository(MonitoredEndpoint::class);

        /** @var MonitoredEndpoint $endpoint */
        $endpoint = $repository->findOneBy(['id' => $id, 'owner' => $this->getUser()->getId()]);

        return $this->handleView($this->view($endpoint->getMonitoringResultsLimited(10)));
    }

}
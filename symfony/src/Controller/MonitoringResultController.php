<?php

namespace App\Controller;

use App\Entity\MonitoredEndpoint;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;

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

        if ($endpoint) {
            return $this->handleView($this->view($endpoint->getMonitoringResultsLimited(10)));
        }

        return $this->handleView($this->view(['status'=>'Resource not found', 'id' => $id],Response::HTTP_BAD_REQUEST));
    }

}
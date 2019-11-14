<?php

namespace App\Controller;

use App\Entity\MonitoredEndpoint;
use App\Entity\MonitoringResult;
use App\Form\MonitoredEndpointType;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/api")
 */
class MonitoringResultController extends FOSRestController {

    /**
     * @Rest\Get("/monitoring-endpoints")
     */
    public function getMonitoringResultsEndpoints()
    : \Symfony\Component\HttpFoundation\Response {
        $repository= $this->getDoctrine()->getRepository(MonitoringResult::class);
        $endpoints = $repository->findAll();

        return $this->handleView($this->view($endpoints));
    }

}
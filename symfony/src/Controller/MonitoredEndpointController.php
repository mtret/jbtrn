<?php

namespace App\Controller;

use App\Entity\MonitoredEndpoint;
use App\Form\MonitoredEndpointType;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/api")
 */
class MonitoredEndpointController extends FOSRestController {

    /**
     * @Rest\Get("/monitored-endpoints")
     */
    public function getMonitoredEndpoints()
    : \Symfony\Component\HttpFoundation\Response {
        $repository= $this->getDoctrine()->getRepository(MonitoredEndpoint::class);
        $endpoints = $repository->findAll();

        return $this->handleView($this->view($endpoints));
    }

    /**
     * @Rest\Get("/monitored-endpoint/{id}"), requirements={"id" = "\d+"})
     */
    public function getMonitoredEndpoint($id)
    : \Symfony\Component\HttpFoundation\Response {
        $repository= $this->getDoctrine()->getRepository(MonitoredEndpoint::class);
        $endpoints = $repository->find($id);

        return $this->handleView($this->view($endpoints));
    }

    /**
     * @Rest\Post("/monitored-endpoint")
     * @Route(requirements={"_format"="json"})
     *
     * @param Request $request
     * @return Response
     */
    public function createMonitoredEndpoint(Request $request) {
        $endpoint = new MonitoredEndpoint();
        $form = $this->createForm(MonitoredEndpointType::class, $endpoint);
        $data = \json_decode($request->getContent(), true);
        $form->submit($data);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($endpoint);
            $em->flush();

            return $this->handleView($this->view(['status'=>'ok'],Response::HTTP_CREATED));
        }

        return $this->handleView($this->view($form->getErrors(), Response::HTTP_BAD_REQUEST));
    }

    /**
     * @Rest\Put("/monitored-endpoint/{id}"), requirements={"id" = "\d+"})
     */
    public function updateMonitoredEndpoint() {
        
    }

    /**
     * @Rest\Delete("/monitored-endpoint/{id}"), requirements={"id" = "\d+"})
     */
    public function deleteMonitoredEndpoint() {

    }

}
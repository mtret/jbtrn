<?php

namespace App\Controller;

use App\Entity\MonitoredEndpoint;
use App\Entity\User;
use FOS\RestBundle\Controller\FOSRestController;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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
        $endpoints = $repository->findBy(['owner' => $this->getUser()->getId()]);

        return $this->handleView($this->view($endpoints));
    }

    /**
     * @Rest\Get("/monitored-endpoint/{id}"), requirements={"id" = "\d+"})
     * @param $id
     * @return Response
     */
    public function getMonitoredEndpoint($id)
    : \Symfony\Component\HttpFoundation\Response {
        $repository = $this->getDoctrine()->getRepository(MonitoredEndpoint::class);
        $endpoint = $repository->findBy(['id' => $id, 'owner' => $this->getUser()->getId()]);

        return $this->handleView($this->view($endpoint));
    }

    /**
     * @Rest\Post("/monitored-endpoint")
     * @Route(requirements={"_format"="json"})
     *
     * @param Request $request
     * @param ValidatorInterface $validator
     * @return Response
     */
    public function createMonitoredEndpoint(Request $request, ValidatorInterface $validator, SerializerInterface $serializer) {
        $endpoint = $serializer->deserialize($request->getContent(), MonitoredEndpoint::class, 'json');

        /** @var User $owner */
        $owner = $this->getDoctrine()->getRepository(User::class)->find($this->getUser()->getId());
        $endpoint->setOwner($owner);

        $errors = $validator->validate($endpoint);

        if ($errors->count() === 0) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($endpoint);
            $em->flush();

            return $this->handleView($this->view(['status'=>'ok', 'id' => $endpoint->getId()],Response::HTTP_CREATED));
        }

        return $this->handleView($this->view($errors, Response::HTTP_BAD_REQUEST));
    }

    /**
     * @Rest\Put("/monitored-endpoint/{id}"), requirements={"id" = "\d+"})
     * @param Request $request
     * @param ValidatorInterface $validator
     * @param SerializerInterface $serializer
     * @param $id
     * @return Response
     */
    public function updateMonitoredEndpoint(
            Request $request,
            ValidatorInterface $validator,
            SerializerInterface $serializer,
            $id
    ) {
        $repository = $this->getDoctrine()->getRepository(MonitoredEndpoint::class);
        /** @var MonitoredEndpoint $oldEndpoint */
        $oldEndpoint = $repository->find($id);

        if (!$oldEndpoint || (!$oldEndpoint->isSelfOwned($this->getUser()->getId()))) {
            return $this->handleView($this->view(['status'=>'Resource not found', 'id' => $id],Response::HTTP_BAD_REQUEST));
        }

        /** @var MonitoredEndpoint $endpoint */
        $endpoint = $serializer->deserialize($request->getContent(), MonitoredEndpoint::class, 'json');
        $endpoint->setId($id);
        $endpoint->setOwner($oldEndpoint->getOwner());

        $errors = $validator->validate($endpoint);

        if ($errors->count() === 0) {
            $em = $this->getDoctrine()->getManager();
            $em->merge($endpoint);
            $em->flush();

            return $this->handleView($this->view(['status'=>'ok', 'id' => $id],Response::HTTP_CREATED));
        }

        return $this->handleView($this->view($errors, Response::HTTP_BAD_REQUEST));
    }

    /**
     * @Rest\Delete("/monitored-endpoint/{id}"), requirements={"id" = "\d+"})
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function deleteMonitoredEndpoint(Request $request, $id) {
        $repository = $this->getDoctrine()->getRepository(MonitoredEndpoint::class);
        /** @var MonitoredEndpoint $oldEndpoint */
        $oldEndpoint = $repository->find($id);

        if (!$oldEndpoint || (!$oldEndpoint->isSelfOwned($this->getUser()->getId()))) {
            return $this->handleView($this->view(['status'=>'Resource not found', 'id' => $id],Response::HTTP_BAD_REQUEST));
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($oldEndpoint);
        $em->flush();

        return $this->handleView($this->view(['status'=>'ok', 'id' => $id],Response::HTTP_OK));
    }

}
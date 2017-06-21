<?php
/**
 * Created by PhpStorm.
 * User: Francisco
 * Date: 3/30/2017
 * Time: 12:41 AM
 */

namespace Eship\EventBundle\Controller;

use Eship\EventBundle\Entity\Business;
use Eship\EventBundle\Entity\Client;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ClientController extends Controller
{
    /**
     * @Route("/client/{id}", name="event_client_profile")
     */
    public function showAction($id)
    {
        $clientRepository = $this->getDoctrine()
            ->getManager()
            ->getRepository('EventBundle:Client');

        $client = $clientRepository->getClient($id);

        if ($client==null) {
            throw $this->createNotFoundException(
                'There is not a Client with that ID on the system'
            );
        }
        return new JsonResponse($client);
    }

    /**
     * @Route("/client/{id}/edit", name="event_edit_client")
     */

    public function editProfileAction($id, Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $request->request->replace($data);

        $clientRepository = $this->getDoctrine()
            ->getManager()
            ->getRepository('EventBundle:Client');

        $client = $clientRepository->getClient($id);

        if ($client==null)
        {
            throw $this->createNotFoundException(
                'There is not a Client with that ID on the system'
            );
        }
        //dump($client);

        $editedName = 'Bobby';
        $editedLastName = 'Roode';
        $editedEmail = 'bobby.roode1@upr.edu';
        //$email = $Client->getClientEmail();
        //$firstName = $Client->getFirstName();
        //$lastName = $Client->getLastName();
        $initial = $client->getInitial();
        $age = $client->getAge();
        $gender = $client->getGender();
        $phone = $client->getPhone();
        $relationship= $client->getRelationshipWithUPRM();
        $department = $client->getDepartment();
        $specification = $client->getSpecification();
        $businessNotCNDE = $client->getBusinessNotCNDE();
        $learnOfServices = $client->getLearnOfServices();
        $address1 = $client->getAddress1();
        $address2 = $client->getAddress2();
        $city = $client->getCity();
        $zipCode = $client->getZipCode();
        $country = $client->getCountry();
        $isActive = $client->getIsActive();

        $editedClient = $client;

        //Updating Client
        $editedClient->setClientEmail($editedEmail);
        $editedClient->setFirstName($editedName);
        $editedClient->setLastName($editedLastName);
        $editedClient->setInitial($initial);
        $editedClient->setAge($age);
        $editedClient->setGender($gender);
        $editedClient->setPhone($phone);
        $editedClient->setRelationshipWithUPRM($relationship);
        $editedClient->setDepartment($department);
        $editedClient->setSpecification($specification);
        $editedClient->setBusinessNotCNDE($businessNotCNDE);
        $editedClient->setLearnOfServices($learnOfServices);
        $editedClient->setAddress1($address1);
        $editedClient->setAddress2($address2);
        $editedClient->setCity($city);
        $editedClient->setZipCode($zipCode);
        $editedClient->setCountry($country);
        $editedClient->setIsActive($isActive);

        $em = $this->getDoctrine()->getManager();
        $em->persist($editedClient);
        $em->flush();

        return new JsonResponse($client);
    }
}
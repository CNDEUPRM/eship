<?php
/**
 * Created by PhpStorm.
 * User: Francisco
 * Date: 3/19/2017
 * Time: 2:30 AM
 */

namespace Eship\EventBundle\Controller;

use Eship\EventBundle\Entity\Business;
use Eship\EventBundle\Entity\Client;
use Eship\EventBundle\Entity\Counselor;
use Eship\EventBundle\Entity\Owner;
use Eship\EventBundle\Entity\CNDEOwner;
use Eship\EventBundle\Entity\BusinessGrowth;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;


class BusinessController extends Controller
{
    /**
     * @Route("/business", name="event_business")
     */
    public function listAction()
    {
        $businessRepository = $this->getDoctrine()
            ->getManager()
            ->getRepository('EventBundle:Business');

        $businesses = $businessRepository->getBusinessList();

        if ($businesses==null) {
            throw $this->createNotFoundException(
                'No businesses on the system'
            );
        }
        return new JsonResponse($businesses);
    }

    /**
     * @Route("/business/inactive", name="event_business")
     */
    public function inactiveListAction()
    {
        $businessRepository = $this->getDoctrine()
            ->getManager()
            ->getRepository('EventBundle:Business');

        $businesses = $businessRepository->getInactiveBusinessList();

        if ($businesses==null) {
            throw $this->createNotFoundException(
                'No businesses on the system'
            );
        }
        return new JsonResponse($businesses);
    }

    /**
     * @Route("/business/new_business", name="event_add_business")
     */
    public function addBusinessAction(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $request->request->replace($data);

        $client = $this->getClient($request->request->get('client_id'));

        $owner_id = $client->getOwner();

        $owner = $this->getOwner($owner_id);

        if ($owner==null) {
            throw $this->createNotFoundException(
                'There is no user with those credentials in the system'
            );
        }

        $business = new Business();
        $business->setName($request->request->get('business_name'));
        $business->setOwner($owner);
        $business->setBusinessLink($request->request->get('business_link'));
        $business->setDescription($request->request->get('description'));
        $business->setRequestedHelp($request->request->get('requested_help'));
        $business->setNumberOfEmployees($request->request->get('employees'));
        $business->setWebsite($request->request->get('website'));
        $business->setFacebook($request->request->get('facebook'));
        $business->setTwitter($request->request->get('twitter'));
        $business->setLogo($request->request->get('logo'));
        $business->setTypeOfBusiness($request->request->get('type_of_business'));
        $business->setIsProject(0);
        $business->setPrivateInvestment(0);
        $business->setPublicInvestment(0);
        $business->setParticipationBusinessCompetition($request->request->get('business_competition'));
        $business->setNameCompetition($request->request->get('name_competition'));
        $business->setAward($request->request->get('award'));
        $business->setIsActive(1);
        $business->setDate(new \DateTime('now'));
        $business->setWorkedHours(0);

        $em = $this->getDoctrine()->getManager();
        $em->persist($business);
        $em->flush();

        return new JsonResponse($business->getBusinessId());
    }

    /**
     * @Route("/business/edit/{business_id}", name="event_edit_business")
     */
    public function editBusinessAction($business_id, Request $request)
    {// Needs to be edited to obtain full functionality
        $data = json_decode($request->getContent(), true);
        $request->request->replace($data);

        $business = $this->getBusiness($business_id);

        if ($business==null)
        {
            throw $this->createNotFoundException(
                'There is not a Business with that ID on the system'
            );
        }
        dump($business);

        $editedName = 'NJPW';
        $editedBusinessLink = 'Negocio Propio';
        $stageOfDevelopment = 'null';
        $description = 'A company that does stuff';
        $requestedHelp = 'Need Help in stuff';
        $numberEmployees = 19;
        $website = 'njpw.com';
        $facebook = 'facebook.com/njpw';
        $twitter = 'twitter.com/njpw';
        $logo = 'logo';
        $typeClient = 'project';
        $privateInvestment = 3500;
        $publicInvestment = 1256.70;
        $participationCompetition = 0;
        $nameCompetition = 'null';
        $award = 'null';
        $active = 1;

        $editedBusiness = $business;

        //Updating Counselor
        $editedBusiness->setName($editedName);
        $editedBusiness->setBusinessLink($editedBusinessLink);
        $editedBusiness->setStageOfDevelopment($stageOfDevelopment);
        $editedBusiness->setDescription($description);
        $editedBusiness->setRequestedHelp($requestedHelp);
        $editedBusiness->setNumberOfEmployees($numberEmployees);
        $editedBusiness->setWebsite($website);
        $editedBusiness->setFacebook($facebook);
        $editedBusiness->setTwitter($twitter);
        $editedBusiness->setLogo($logo);
        $editedBusiness->setTypeOfClient($typeClient);
        $editedBusiness->setPrivateInvestment($privateInvestment);
        $editedBusiness->setPublicInvestment($publicInvestment);
        $editedBusiness->setParticipationBusinessCompetition($participationCompetition);
        if($editedBusiness->getParticipationBusinessCompetition()==0)
        {
            $editedBusiness->setNameCompetition('null');
            $editedBusiness->setAward('null');
        }
        else{
            $editedBusiness->setNameCompetition($nameCompetition);
            $editedBusiness->setAward($award);
        }
        $editedBusiness->setIsActive($active);

        $em = $this->getDoctrine()->getManager();
        $em->persist($editedBusiness);
        $em->flush();

        dump($editedBusiness);

        return new JsonResponse($editedBusiness);
    }

    /**
     * @Route("/business/{business_id}", name="event_business_profile")
     */
    public function showBusinessAction($business_id)
    {
        $businessRepository = $this->getDoctrine()
            ->getManager()
            ->getRepository('EventBundle:Business');

        $businesses = $businessRepository->getBusinessById($business_id);

        if ($businesses==null) {
            throw $this->createNotFoundException(
                'No businesses on the system'
            );
        }
        //dump($businesses);
        return new JsonResponse($businesses);
    }

    /**
     * @Route("/business/counselor/new_business", name="event_counselor_add_business")
     */
    public function counselorAddBusinessAction(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $request->request->replace($data);

        $counselor_id = $request->request->get('counselor_id');
        $counselor = $this->getCounselor($counselor_id);

        if($counselor->getIsActive()==0){
            $error = array(
                'type' => 'validation_error',
                'title' => 'This account is not active.'
            );

            return new JsonResponse($error, 404);
        }

        $owner = new Owner();
        $owner->setFirstName($request->request->get('first_name'));
        $owner->setLastName($request->request->get('last_name'));
        $owner->setInitial($request->request->get('initial'));
        $owner->setOwnerEmail($request->request->get('email'));

        $cndeOwner = new CNDEOwner();
        $cndeOwner->setEmail($request->request->get('email'));
        $cndeOwner->setOwner($owner);
        $cndeOwner->setCounselor($counselor);

        $business = new Business();
        $business->setName($request->request->get('business_name'));
        $business->setOwner($owner);
        $business->setBusinessLink($request->request->get('business_link'));
        $business->setDescription($request->request->get('description'));
        $business->setRequestedHelp($request->request->get('requested_help'));
        $business->setNumberOfEmployees($request->request->get('employees'));
        $business->setWebsite($request->request->get('stage_development'));
        $business->setWebsite($request->request->get('website'));
        $business->setFacebook($request->request->get('facebook'));
        $business->setTwitter($request->request->get('twitter'));
        $business->setLogo($request->request->get('logo'));
        $business->setTypeOfBusiness($request->request->get('type_of_business'));
        $business->setStageOfDevelopment($request->request->get('stage'));//Add to form
        $business->setIsProject(0);
        $business->setPrivateInvestment(0);
        $business->setPublicInvestment(0);
        $business->setParticipationBusinessCompetition($request->request->get('business_competition'));
        $business->setNameCompetition($request->request->get('name_competition'));
        $business->setAward($request->request->get('award'));
        $business->setIsActive(0);
        $business->setDate(new \DateTime('now'));
        $business->setWorkedHours(0);


        $em = $this->getDoctrine()->getManager();
        $em->persist($owner);
        $em->persist($cndeOwner);
        $em->persist($business);
        $em->flush();

        return new JsonResponse($business->getBusinessId());
    }

    /**
     * @Route("/owned_business/{client_id}", name="event_business_by_client")
     */
    public function getBusinessByClientAction($client_id)
    {
        $client = $this->getClient($client_id);

        $owner_id = $client->getOwner();

        $owner = $this->getOwner($owner_id);

        $businessRepository = $this->getDoctrine()
            ->getManager()
            ->getRepository('EventBundle:Business');

        $businesses = $businessRepository->getBusinessByOwnerId($owner);

        if ($businesses==null) {
            throw $this->createNotFoundException(
                'No businesses on the system'
            );
        }
        return new JsonResponse($businesses);
    }


    /**
     * @Route("/business/{business_id}/growth/{stage}", name="event_business_growth")
     */
    public function growthTrackingAction($business_id, $stage)
    {
        $growthTrackerRepository = $this->getDoctrine()
            ->getManager()
            ->getRepository('EventBundle:BusinessGrowth');

        $growth = $growthTrackerRepository->getBusinessGrowthTracker($business_id, $stage);

        if (!$growth)
        {
            throw $this->createNotFoundException('There are no Work Report for that Meeting Report ID on the system');
        }
        //dump($growth);die;
        return new JsonResponse($growth);
    }

    /**
     * @Route("/business/{business_id}/growth/edit/", name="event_edit_business_growth")
     */
    public function editGrowthTrackingAction($business_id, Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $request->request->replace($data);

        $counselor_id=1;
        $stage = 'Start Up';
        $status = 'In Progress';
        $task = 'Business Model';

        $growthTrackerRepository = $this->getDoctrine()
            ->getManager()
            ->getRepository('EventBundle:BusinessGrowth');

        $growth = $growthTrackerRepository->getBusinessGrowthTracker($business_id, $stage);

        if (!$growth)
        {
            throw $this->createNotFoundException('There are no Work Report for that Meeting Report ID on the system');
        }
        dump($growth);

        $editedGrowth = $growth;

        $editedGrowth = $growthTrackerRepository->editBusinessGrowth($business_id, $stage, $task, $counselor_id, $status);

        dump($editedGrowth);

        return new JsonResponse($growth);
    }

    //Helper Methods
    private function counselorNewBusinessNotification($link, $businessName)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject('A new business have been added to the E-Ship Network Case Management')
            ->setFrom('eship.test.email@gmail.com')
            ->setTo('francisco.morales2@upr.edu')
            ->setBody(
                $this->renderView(
                    'EventBundle:Email:new_business_notification.html.twig',
                    array('businessName' => $businessName,
                        'link' => $link)
                ),
                'text/html'
            );

        $this->get('mailer')
            ->send($message);

        return $this->render('EventBundle:Email:new_business_notification.html.twig',
            array('businessName' => $businessName,
                'link' => $link));
    }

    private function getCounselor($counselor_id)
    {
        $counselorRepository = $this->getDoctrine()
            ->getManager()
            ->getRepository('Eship\EventBundle\Entity\Counselor');

        return $counselorRepository->findOneBy(['counselorId' => $counselor_id]);
    }

    private function getOwner($owner_id)
    {
        $counselorRepository = $this->getDoctrine()
            ->getManager()
            ->getRepository('Eship\EventBundle\Entity\Owner');

        return $counselorRepository->findOneBy(['ownerId' => $owner_id]);
    }

    private function getClient($client_id)
    {
        $clientRepository = $this->getDoctrine()
            ->getManager()
            ->getRepository('Eship\EventBundle\Entity\Client');

        return $clientRepository->findOneBy(['clientId' => $client_id]);
    }

    private function getBusiness($business_id)
    {
        $businessRepository = $this->getDoctrine()
            ->getManager()
            ->getRepository('Eship\EventBundle\Entity\Business');
        return $businessRepository->findOneBy(['business_id' => $business_id]);
    }
}
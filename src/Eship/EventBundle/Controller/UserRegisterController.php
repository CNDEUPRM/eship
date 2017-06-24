<?php
/**
 * Created by PhpStorm.
 * User: Francisco
 * Date: 3/30/2017
 * Time: 12:15 AM
 */

namespace Eship\EventBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Eship\EventBundle\Entity\Client;
use Eship\EventBundle\Entity\Business;
use Eship\EventBundle\Entity\Counselor;
use Eship\EventBundle\Entity\Owner;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class UserRegisterController extends Controller
{
    /**
     * @Route("/register/client", name="event_register_client")
     */
    public function clientRegisterAction(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $request->request->replace($data);

        $client = new Client();

        $client2 = $this->getClientByEmail($request->request->get('email'));
        if($client2 == null)
        {
            $owner = new Owner();
            $owner->setFirstName($request->request->get('first_name'));
            $owner->setLastName($request->request->get('last_name'));
            $owner->setInitial($request->request->get('initial'));
            $owner->setOwnerEmail($request->request->get('email'));

            $client->setClientEmail($request->request->get('email'));
            $client->setAge($request->request->get('age'));
            $client->setGender($request->request->get('gender'));
            $client->setPhone($request->request->get('phone'));
            $client->setPassword($request->request->get('password'));
            $client->setRelationshipWithUPRM($request->request->get('relationship_with_uprm'));
            $client->setDepartment($request->request->get('faculty'));
            $client->setBusinessNotCNDE($request->request->get('businessNotInCNDE'));
            $client->setLearnOfServices($request->request->get('learn_of_services'));
            $client->setAddress1($request->request->get('address1'));
            $client->setAddress2($request->request->get('address2'));
            $client->setCity($request->request->get('city'));
            $client->setZipCode($request->request->get('zip_code'));
            $client->setCountry($request->request->get('country'));
            $client->setOwner($owner);
            $client->setIsActive(1);

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
            $em->persist($owner);
            $em->persist($client);
            $em->persist($business);
            $em->flush();

            $name = $owner->getFirstName().' '.$owner->getInitial().' '.$owner->getLastName();
            $link = 'business.uprm.edu/eshipcase/#/login/';

            $this->clientRegistrationEmail($name, $link, $client->getClientEmail());

            $linkBusiness= 'business.uprm.edu/eshipcase/#/business/'.$business->getBusinessId();
            $this->counselorNewBusinessNotification($linkBusiness, $business->getName());

            return new JsonResponse($business->getBusinessId());
        }

        $error = array(
            'type' => 'validation_error',
            'title' => 'There is already an account with this email.'
        );

        return new JsonResponse($error, 401);

    }

    /**
     * @Route("/register/counselor/{permission_id}", name="event_register_counselor")
     */
    public function counselorRegisterAction($permission_id, Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $request->request->replace($data);

        $counselorRequest = $this->getCounselorRequest($permission_id);
        $counselor2 = $this->getCounselor($counselorRequest->getEmail());

        if($counselorRequest!=null || $counselor2==null)
        {
            if($counselorRequest->getEmail()===$request->request->get('email'))
            {
                $counselor = new Counselor();

                $counselor->setCounselorEmail($counselorRequest->getEmail());
                $counselor->setFirstName($request->request->get('first_name'));
                $counselor->setLastName($request->request->get('last_name'));
                $counselor->setInitial($request->request->get('initial'));
                $counselor->setAge($request->request->get('age'));
                $counselor->setGender($request->request->get('gender'));
                $counselor->setPhone($request->request->get('phone'));
                $counselor->setPassword($request->request->get('password'));
                $counselor->setPosition($request->request->get('position_uprm'));
                $counselor->setDepartment($request->request->get('department'));
                $counselor->setCndeOrganization($request->request->get('cnde_organization'));
                $counselor->setCourses($request->request->get('courses'));
                $counselor->setExpertise($request->request->get('expertise'));
                $counselor->setIsActive(1);
                $counselor->setIsAdmin($counselorRequest->getRole());
                $counselorRequest->setRequestStatus(0);

                $em = $this->getDoctrine()->getManager();
                $em->persist($counselorRequest);
                $em->persist($counselor);
                $em->flush();

                return new JsonResponse($counselor->getCounselorId());
            }
        }
        $error = array(
            'type' => 'validation_error',
            'title' => 'This invitation is not valid. Contact the page admin to get a new one.'
        );

        return new JsonResponse($error, 404);
    }

    //Email Methods
    private function clientRegistrationEmail($name, $link, $email)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject('Welcome to the E-Ship Network Case Management')
            ->setFrom('cnde@uprm.edu')
            ->setTo($email)
            ->setBody(
                $this->renderView(
                    'EventBundle:Email:client_registration.html.twig',
                    array('name' => $name,
                        'link' => $link)
                ),
                'text/html'
            );

        $this->get('mailer')
            ->send($message);

        return $this->render('EventBundle:Email:client_registration.html.twig',
            array('name' => $name,
                'link' => $link));
    }

    private function counselorNewBusinessNotification($link, $businessName)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject('A new Business have been added to the E-Ship Network Case Management')
            ->setFrom('cnde@uprm.edu')
            ->setTo('roberto.irizarry2@upr.edu')
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

    //Helper Methods
    private function getCounselor($counselorEmail)
    {
        $counselorRepository = $this->getDoctrine()
            ->getManager()
            ->getRepository('Eship\EventBundle\Entity\Counselor');

        return $counselorRepository->findOneBy(['counselorEmail' => $counselorEmail]);
    }

    private function getClient($owner_id)
    {
        $counselorRepository = $this->getDoctrine()
            ->getManager()
            ->getRepository('Eship\EventBundle\Entity\Client');

        return $counselorRepository->findOneBy(['owner' => $owner_id]);
    }

    private function getClientByEmail($email)
    {
        $counselorRepository = $this->getDoctrine()
            ->getManager()
            ->getRepository('Eship\EventBundle\Entity\Client');

        return $counselorRepository->findOneBy(['clientEmail' => $email]);
    }

    private function getBusiness($owner_id)
    {
        $counselorRepository = $this->getDoctrine()
            ->getManager()
            ->getRepository('Eship\EventBundle\Entity\Business');

        return $counselorRepository->findOneBy(['owner' => $owner_id]);
    }

    private function getCounselorRequest($request_id)
    {
        $counselorRepository = $this->getDoctrine()
            ->getManager()
            ->getRepository('Eship\EventBundle\Entity\CounselorRequest');

        return $counselorRepository->findOneBy(['requestId' => $request_id]);
    }
}
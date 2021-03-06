<?php
/**
 * Created by PhpStorm.
 * User: Francisco
 * Date: 5/15/2017
 * Time: 11:59 PM
 */

namespace Eship\EventBundle\Controller;

use Eship\EventBundle\Entity\Business;
use Eship\EventBundle\Entity\Counselor;
use Eship\EventBundle\Entity\CounselorRequest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class AdminController extends Controller
{
    /**
     * @Route("/admin/new_counselor", name="event_admin_add_counselor")
     */

    public function addCounselorAction(Request $request)
    {
        //decoding the json file
        $data = json_decode($request->getContent(), true);
        $request->request->replace($data);

        //looking for the counselor object related to the data of the json
        $counselor = $this->getCounselor($request->request->get('counselor_id'));
        $counselor2 = $this->getCounselorByEmail($request->request->get('email'));
        $counselor3 = $this->getCounselorRequestByEmail($request->request->get('email'));

        if($counselor2==null || ($counselor3==null)) //checking if the counselor is not in the database
        {
            //creating a new Counselor Request object and assigning values to it
            $counselorRequest = new CounselorRequest();
            $counselorRequest->setEmail($request->request->get('email'));
            $counselorRequest->setRole($request->request->get('role'));
            $counselorRequest->setRequestStatus(1);
            $counselorRequest->setCounselor($counselor);

            $em = $this->getDoctrine()->getManager();
            $em->persist($counselorRequest); //finishing the query
            $em->flush();

            $adminName = $counselor->getFirstName().' '.$counselor->getLastName();
            $link = 'business.uprm.edu/eshipcase/#/register/counselor/'.$counselorRequest->getRequestId(); //linkf or the email

            $this->counselorRegistrationEmail($adminName, $counselor->getCounselorEmail(), $link, $counselorRequest->getEmail());
            //sending the email
            return new JsonResponse($counselorRequest->getRequestId());
        }
        $error = array(
            'type' => 'validation_error',
            'title' => 'There is already an account with this email.'
        );

        return new JsonResponse($error, 401);
    }

    /**
     * @Route("/admin/counselors", name="event_admin_deactivate_counselor")
     */
    public function deactivateCounselorAction(Request $request)
    {
        //decoding the json
        $data = json_decode($request->getContent(), true);
        $request->request->replace($data);

        $counselor_id = $request->request->get('counselor_id');
        $counselor = $this->getCounselor($counselor_id); //getting the counselor object

        $counselor->setIsActive($request->request->get('status')); //assigning a new value to the counselor object

        $em = $this->getDoctrine()->getManager(); //finishing the query
        $em->persist($counselor);
        $em->flush();

        return new JsonResponse($counselor->getIsActive());
    }

    /**
     * @Route("/admin/business", name="event_admin_deactivate_business")
     */
    public function deactivateBusinessAction(Request $request)
    {
        //decoding the json
        $data = json_decode($request->getContent(), true);
        $request->request->replace($data);

        $business_id = $request->request->get('business_id');
        $business = $this->getBusiness($business_id); //getting the counselor object

        $business->setIsActive($request->request->get('status')); //assigning a new value to the counselor object

        $em = $this->getDoctrine()->getManager(); //finishing the query
        $em->persist($business);
        $em->flush();

        return new JsonResponse($business->getIsActive());
    }

    //Helper methods
    private function counselorRegistrationEmail($adminName, $adminEmail, $link, $email)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject('You have been invited to join the E-Ship Network Case Management')
            ->setFrom('cnde@uprm.edu')
            ->setTo($email)
            ->setBody(
                $this->renderView(
                    'EventBundle:Email:counselor_new_account.html.twig',
                    array('adminName'=>$adminName,
                        'adminEmail'=>$adminEmail,
                        'link'=>$link)
                ),
                'text/html'
            );

        $this->get('mailer')
            ->send($message);

        return $this->render('EventBundle:Email:counselor_new_account.html.twig',
            array('adminName'=>$adminName,
                'adminEmail'=>$adminEmail,
                'link'=>$link));
    }

    private function getCounselorRequestByEmail($counselorEmail)
    {
        $counselorRepository = $this->getDoctrine()
            ->getManager()
            ->getRepository('Eship\EventBundle\Entity\CounselorRequest');

        return $counselorRepository->findOneBy(['email' => $counselorEmail]);
    }

    private function getCounselorByEmail($counselorEmail)
    {
        $counselorRepository = $this->getDoctrine()
            ->getManager()
            ->getRepository('Eship\EventBundle\Entity\Counselor');

        return $counselorRepository->findOneBy(['counselorEmail' => $counselorEmail]);
    }


    private function getCounselor($counselor_id)
    {
        $counselorRepository = $this->getDoctrine()
            ->getManager()
            ->getRepository('Eship\EventBundle\Entity\Counselor');

        return $counselorRepository->findOneBy(['counselorId' => $counselor_id]);
    }

    private function getBusiness($business_id)
    {
        $businessRepository = $this->getDoctrine()
            ->getManager()
            ->getRepository('Eship\EventBundle\Entity\Business');
        return $businessRepository->findOneBy(['business_id' => $business_id]);
    }

}
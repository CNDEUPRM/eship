<?php
/**
 * Created by PhpStorm.
 * User: francisco
 * Date: 5/23/17
 * Time: 4:25 PM
 */
namespace Eship\EventBundle\Controller;
use Eship\EventBundle\Entity\ClientPasswordRequest;
use Eship\EventBundle\Entity\CounselorPasswordRequest;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\Common\Collections\ArrayCollection;
use Eship\EventBundle\Entity\Client;
use Eship\EventBundle\Entity\Counselor;
class ChangePasswordController extends Controller
{
    /**
     * @Route("/forgot_password/counselor", name="event_counselor_forgot_password_request")
     */
    public function counselorPasswordRequestAction(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $request->request->replace($data);
        //$counselorEmail = 'randy.orton@upr.edu';
        $counselor = $this->getCounselorByEmail($request->request->get('email'));
        if($counselor!=null)
        {
            $passwordRequest = new CounselorPasswordRequest();
            $passwordRequest->setCreationDate(new \DateTime('now'));
            $passwordRequest->setExpirationDate(new \DateTime('tomorrow'));
            $passwordRequest->setCounselor($counselor);
            $passwordRequest->setHasBeenUsed(0);
            $em = $this->getDoctrine()->getManager();
            $em->persist($passwordRequest);
            $em->flush();
            $link = 'business.uprm.edu/eshipcase/#/forgot_password/counselor/'.$passwordRequest->getRequestId();
            $this->forgotPasswordEmail($link, $counselor->getCounselorEmail());
            return new JsonResponse('An email has been sent to your account. Please check your inbox');
        }
        $error = array(
            'type' => 'validation_error',
            'title' => 'Password does not match our records'
        );
        return new JsonResponse($error, 404);
    }
    /**
     * @Route("/forgot_password/client", name="event_client_forgot_password_request")
     */
    public function clientPasswordRequestAction(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $request->request->replace($data);
        $client = $this->getClientByEmail($request->request->get('email'));
        if($client!=null)
        {
            $passwordRequest = new ClientPasswordRequest();
            $passwordRequest->setCreationDate(new \DateTime('now'));
            $passwordRequest->setExpirationDate(new \DateTime('tomorrow'));
            $passwordRequest->setClient($client);
            $passwordRequest->setHasBeenUsed(0);
            $em = $this->getDoctrine()->getManager();
            $em->persist($passwordRequest);
            $em->flush();
            $link = 'business.uprm.edu/eshipcase/#/forgot_password/client/'.$passwordRequest->getRequestId();
            $this->forgotPasswordEmail($link, $client->getClientEmail());
            return new JsonResponse('An email has been sent to your account. Please check your inbox');
        }
        $error = array(
            'type' => 'validation_error',
            'title' => 'Password does not match our records'
        );
        return new JsonResponse($error, 404);
    }
    /**
     * @Route("/forgot_password/counselor/{permission_id}", name="event_counselor_forgot_password")
     */
    public function counselorForgotPasswordAction($permission_id, Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $request->request->replace($data);

        $passwordRequest = $this->getCounselorChangePassword($permission_id);
        if($passwordRequest!=null && $passwordRequest->getHasBeenUsed()==0)
        {
            $counselor = $this->getCounselor($passwordRequest->getCounselor());
            $counselor->setPassword($request->request->get('new_password'));
            $passwordRequest->setHasBeenUsed(1);
            $em = $this->getDoctrine()->getManager();
            $em->persist($passwordRequest);
            $em->persist($counselor);
            $em->flush();
            return new JsonResponse('The password has been changed successfully');
        }
        $error = array(
            'type' => 'validation_error',
            'title' => 'Password does not match our records'
        );
        return new JsonResponse($error, 404);
    }
    /**
     * @Route("/settings/change_password/counselor/", name="event_counselor_change_password")
     */
    public function counselorChangePasswordAction(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $request->request->replace($data);
        $counselor = $this->getCounselor($request->request->get('counselor_id'));
        $current_password = $request->request->get('current_password');
        $new_password = $request->request->get('new_password');
        if($counselor->getPassword()==$current_password)
        {
            $counselor->setPassword($new_password);
            $em = $this->getDoctrine()->getManager();
            $em->persist($counselor);
            $em->flush();
            return new JsonResponse('The password has been updated successfully');
        }
        $error = array(
            'type' => 'validation_error',
            'title' => 'Password does not match our records'
        );
        return new JsonResponse($error, 404);
    }
    /**
     * @Route("/forgot_password/client/{permission_id}", name="event_client_forgot_password")
     */
    public function clientForgotPasswordAction($permission_id, Request $request)
    {
        //$permission_id = '6d19a0db-40c2-11e7-af1e-064c8710620c';
        $data = json_decode($request->getContent(), true);
        $request->request->replace($data);
        //$new_password = "4504542a389f43225fd133a14b98a70a";
        $passwordRequest = $this->getClientChangePassword($permission_id);
        if($passwordRequest!=null && $passwordRequest->getHasBeenUsed()==0)
        {
            $client = $this->getClient($passwordRequest->getClient());
            $client->setPassword($request->request->get('new_password'));
            $passwordRequest->setHasBeenUsed(1);
            $em = $this->getDoctrine()->getManager();
            $em->persist($passwordRequest);
            $em->persist($client);
            $em->flush();
            return new JsonResponse('The password has been changed successfully');
        }
        $error = array(
            'type' => 'validation_error',
            'title' => 'Password does not match our records'
        );
        return new JsonResponse($error, 404);
    }
    /**
     * @Route("/settings/change_password/client/", name="event_client_change_password")
     */
    public function clientChangePasswordAction(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $request->request->replace($data);
        $client = $this->getClient($request->request->get('client_id'));
        $current_password = $request->request->get('current_password');
        $new_password = $request->request->get('new_password');
        if($client->getPassword()==$current_password)
        {
            $client->setPassword($new_password);
            $em = $this->getDoctrine()->getManager();
            $em->persist($client);
            $em->flush();
            return new JsonResponse('The password has been updated successfully');
        }
        $error = array(
            'type' => 'validation_error',
            'title' => 'Password does not match our records'
        );
        return new JsonResponse($error, 404);
    }
    /**
     * @Route("/forgot_password", name="event_forgot_password")
     */
    public function userForgotPasswordAction(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $request->request->replace($data);
        $counselorEmail = $request->request->get('email');
        $counselor = $this->getCounselorByEmail($counselorEmail);
        if($counselor!=null)
        {
            $passwordRequest = new CounselorPasswordRequest();
            $passwordRequest->setCreationDate(new \DateTime('now'));
            $passwordRequest->setExpirationDate(new \DateTime('tomorrow'));
            $passwordRequest->setCounselor($counselor);
            $passwordRequest->setHasBeenUsed(0);
            $em = $this->getDoctrine()->getManager();
            $em->persist($passwordRequest);
            $em->flush();
            $link = 'business.uprm.edu/eshipcase/#!/forgot_password/counselor/'.$passwordRequest->getRequestId();
            $this->forgotPasswordEmail($link, $counselor->getCounselorEmail());
            return new JsonResponse('An email has been sent to your account. Please check your inbox');
        }
        elseif($counselor==null)
        {
            $client = $this->getClientByEmail($request->request->get('email'));
            if($client!=null)
            {
                $passwordRequest = new ClientPasswordRequest();
                $passwordRequest->setCreationDate(new \DateTime('now'));
                $passwordRequest->setExpirationDate(new \DateTime('tomorrow'));
                $passwordRequest->setClient($client);
                $passwordRequest->setHasBeenUsed(0);
                $em = $this->getDoctrine()->getManager();
                $em->persist($passwordRequest);
                $em->flush();
                $link = 'business.uprm.edu/eshipcase/#!/forgot_password/client/'.$passwordRequest->getRequestId();
                $this->forgotPasswordEmail($link, $client->getClientEmail());
                return new JsonResponse('An email has been sent to your account. Please check your inbox');
            }
        }
        $error = array(
            'type' => 'validation_error',
            'title' => 'Password does not match our records'
        );
        return new JsonResponse($error, 404);
    }
    //Email Method
    private function forgotPasswordEmail($link, $email)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject('Password Reset Request')
            ->setFrom('eship.test.email@gmail.com')
            ->setTo($email)
            ->setBody(
                $this->renderView(
                    'EventBundle:Email:user_forgot_password.html.twig',
                    array('link' => $link)
                ),
                'text/html'
            );
        $this->get('mailer')
            ->send($message);
        return $this->render('EventBundle:Email:user_forgot_password.html.twig',
            array('link' => $link));
    }
    //Helper Methods
    private function getCounselor($counselor_id)
    {
        $counselorRepository = $this->getDoctrine()
            ->getManager()
            ->getRepository('Eship\EventBundle\Entity\Counselor');
        return $counselorRepository->findOneBy(['counselorId' => $counselor_id]);
    }
    private function getClient($clientId)
    {
        $clientRepository = $this->getDoctrine()
            ->getManager()
            ->getRepository('Eship\EventBundle\Entity\Client');
        return $clientRepository->findOneBy(['clientId' => $clientId]);
    }
    private function getClientChangePassword($requestId)
    {
        $changePasswordRepository = $this->getDoctrine()
            ->getManager()
            ->getRepository('Eship\EventBundle\Entity\ClientPasswordRequest');
        return $changePasswordRepository->findOneBy(['requestId' => $requestId]);
    }
    private function getCounselorChangePassword($requestId)
    {
        $changePasswordRepository = $this->getDoctrine()
            ->getManager()
            ->getRepository('Eship\EventBundle\Entity\CounselorPasswordRequest');
        return $changePasswordRepository->findOneBy(['requestId' => $requestId]);
    }
    private function getCounselorByEmail($counselorEmail)
    {
        $counselorRepository = $this->getDoctrine()
            ->getManager()
            ->getRepository('Eship\EventBundle\Entity\Counselor');
        return $counselorRepository->findOneBy(['counselorEmail' => $counselorEmail]);
    }
    private function getClientByEmail($clientEmail)
    {
        $clientRepository = $this->getDoctrine()
            ->getManager()
            ->getRepository('Eship\EventBundle\Entity\Client');
        return $clientRepository->findOneBy(['clientEmail' => $clientEmail]);
    }
}
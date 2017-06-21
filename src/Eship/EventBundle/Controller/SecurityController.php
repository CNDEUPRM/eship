<?php
/**
 * Created by PhpStorm.
 * User: Francisco
 * Date: 3/26/2017
 * Time: 6:30 AM
 */
namespace Eship\EventBundle\Controller;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Eship\EventBundle\Entity\Client;
use Eship\EventBundle\Entity\Counselor;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
class SecurityController extends Controller
{
    /**
     * @Route("/login", name="event_client_login")
     */
    public function clientLoginAction(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $request->request->replace($data);
        $email = $request->request->get('email');
        $password = $request->request->get('password');
        $client = $this->getClient($email);
        if($client->getPassword()!=$password)
        {
            throw new EntityNotFoundException("Invalid Credentials");
        }
        $credentials = [
            'userId' => $client->getClientId(),
            'role' => $client->getRoles()
        ];
        return new JsonResponse($credentials);
    }
    /**
     * @Route("/login/counselor", name="event_counselor_login")
     */
    public function counselorLoginAction(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $request->request->replace($data);
        $email = $request->request->get('email');
        $password = $request->request->get('password');
        $counselor = $this->getCounselor($email);
        if($counselor->getPassword()!=$password)
        {
            throw new EntityNotFoundException("Invalid Credentials");
        }
        elseif ($counselor->getIsActive()==0)
        {
            throw new EntityNotFoundException("Your account is deactivated. Please contact the page admin.");
        }
        $credentials = [
            'userId' => $counselor->getCounselorId(),
            'role' => $counselor->getRoles()
        ];
        return new JsonResponse($credentials);
    }
    //Helper Methods
    private function getCounselor($counselorEmail)
    {
        $counselorRepository = $this->getDoctrine()
            ->getManager()
            ->getRepository('Eship\EventBundle\Entity\Counselor');
        return $counselorRepository->findOneBy(['counselorEmail' => $counselorEmail]);
    }
    private function getClient($clientEmail)
    {
        $clientRepository = $this->getDoctrine()
            ->getManager()
            ->getRepository('Eship\EventBundle\Entity\Client');
        return $clientRepository->findOneBy(['clientEmail' => $clientEmail]);
    }
}
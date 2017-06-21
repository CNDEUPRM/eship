<?php
/**
 * Created by PhpStorm.
 * User: Francisco
 * Date: 3/30/2017
 * Time: 12:41 AM
 */

namespace Eship\EventBundle\Controller;

use Eship\EventBundle\Entity\Counselor;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class CounselorController extends Controller
{
    /**
     * @Route("/counselor/", name="event_counselor_list")
     */
    public function listAction()
    {
        $counselorRepository = $this->getDoctrine()
            ->getManager()
            ->getRepository('EventBundle:Counselor');

        $counselors = $counselorRepository->getCounselorList();

        if ($counselors==null) {
            throw $this->createNotFoundException(
                'No businesses on the system'
            );
        }
        return new JsonResponse($counselors);
    }
    /**
     * @Route("/counselor/{$id}", name="event_counselor_profile")
     */
    public function showAction($id)
    {
        $counselorRepository = $this->getDoctrine()
            ->getManager()
            ->getRepository('EventBundle:Counselor');

        $counselor = $counselorRepository->getCounselor($id);

        if ($counselor==null) {
            throw $this->createNotFoundException(
                'There is not a Client with that ID on the system'
            );
        }
        return new JsonResponse($counselor);
    }

    /**
     * @Route("/counselor/{$id}/edit", name="event_edit_counselor")
     */
    public function editProfileAction($id, Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $request->request->replace($data);

        $counselorRepository = $this->getDoctrine()
            ->getManager()
            ->getRepository('EventBundle:Counselor');

        $counselor = $counselorRepository->getCounselor($id);

        if ($counselor==null)
        {
            throw $this->createNotFoundException(
                'There is not a Client with that ID on the system'
            );
        }
        //dump($counselor);

        $editedName = 'Dolph';
        $editedLastName = 'Ziggler';
        $editedEmail = 'dolph.ziggler@upr.edu';
        //$email = $counselor->getCounselorEmail();
        //$firstName = $counselor->getFirstName();
        //$lastName = $counselor->getLastName();
        $initial = $counselor->getInitial();
        $age = $counselor->getAge();
        $gender = $counselor->getGender();
        $phone = $counselor->getPhone();
        $position = $counselor->getPosition();
        $department = $counselor->getDepartment();
        $cndeOrganization = $counselor->getCndeOrganization();
        $courses = $counselor->getCourses();
        $isActive = $counselor->getIsActive();
        $isAdmin = $counselor->getIsAdmin();

        $editedCounselor = $counselor;

        //Updating Counselor
        $editedCounselor->setCounselorEmail($editedEmail);
        $editedCounselor->setFirstName($editedName);
        $editedCounselor->setLastName($editedLastName);
        $editedCounselor->setInitial($initial);
        $editedCounselor->setAge($age);
        $editedCounselor->setGender($gender);
        $editedCounselor->setPhone($phone);
        $editedCounselor->setPosition($position);
        $editedCounselor->setDepartment($department);
        $editedCounselor->setCndeOrganization($cndeOrganization);
        $editedCounselor->setCourses($courses);
        $editedCounselor->setIsActive($isActive);
        $editedCounselor->setIsAdmin($isAdmin);

        $em = $this->getDoctrine()->getManager();
        $em->persist($editedCounselor);
        $em->flush();

        dump($editedCounselor);

        return new JsonResponse($counselor);

    }

    /**
     * @Route("/counselor/{$id}/work_report", name="event_counselor_work_report")
     */

    public function getCounselorWorkReportAction($id)
    {
        $meetingReportRepository = $this->getDoctrine()
            ->getManager()
            ->getRepository('EventBundle:MeetingReport');

        $meetingReport = $meetingReportRepository->getCounselorReport($id);

        if ($meetingReport==null)
        {
            throw $this->createNotFoundException('There is not a meetingReport with that ID on the system');
        }

        return new JsonResponse($meetingReport);
    }
}
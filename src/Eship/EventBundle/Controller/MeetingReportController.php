<?php
/**
 * Created by PhpStorm.
 * User: Francisco
 * Date: 3/30/2017
 * Time: 12:32 AM
 */

namespace Eship\EventBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Eship\EventBundle\Entity\MeetingReport;
use Eship\EventBundle\Entity\Counselor;
use Eship\EventBundle\Entity\Business;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class MeetingReportController extends Controller
{
    /**
     * @Route("/meeting_report/{business_id}", name="event_meeting_report_list")
     */
    public function listAction($business_id)
    {
        $meetingReportRepository = $this->getDoctrine()
            ->getManager()
            ->getRepository('EventBundle:MeetingReport');

        $meetingReport = $meetingReportRepository->getMeetingReportList($business_id);

        if ($meetingReport==null)
        {
            throw $this->createNotFoundException('There is not a meetingReport with that ID on the system');
        }
        return new JsonResponse($meetingReport);
    }

    /**
     * @Route("/meeting_report/{business_id}/new_report", name="event_add_meeting_report")
     */
    public function addReportAction($business_id, Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $request->request->replace($data);

        $counselor = $this->getCounselor($request->request->get('counselor_id'));

        if($counselor->getIsActive()==0){
            $error = array(
                'type' => 'validation_error',
                'title' => 'This account is not active.'
            );

            return new JsonResponse($error, 404);
        }

        $business = $this->getBusiness($business_id);

        if($business->getIsActive()==0){
            $error = array(
                'type' => 'validation_error',
                'title' => 'This business is not active. Please activate this business before making any changes.'
            );

            return new JsonResponse($error, 404);
        }

        $date = new \DateTime($request->request->get('date'));
        $next_meeting = new \DateTime($request->request->get('next_meeting'));

        $report = new MeetingReport();
        $report->setDate($date);
        $report->setStageOfDevelopment($request->request->get('stage_of_development'));
        $report->setDiscussedIssues($request->request->get('discussed_issues'));
        $report->setSuggestionsAndAgreements($request->request->get('suggestions_and_agreements'));
        $report->setNumberOfEmployees($request->request->get('current_number_of_employees'));
        $business->setNumberOfEmployees($request->request->get('current_number_of_employees'));


        if($request->request->get('private_investing') == 0 || $request->request->get('private_investing')=='')
        {
            $report->setPrivateInvestment(0);
        }
        else
        {
            $report->setPrivateInvestment($request->request->get('private_investing'));
            $business->setPrivateInvestment($request->request->get('private_investing'));
        }

        if($request->request->get('public_investing') == 0 || $request->request->get('public_investing')=='')
        {
            $report->setPublicInvestment(0);
        }
        else
        {
            $report->setPublicInvestment($request->request->get('public_investing'));
            $business->setPublicInvestment($request->request->get('public_investing'));
        }

        $report->setMeetingDuration($request->request->get('meeting_duration'));
        $report->setDateNextMeeting($next_meeting);
        $report->setCounselorPendingMatters($request->request->get('counselor_pending_matters'));
        $report->setClientPendingMatters($request->request->get('client_pending_matters'));
        $report->setPdfDocument($request->request->get('business_plan'));
        $report->setHourNextMeeting($request->request->get('hour_next_meeting'));
        $report->setCounselor($counselor);
        $report->setBusiness($business);


        $business->setStageOfDevelopment($request->request->get('stage_of_development'));

        $total_hours = $business->getWorkedHours()+$request->request->get('meeting_duration');
        $business->setWorkedHours($total_hours);
        if($total_hours>=7)
        {
            $business->setIsProject(1);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($report);
        $em->persist($business);
        $em->flush();


        return new JsonResponse($report->getReportId());
    }

    /**
     * @Route("/meeting_report/{business_id}/{report_id}", name="event_view_meeting_report")
     */
    public function viewReportAction($business_id, $report_id)
    {
        $meetingReportRepository = $this->getDoctrine()
            ->getManager()
            ->getRepository('EventBundle:MeetingReport');

        $meetingReport = $meetingReportRepository->getMeetingReport($business_id, $report_id);

        if ($meetingReport==null)
        {
            throw $this->createNotFoundException('There is not a Meeting Report with that ID on the system');
        }
        return new JsonResponse($meetingReport);
    }

    //Helper Methods
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
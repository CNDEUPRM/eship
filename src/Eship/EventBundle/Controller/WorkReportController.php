<?php
/**
 * Created by PhpStorm.
 * User: Francisco
 * Date: 3/30/2017
 * Time: 12:48 AM
 */

namespace Eship\EventBundle\Controller;

use Eship\EventBundle\Entity\Business;
use Eship\EventBundle\Entity\MeetingReport;
use Eship\EventBundle\Entity\WorkReport;
use Eship\EventBundle\Entity\Counselor;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class WorkReportController extends Controller
{

    /**
     * @Route("/work_report/{business_id}/{meetingReport_id}", name="event_work_report_list")
     */
    public function listAction($business_id, $meetingReport_id)
    {
        $workReportRepository = $this->getDoctrine()
            ->getManager()
            ->getRepository('EventBundle:WorkReport');

        $workReport = $workReportRepository->getWorkReportList($business_id, $meetingReport_id);

        if ($workReport==null)
        {
            throw $this->createNotFoundException('There are no Work Report for that Meeting Report ID on the system');
        }
        return new JsonResponse($workReport);
    }

    /**
     * @Route("/work_report/{business_id}/{meetingReport_id}/{update_id}", name="event_view_work_report")
     */
    public function viewReportAction($business_id, $meetingReport_id, $update_id)
    {
        $workReportRepository = $this->getDoctrine()
            ->getManager()
            ->getRepository('EventBundle:WorkReport');

        $workReport = $workReportRepository->getWorkReport($business_id, $meetingReport_id, $update_id);

        if ($workReport==null)
        {
            throw $this->createNotFoundException('There is not a workReport with that ID on the system');
        }
        return new JsonResponse($workReport);
    }

    /**
     * @Route("/work_report/{business_id}/{report_id}/new_report", name="event_add_work_report")
     */
    public function addWorkReportAction($business_id, $meetingReport_id, Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $request->request->replace($data);

        $date = new \DateTime($request->request->get('date'));

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

        $meetingReport = $this->getMeetingReport($meetingReport_id);

        if($meetingReport==null){
            $error = array(
                'type' => 'validation_error',
                'title' => 'There is no Meeting Report with this ID. Please try again.'
            );

            return new JsonResponse($error, 404);
        }

        $report = new WorkReport();
        $report->setDate($date);
        $report->setNotes($request->request->get('notes'));
        $report->setWorkedHours($request->request->get('work_duration'));
        $report->setTaskCompleted($request->request->get('task_completed'));
        $report->setTaskInProgress($request->request->get('task_in_progress'));
        $report->setCounselor($counselor);
        $report->setBusiness($business);
        $report->setMeetingReport($meetingReport);

        $total_hours = $business->getWorkedHours()+$request->request->get('work_duration');
        $business->setWorkedHours($total_hours);
        if($total_hours>=7)
        {
            $business->setIsProject(1);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($report);
        $em->persist($business);
        $em->flush();

        return new JsonResponse($report->getUpdateId());
    }

    //Helper Methods
    private function getCounselor($counselor_id)
    {
        $counselorRepository = $this->getDoctrine()
            ->getManager()
            ->getRepository('Eship\EventBundle\Entity\Counselor');

        return $counselorRepository->findOneBy(['counselorId' => $counselor_id]);
    }

    private function getMeetingReport($report_id)
    {
        $meetingReportRepository = $this->getDoctrine()
            ->getManager()
            ->getRepository('Eship\EventBundle\Entity\MeetingReport');

        return $meetingReportRepository->findOneBy(['reportId' => $report_id]);
    }

    private function getBusiness($business_id)
    {
        $businessRepository = $this->getDoctrine()
            ->getManager()
            ->getRepository('Eship\EventBundle\Entity\Business');

        return $businessRepository->findOneBy(['business_id' => $business_id]);
    }
}

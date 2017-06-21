<?php
/**
 * Created by PhpStorm.
 * User: Francisco
 * Date: 4/10/2017
 * Time: 2:54 PM
 */

namespace Eship\EventBundle\Controller;

use Eship\EventBundle\Entity\Business;
use Eship\EventBundle\Entity\MeetingReport;
use Eship\EventBundle\Entity\WorkReport;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class StatisticReportController extends Controller
{
    /**
     * @Route("/statistics/date", name="event_general_statistics_date")
     */
    public function getGeneralStatisticByDateAction(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $request->request->replace($data);

        $start = new \DateTime($request->request->get('start'));
        $end = new \DateTime($request->request->get('end'));

        $meetingReportRepository = $this->getDoctrine()
            ->getManager()
            ->getRepository('EventBundle:MeetingReport');

        $meetingReport = $meetingReportRepository->getMeetingReportStatisticsByDate($start, $end);

        if ($meetingReport==null)
        {
            throw $this->createNotFoundException('There is not a meetingReport with that ID on the system');
        }

        $workReportRepository = $this->getDoctrine()
            ->getManager()
            ->getRepository('EventBundle:WorkReport');

        $workReport = $workReportRepository->getWorkReportStatisticsByDate($start, $end);

        if ($workReport==null)
        {
            throw $this->createNotFoundException('There is not a workReport with that ID on the system');
        }
        $businessRepository = $this->getDoctrine()
            ->getManager()
            ->getRepository('EventBundle:Business');

        $business = $businessRepository->countNewBusinessInInterval($start, $end);

        if ($business==null) {
            throw $this->createNotFoundException(
                'No businesses on the system'
            );
        }

        $statistics = [$meetingReport, $workReport, $business];

        return new JsonResponse($statistics);
    }

    /**
     * @Route("/statistics", name="event_general_statistics")
     */
    public function getGeneralStatisticAction()
    {
        $meetingReportRepository = $this->getDoctrine()
            ->getManager()
            ->getRepository('EventBundle:MeetingReport');

        $meetingReport = $meetingReportRepository->getMeetingReportStatistics();

        if ($meetingReport==null)
        {
            throw $this->createNotFoundException('There is not a meetingReport with that ID on the system');
        }

        $workReportRepository = $this->getDoctrine()
            ->getManager()
            ->getRepository('EventBundle:WorkReport');

        $workReport = $workReportRepository->getWorkReportStatistics();

        if ($workReport==null)
        {
            throw $this->createNotFoundException('There is not a workReport with that ID on the system');
        }
        $businessRepository = $this->getDoctrine()
            ->getManager()
            ->getRepository('EventBundle:Business');

        $business = $businessRepository->countBusiness();

        if ($business==null) {
            throw $this->createNotFoundException(
                'No businesses on the system'
            );
        }

        $statistics = [$meetingReport, $workReport, $business];

        return new JsonResponse($statistics);
    }

    /**
     * @Route("/statistics/{business_id}", name="event_business_statistics")
     */
    public function getSpecificBusinessAction($business_id)
    {
        $businessRepository = $this->getDoctrine()
            ->getManager()
            ->getRepository('EventBundle:Business');

        $business = $businessRepository->getBusinessStatistics($business_id);

        if ($business==null) {
            throw $this->createNotFoundException(
                'No businesses on the system'
            );
        }
        //dump($businesses);
        return new JsonResponse($business);
    }
}
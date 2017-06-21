<?php
/**
 * Created by PhpStorm.
 * User: Francisco
 * Date: 3/30/2017
 * Time: 12:57 AM
 */

namespace Eship\EventBundle\Controller;


use Eship\EventBundle\Entity\PerformanceReview;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class PerformanceReviewController extends Controller
{
    /**
     * @Route("/performance_review/summary", name="event_get_performance_review_summary")
     */
    public function getReviewSummaryAction()
    {
        $performanceReviewRepository = $this->getDoctrine()
            ->getManager()
            ->getRepository('EventBundle:PerformanceReview');

        $performanceReview = $performanceReviewRepository->getPerformanceReviewSummary();

        if ($performanceReview==null) {
            throw $this->createNotFoundException(
                'No performanceReview on the system'
            );
        }
        return new JsonResponse($performanceReview);
    }

    /**
     * @Route("/performance_review/new_review", name="event_new_performance_review")
     */
    public function createNewReviewAction(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $request->request->replace($data);

        $counselor = $this->getCounselor($request->request->get('counselor_id'));

        $review = new PerformanceReview();
        $review->setDate(new \DateTime('now'));
        $review->setClientEmail($request->request->get('email'));
        $review->setClientFirstName($request->request->get('first_name'));
        $review->setClientLastName($request->request->get('last_name'));
        $review->setSatisfactionLevel($request->request->get('rate_services'));
        $review->setComment($request->request->get('comment'));
        $review->setUsefulnessOfService($request->request->get('usefulness'));
        $review->setCity($request->request->get('city'));
        $review->setPhone($request->request->get('phone'));
        $review->setCounselor($counselor);

        $em = $this->getDoctrine()->getManager();
        $em->persist($review);
        $em->flush();

        return new JsonResponse('New Performance Review Added!');
    }

    private function getCounselor($counselor_id)
    {
        $counselorRepository = $this->getDoctrine()
            ->getManager()
            ->getRepository('Eship\EventBundle\Entity\Counselor');

        return $counselorRepository->findOneBy(['counselorId' => $counselor_id]);
    }
}
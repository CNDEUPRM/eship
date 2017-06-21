<?php

namespace Eship\EventBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="event_homepage")
     */
    public function homepageAction()
    {
        return $this->render('EventBundle:main:404.html.twig');
    }
}

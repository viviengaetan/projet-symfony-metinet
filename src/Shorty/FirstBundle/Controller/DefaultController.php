<?php

namespace Shorty\FirstBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('ShortyFirstBundle:Default:index.html.twig', array('name' => $name));
    }
}

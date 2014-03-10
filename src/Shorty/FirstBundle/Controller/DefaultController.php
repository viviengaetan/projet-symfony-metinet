<?php

namespace Shorty\FirstBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $view = 'ShortyFirstBundle:Default:index.html.twig';
        return $this->render($view);
    }
}

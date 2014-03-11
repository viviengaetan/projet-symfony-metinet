<?php

namespace Shorty\FirstBundle\Controller;

use Shorty\FirstBundle\Entity\ShortenedUrl;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use \Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render(
            'ShortyFirstBundle:Default:index.html.twig',
            array(
                "title" => "Accueil"
            )
        );
    }

    public function addAction(Request $request)
    {
        $shortUrl = new ShortenedUrl();

        $form = $this->createFormBuilder($shortUrl)
            ->add("lien", "text")
            ->add("slug","text")
            ->add("ok", "submit")
            ->getForm();

        $form->handleRequest($request);
        if(!$form->isValid()) {
            $shortUrl = null;
        }

        return $this->render(
            "ShortyFirstBundle:Default:editer.html.twig",
            array(
                "title" => "Ajout d'un Lien",
                "form" => $form->createView(),
                "lien" => $shortUrl
            )
        );
    }

}

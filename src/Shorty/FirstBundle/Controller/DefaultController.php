<?php

namespace Shorty\FirstBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use \Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $view = 'ShortyFirstBundle:Default:index.html.twig';
        return $this->render($view);
    }

    public function addAction(Request $request)
    {
        $form = $this->createFormBuilder()
            ->add("lien", "text")
            ->add("Créer", "submit")
            ->getForm();

        $form->handleRequest($request);
        if($form->isValid()) {
            $lien = $request->get("form")["lien"];
        } else {
            $lien = null;
        }

        return $this->render(
            "ShortyFirstBundle:Default:editer.html.twig",
            array(
                "title" => "Ajout d'un Lien",
                "form" => $form->createView(),
                "lien" => $lien
            )
        );
    }

}

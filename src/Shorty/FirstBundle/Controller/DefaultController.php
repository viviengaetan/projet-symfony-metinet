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
            ->add("slug", "text", array('required' => false))
            ->add("Enregistrer", "submit")
            ->getForm();

        $em = $this->getDoctrine()->getManager();
        $form->handleRequest($request);
        if ($form->isValid()) {
            /** Check if slug exist and is set **/
            $slugGenerator = $this->get("shorty_first.slug_generator");
            while ( strlen($shortUrl->getSlug()) == 0 && !$em->getRepository("ShortyFirstBundle:ShortenedUrl")->findOneBy(array("slug" => $shortUrl->getSlug())) ) {
                if($shortUrl->getSlug()) {
                    $shortUrl->setSlug($slugGenerator->generateSlug($shortUrl->getSlug()));
                } else {
                    $shortUrl->setSlug($slugGenerator->generateSlug($shortUrl->getLien()));
                }
            }
            /** Check if lien exist and is set **/
            $SUrl = $em->getRepository("ShortyFirstBundle:ShortenedUrl")->findOneBy(array("lien" => $shortUrl->getLien()));
            if (!$SUrl) {
                $em->persist($shortUrl);
                $em->flush();
            } else {
                $shortUrl = $SUrl;
            }
            /** To slug page **/
            return $this->render(
                "ShortyFirstBundle:Default:fiche.html.twig",
                array(
                    "title" => "Fiche d'un Lien",
                    "url" => $shortUrl
                ));
        } else {
            /** To create slug **/
            return $this->render(
                "ShortyFirstBundle:Default:editer.html.twig",
                array(
                    "title" => "Ajout d'un Lien",
                    "form" => $form->createView(),
                    "shorturl" => null
                )
            );
        }
    }

    public function listAction()
    {
        $urls = $this->getDoctrine()->getManager()->getRepository("ShortyFirstBundle:ShortenedUrl")->findAll();
        return $this->render(
            "ShortyFirstBundle:Default:list.html.twig",
            array(
                "title" => "Liste des Liens",
                "urls" => $urls
            )
        );
    }

    public function ficheAction($slug) {
        $url = $this->getDoctrine()->getManager()->getRepository("ShortyFirstBundle:ShortenedUrl")->findOneBy(array("slug"=>$slug));
        return $this->render(
            "ShortyFirstBundle:Default:fiche.html.twig",
            array(
                "title" => "Fiche d'un Lien",
                "url" => $url
            )
        );
    }

    public function redirectAction($slug) {
        $url = $this->getDoctrine()->getManager()->getRepository("ShortyFirstBundle:ShortenedUrl")->findOneBy(array("slug"=>$slug));
        if($url) {
            return $this->redirect($url->getLien());
        } else {
            return $this->redirect("shorty_homepage");
        }

    }

}

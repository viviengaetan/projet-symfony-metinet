<?php

namespace Shorty\FirstBundle\Controller;

use Shorty\FirstBundle\Entity\ClickUrl;
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
                "title" => $this->get('translator')->trans("title.home")
            )
        );
    }

    public function addAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $shortUrl = new ShortenedUrl();

        $form = $this->createFormBuilder($shortUrl)
            ->add("lien", "text", array('label' => $this->get('translator')->trans("global.lien")))
            ->add("slug", "text", array('required' => false, 'label' => $this->get('translator')->trans("global.slug")))
            ->add("Enregistrer", "submit", array('label' => $this->get('translator')->trans("global.save")))
            ->getForm();

        $form->handleRequest($request);
        if ($form->isValid()) {
            if ($this->testUrl($shortUrl->getLien())) {
                /** Check if slug exist and is set **/
                $slugGenerator = $this->get("shorty_first.slug_generator");
                while (strlen($shortUrl->getSlug()) == 0 || $em->getRepository("ShortyFirstBundle:ShortenedUrl")->findOneBy(array("slug" => $shortUrl->getSlug()))) {
                    if ($shortUrl->getSlug()) {
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
                return $this->redirect($this->generateUrl("shorty_fiche", array("slug" => $shortUrl->getSlug())));
            }
        }
        /** To create slug **/
        $listShortUrl = $em->getRepository("ShortyFirstBundle:ShortenedUrl")->findBy(array(), array("dateCreation" => "DESC"));
        return $this->render(
            "ShortyFirstBundle:Default:editer.html.twig",
            array(
                "title" => $this->get('translator')->trans("title.lien.add"),
                "form" => $form->createView(),
                "shorturl" => null,
                "listshorturl" => $listShortUrl
            )
        );

    }

    public function listAction()
    {
        $urls = $this->getDoctrine()->getManager()->getRepository("ShortyFirstBundle:ShortenedUrl")->findAll();
        return $this->render(
            "ShortyFirstBundle:Default:list.html.twig",
            array(
                "title" => $this->get('translator')->trans("title.lien.list"),
                "urls" => $urls
            )
        );
    }

    public function ficheAction($slug)
    {
        $url = $this->getDoctrine()->getManager()->getRepository("ShortyFirstBundle:ShortenedUrl")->findOneBy(array("slug" => $slug));
        return $this->render(
            "ShortyFirstBundle:Default:fiche.html.twig",
            array(
                "title" => $this->get('translator')->trans("title.lien.fiche"),
                "url" => $url
            )
        );
    }

    public function redirectAction(Request $request, $slug)
    {
        $url = $this->getDoctrine()->getManager()->getRepository("ShortyFirstBundle:ShortenedUrl")->findOneBy(array("slug" => $slug));

        if ($url) {
            $clickUrl = new ClickUrl();
            $clickUrl->setShortenedUrl($url);
            $clickUrl->setPrecedentUrl($request->headers->get("referer"));

            $this->getDoctrine()->getManager()->persist($clickUrl);
            $this->getDoctrine()->getManager()->flush();
            return $this->redirect($url->getLien());
        } else {
            return $this->redirect("shorty_homepage");
        }

    }


    private function testUrl($url)
    {
        $headers = @get_headers($url);
        if (strpos($headers[0], '200')) {
            return true;
        } else {
            return false;
        }
    }
}

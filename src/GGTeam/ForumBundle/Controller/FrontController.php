<?php

namespace GGTeam\ForumBundle\Controller;

use GGTeam\ForumBundle\Entity\Forum;
use GGTeam\ForumBundle\Entity\Message;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class FrontController extends Controller
{
    public function indexAction()
    {
        $listCategories = $this->get("gg_team_forum.category_manager")->getFirstLevel();
        return $this->render('GGTeamForumBundle:Front:index.html.twig', array("listCategories" => $listCategories));
    }

    public function categoryAction($idCategory)
    {
        $category = $this->getDoctrine()->getManager()->getRepository("GGTeamForumBundle:Category")->find($idCategory);
        return $this->render('GGTeamForumBundle:Front:category.html.twig', array("category" => $category));
    }

    public function addForumAction(Request $request, $idCategory)
    {
        $em = $this->getDoctrine()->getManager();
        $forum = new Forum();
        $category = $em->getRepository("GGTeamForumBundle:Category")->find($idCategory);
        $forum->setCategory($category);
        $forum->setAuthor($this->getUser());

        $form = $this->createFormBuilder($forum)
            ->add("name", "text", array("label" => "Nom", "required" => true))
            ->add("content", "textarea", array(
                "label" => "Nom",
                "attr" => array(
                    "class" => "tinymce",
                    "data-thme" => "bbcode"
                )
            ))
            ->add("Enregistrer", "submit", array("label" => "Enregistrer"))
            ->getForm();

        $form->handleRequest($request);
        if ($form->isValid()) {
            $em->persist($forum);
            $em->flush();
            return $this->redirect($this->generateUrl("gg_team_forum_category", array("idCategory" => $category->getId())));
        } else {
            return $this->render("GGTeamForumBundle:Front:addForum.html.twig", array(
                "form" => $form->createView(),
                "category" => $category
            ));
        }
    }

    public function forumAction(Request $request, $idForum)
    {
        $em = $this->getDoctrine()->getManager();
        $forum = $em->getRepository("GGTeamForumBundle:Forum")->find($idForum);

        $message = new Message();
        $message->setAuthor($this->getUser());
        $message->setForum($em->getRepository("GGTeamForumBundle:Forum")->find($idForum));

        $form = $this->createFormBuilder($message)
            ->add("content", "textarea", array(
                "label" => "Message",
                "attr" => array(
                    "class" => "tinymce",
                    "data-thme" => "bbcode"
                )
            ))
            ->add("Repondre", "submit", array("label" => "Répondre"))
            ->getForm();

        $form->handleRequest($request);
        if ($form->isValid()) {
            $em->persist($message);
            $em->flush();
            return $this->redirect($this->generateUrl("gg_team_forum_forum", array("idForum" => $idForum)));
        }

        return $this->render("GGTeamForumBundle:Front:forum.html.twig", array(
            "forum" => $forum,
            "category" => $forum->getCategory(),
            "form" => $form->createView()
        ));
    }

    public function addMessageAction(Request $request, $idForum)
    {
        $em = $this->getDoctrine()->getManager();
        $message = new Message();
        $message->setAuthor($this->getUser());
        $message->setForum($em->getRepository("GGTeamForumBundle:Forum")->find($idForum));

        $form = $this->createFormBuilder($message)
            ->add("content", "textarea", array(
                "label" => "Message",
                "attr" => array(
                    "class" => "tinymce",
                    "data-thme" => "bbcode"
                )
            ))
            ->add("Repondre", "submit", array("label" => "Répondre"))
            ->getForm();

        $form->handleRequest($request);
        if ($form->isValid()) {
            $em->persist($message);
            $em->flush();
            return $this->render($this->generateUrl("gg_team_forum_forum"), array("idForum" => $idForum));
        }
        return $this->render("GGTeamForumBundle:Front:addForum.html.twig", array(
            "form" => $form->createView()
        ));

    }
}

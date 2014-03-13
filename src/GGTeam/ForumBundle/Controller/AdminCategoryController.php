<?php
/**
 * Created by PhpStorm.
 * FileName: AdminCategoryController.php
 * User: GuGarcia
 * Date: 3/12/14
 * Time: 3:53 PM
 */

namespace GGTeam\ForumBundle\Controller;

use GGTeam\ForumBundle\Entity\Category;
use GGTeam\ForumBundle\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AdminCategoryController extends Controller
{

    public function indexAction()
    {
        return $this->redirect($this->generateUrl("gg_team_forum_admin_listecategories"));
    }

    public function listeCategoriesAction()
    {
        $listeCategory = $this->get("gg_team_forum.category_manager")->getFirstLevel();
        return $this->render("GGTeamForumBundle:Admin/Category:listecategories.html.twig", array(
            "categories" => $listeCategory
        ));
    }

    public function addCategoryAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $category = new Category();

        $form = $this->createFormBuilder($category)
            ->add("name", "text", array('label' => "Nom"))
            ->add("description", "text", array('required' => true, 'label' => "Description"))
            ->add("parent", "entity", array(
                "required" => false,
                "label" => "Catégorie Parent",
                "class" => "GGTeamForumBundle:Category",
                "property" => "name",
                'query_builder' => function (CategoryRepository $er) { return $er->getAllCategory(); },
            ))
            ->add("Enregistrer", "submit", array('label' => $this->get('translator')->trans("global.save")))
            ->getForm();

        $form->handleRequest($request);
        if ($form->isValid()) {
            $em->persist($category);
            $em->flush();
            return $this->redirect($this->generateUrl("gg_team_forum_admin_listecategories"));
        } else {
            return $this->render("GGTeamForumBundle:Admin/Category:addcategory.html.twig", array(
                "form" => $form->createView()
            ));
        }

    }

    public function updateCategoryAction(Request $request, $idcategory)
    {
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository("GGTeamForumBundle:Category")->find($idcategory);

        $form = $this->createFormBuilder($category)
            ->add("name", "text", array('label' => "Nom"))
            ->add("description", "text", array('required' => true, 'label' => "Description"))
            ->add("parent", "entity", array(
                "required" => false,
                "label" => "Catégorie Parent",
                "class" => "GGTeamForumBundle:Category",
                "property" => "name",
                'query_builder' => function (CategoryRepository $er) use ($category) { return $er->getParentPossible($category->getId()); },
            ))
            ->add("Enregistrer", "submit", array('label' => $this->get('translator')->trans("global.save")))
            ->getForm();

        $form->handleRequest($request);
        if ($form->isValid()) {
            $em->persist($category);
            $em->flush();
            return $this->redirect($this->generateUrl("gg_team_forum_admin_listecategories"));
        } else {
            return $this->render("GGTeamForumBundle:Admin/Category:addcategory.html.twig", array(
                "form" => $form->createView()
            ));
        }
    }

    public function removeCategoryAction()
    {

    }

}
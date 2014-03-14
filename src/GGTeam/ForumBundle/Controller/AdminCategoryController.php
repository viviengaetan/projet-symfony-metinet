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
use Symfony\Component\HttpFoundation\Response;

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
            ->add("description", "textarea", array(
                'label' => "Description",
                'attr' => array(
                    'class' => 'tinymce',
                    'data-theme' => 'bbcode'
                )
            ))
            ->add("Enregistrer", "submit", array('label' => $this->get('translator')->trans("global.save")))
            ->getForm();

        $form->handleRequest($request);
        if ($form->isValid()) {
            $this->get("gg_team_forum.category_manager")->setNewCategory($category);
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
            ->add("description", "textarea", array(
                'required' => true,
                'label' => "Description",
                'attr' => array(
                    'class' => 'tinymce',
                    'data-theme' => 'bbcode'
                )
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

    public function removeCategoryAction($idcategory)
    {
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository("GGTeamForumBundle:Category")->find($idcategory);
        if ($category->getCategories()->count() == 0) {
            $em->remove($category);
            $em->flush();
            return new Response(json_encode(array("success" => 1, "msg" => "la Catégorie a bien été supprimée.")));
        }
        return new Response(json_encode(array("success" => 0, "msg" => "Impossible de supprimer la Catégorie.")));
    }

    public function saveCategoriesAction(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $data = $request->get("data");
            $this->saveRecursive($data, null);
            return new Response(json_encode(array("success" => 1, "msg" => "Les Catégories ont bien été enregistrées.")));
        }
        return new Response(json_encode(array("success" => 0, "msg" => "Les Catégories n'ont pas pus être enregistrées.")));
    }

    private function saveRecursive($data, $parent)
    {
        $em = $this->getDoctrine()->getManager();
        $i = 1;
        foreach ($data as $value) {
            $category = $em->getRepository("GGTeamForumBundle:Category")->find($value["id"]);
            if ($category) {
                $category->setParent($parent);
                $category->setOrder($i);
                $em->persist($category);
                $em->flush();
                if (isset($value["children"])) {
                    $this->saveRecursive($value["children"], $category);
                }
                $i++;
            }
        }
    }


}
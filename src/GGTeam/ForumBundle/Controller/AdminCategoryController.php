<?php
/**
 * Created by PhpStorm.
 * FileName: AdminCategoryController.php
 * User: GuGarcia
 * Date: 3/12/14
 * Time: 3:53 PM
 */

namespace GGTeam\ForumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminCategoryController extends Controller{

    public function indexAction() {
        return $this->redirect($this->generateUrl("gg_team_forum_admin_listecategories"));
    }

    public function listeCategoriesAction() {
        $listeCategory = $this->getDoctrine()->getManager()->getRepository("GGTeamForumBundle:Category")->findAll();
        return $this->render("GGTeamForumBundle:Admin/Category:listecategories.html.twig", array(
            "categories" => $listeCategory
        ));
    }

    public function addCategoryAction() {

    }

    public function updateCategoryAction() {

    }

    public function removeCategoryAction() {

    }

} 
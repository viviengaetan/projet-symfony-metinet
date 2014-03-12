<?php
/**
 * Created by PhpStorm.
 * FileName: AdminUserController.php
 * User: GuGarcia
 * Date: 3/12/14
 * Time: 4:36 PM
 */

namespace GGTeam\ForumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminUserController extends Controller{

    public function indexAction() {
        return $this->redirect($this->generateUrl("gg_team_forum_admin_listeusers"));
    }

    public function listeUsersAction() {
        $listeCategory = $this->getDoctrine()->getManager()->getRepository("GGTeamForumBundle:Category")->findAll();
        return $this->render("GGTeamForumBundle:Admin/Category:listeusers.html.twig", array(
            "users" => $listeCategory
        ));
    }

    public function addUserAction() {

    }

    public function updateUserAction() {

    }

    public function removeUserAction() {

    }
} 
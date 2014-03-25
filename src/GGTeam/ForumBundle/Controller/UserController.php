<?php

namespace GGTeam\ForumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller {

    public function loginAction() {
        return $this->render("GGTeamForumBundle:User:login.html.twig");
    }

}
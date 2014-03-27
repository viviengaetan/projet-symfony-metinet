<?php

namespace GGTeam\BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller{

    public function indexAction() {
        return $this->redirect($this->generateUrl("gg_team_forum_back_listecategories"));
    }

} 
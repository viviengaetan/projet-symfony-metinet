<?php

namespace GGTeam\ForumBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class GGTeamForumBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}

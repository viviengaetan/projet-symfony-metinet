<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 3/13/14
 * Time: 8:58 AM
 */

namespace GGTeam\ForumBundle\Repository;


use Doctrine\ORM\EntityRepository;

class CategoryRepository extends EntityRepository{

    public function getFirstLevel()
    {
        return $this->_em->createQueryBuilder()
            ->select("c")
            ->from("GGTeamForumBundle:Category", "c")
            ->where("c.parent IS NULL")
            ->getQuery()
            ->getResult();
    }

    public function getAllCategory() {
        return $this->_em->createQueryBuilder()
            ->select("c")
            ->from("GGTeamForumBundle:Category", "c");
    }
} 
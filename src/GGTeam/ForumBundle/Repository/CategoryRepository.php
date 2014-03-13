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
            ->where("c.parent IS NULL");
    }

    public function getAllCategory()
    {
        return $this->_em->createQueryBuilder()
            ->select("c")
            ->from("GGTeamForumBundle:Category", "c");
    }

    public function getSubCategories($parentId)
    {
        return $this->_em->createQueryBuilder()
            ->select("c")
            ->from("GGTeamForumBundle:Category", "c")
            ->where("c.parent = :parentId")
            ->setParameter("parentId", $parentId);
    }
} 
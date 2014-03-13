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

    public function getParentPossible($id) {
        $allDeniedCategories = $this->getAllChild($id);
        $request = $this->_em->createQueryBuilder()
            ->select("c")
            ->from("GGTeamForumBundle:Category", "c")
            ->where("c.id != :id")
            ->orWhere("c.parent is null");
        foreach($allDeniedCategories as $cat) {
            $request->andWhere("c.id != :id".$cat->getId());
            $request->setParameter("id".$cat->getId(), $cat->getId());

        }
        $request->setParameter("id", $id);
        return $request;
    }

    private function getAllChild($id) {
        $categories = $this->getSubCategories($id)->getQuery()->getResult();
        $allcategories = $categories;
        foreach($categories as $category) {
            $retour = $this->getAllChild($category->getId());
            foreach($retour as $cat) {
                $allcategories[] = $cat;
            }
        }
        return $allcategories;
    }

} 
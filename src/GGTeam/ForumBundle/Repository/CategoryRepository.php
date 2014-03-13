<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 3/13/14
 * Time: 8:58 AM
 */

namespace GGTeam\ForumBundle\Repository;

use Doctrine\ORM\EntityRepository;
use GGTeam\ForumBundle\Entity\Category;

class CategoryRepository extends EntityRepository{

    public function getFirstLevel()
    {
        return $this->_em->createQueryBuilder()
            ->select("c")
            ->from("GGTeamForumBundle:Category", "c")
            ->where("c.parent IS NULL")
            ->orderBy("c.order","ASC");
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
            ->orderBy("c.order","ASC")
            ->setParameter("parentId", $parentId);
    }

    public function getParentPossible($id) {
        $allDeniedCategories = $this->getAllChild($id);
        $request = $this->_em->createQueryBuilder()
            ->select("c")
            ->from("GGTeamForumBundle:Category", "c")
            ->where("c.id != :id");
        foreach($allDeniedCategories as $cat) {
            $request->andWhere("c.id != :id".$cat->getId());
            $request->setParameter("id".$cat->getId(), $cat->getId());

        }
        $request
            ->orderBy("c.order","ASC")
            ->setParameter("id", $id);
        return $request;
    }

    private function getAllChild($id) {
        $categories = $this->getSubCategories($id)->getQuery()->getResult();
        $allCategories = $categories;
        foreach($categories as $category) {
            $return = $this->getAllChild($category->getId());
            foreach($return as $cat) {
                $allCategories[] = $cat;
            }
        }
        return $allCategories;
    }

    public function saveNewCategory(Category $category) {
        $catmaxorder = $this->_em->createQueryBuilder()
            ->select("c, MAX(c.order)")
            ->from("GGTeamForumBundle:Category", "c")
            ->where("c.parent = :id")
            ->setParameter("id", $category->getId())
            ->getQuery()
            ->getResult();
        var_dump($catmaxorder);
        if(!$catmaxorder[0][0]) { $catmaxorder = 0; }
        $category->setOrder($catmaxorder+1);
        $this->_em->persist($category);
        $this->_em->flush();
    }

} 
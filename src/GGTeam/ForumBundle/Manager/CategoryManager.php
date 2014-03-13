<?php

namespace GGTeam\ForumBundle\Manager;

use Doctrine\ORM\EntityManager;
use GGTeam\ForumBundle\Entity\Category;

class CategoryManager extends BaseManager{

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->repository = $em->getRepository("GGTeamForumBundle:Category");
    }

    public function getFirstLevel()
    {
        return $this->repository->getFirstLevel()->getQuery()->getResult();
    }

    public function getAllCategory()
    {
        return $this->repository->getAllCategory()->getQuery()->getResult();
    }

    public function getSubCategories($parentId)
    {
        return $this->repository->getSubCategories($parentId)->getQuery()->getResult();
    }

    public function setNewCategory(Category $category)
    {
        return $this->repository->saveNewCategory($category);
    }
} 
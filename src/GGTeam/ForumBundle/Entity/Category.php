<?php

namespace GGTeam\ForumBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Category
 * @package GGTeam\ForumBundle\Entity
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass="GGTeam\ForumBundle\Repository\CategoryRepository")
 */
class Category
{

    /****************************************
     * ATTRIBUTES
     ****************************************/

    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(name="id",type="integer",nullable=false)
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \String
     * @ORM\Column(name="name",type="text",nullable=false)
     */
    private $name;

    /**
     * @var \String
     * @ORM\Column(name="description",type="text",nullable=false)
     */
    private $description;

    /**
     * @var \GGTeam\ForumBundle\Entity\Category
     * @ORM\ManyToOne(targetEntity="GGTeam\ForumBundle\Entity\Category", inversedBy="categories")
     * @ORM\JoinColumns({
     *  @ORM\JoinColumn(name="parent", referencedColumnName="id", onDelete="CASCADE")
     * })
     */
    private $parent;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="GGTeam\ForumBundle\Entity\Category", mappedBy="parent")
     */
    private $categories;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="GGTeam\ForumBundle\Entity\Forum", mappedBy="category")
     */
    private $forums;

    /**
     * @var Integer
     * @ORM\Column(name="ordre",type="integer",nullable=false)
     */
    private $order;

    /****************************************
     * CONSTRUCTORS
     ****************************************/

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->forums = new ArrayCollection();
    }

    /****************************************
     * GETTERS AND SETTERS
     ****************************************/

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $categories
     */
    public function setCategories($categories)
    {
        $this->categories = $categories;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $forums
     */
    public function setForums($forums)
    {
        $this->forums = $forums;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getForums()
    {
        return $this->forums;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param String $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return String
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param \GGTeam\ForumBundle\Entity\Category $parent
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
    }

    /**
     * @return \GGTeam\ForumBundle\Entity\Category
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param mixed $order
     */
    public function setOrder($order)
    {
        $this->order = $order;
    }

    /**
     * @return mixed
     */
    public function getOrder()
    {
        return $this->order;
    }


    /****************************************
     * FUNCTIONS
     ****************************************/

} 
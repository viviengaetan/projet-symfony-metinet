<?php
/**
 * Created by PhpStorm.
 * User: Beber
 * Date: 11/03/14
 * Time: 19:35
 */

namespace GGTeam\ForumBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use \DateTime;

/**
 * Class Forum
 * @package GGTeam\ForumBundle\Entity
 * @ORM\Table(name="forum")
 * @ORM\Entity
 */
class Forum
{

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
     * @var
     * @ORM\Column(name="content",type="text",nullable=false)
     */
    private $content;

    /**
     * @var \GGTeam\ForumBundle\Entity\User
     * Pas de Delete en Cascade Pour ne pas perdre les Messages.
     * @ORM\ManyToOne(targetEntity="GGTeam\ForumBundle\Entity\User")
     * @ORM\JoinColumns({
     *  @ORM\JoinColumn(name="author", referencedColumnName="id")
     * })
     */
    private $author;

    /**
     * @var \DateTime
     * @ORM\Column(name="timeCreation",type="datetime",nullable=false)
     */
    private $timeCreation;

    /**
     * @var \DateTime
     * @ORM\Column(name="timeLastEdition",type="datetime",nullable=false)
     */
    private $timeLastEdition;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="GGTeam\ForumBundle\Entity\Message", mappedBy="forum")
     */
    private $messages;

    /**
     * @var \GGTeam\ForumBundle\Entity\Message
     * @ORM\OneToOne(targetEntity="GGTeam\ForumBundle\Entity\Message")
     * @ORM\JoinColumn(name="lastMessage", referencedColumnName="id", onDelete="CASCADE")
     */
    private $lastMessage;

    /**
     * @var \GGTeam\ForumBundle\Entity\Category
     * @ORM\ManyToOne(targetEntity="GGTeam\ForumBundle\Entity\Category", inversedBy="forums")
     * @ORM\JoinColumns({
     *  @ORM\JoinColumn(name="id_category", referencedColumnName="id", onDelete="CASCADE")
     * })
     */
    private $category;

    /****************************************
     * CONSTRUCTORS
     ****************************************/

    public function __construct()
    {
        $this->messages = new ArrayCollection();
        $this->timeCreation = new DateTime();
        $this->timeLastEdition = new DateTime();
    }

    /****************************************
     * GETTERS AND SETTERS
     ****************************************/

    /**
     * @param \GGTeam\ForumBundle\Entity\User $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

    /**
     * @return \GGTeam\ForumBundle\Entity\User
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
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
     * @param \GGTeam\ForumBundle\Entity\Message $lastMessage
     */
    public function setLastMessage($lastMessage)
    {
        $this->lastMessage = $lastMessage;
    }

    /**
     * @return \GGTeam\ForumBundle\Entity\Message
     */
    public function getLastMessage()
    {
        return $this->lastMessage;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $messages
     */
    public function setMessages($messages)
    {
        $this->messages = $messages;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getMessages()
    {
        return $this->messages;
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
     * @param \DateTime $timeCreation
     */
    public function setTimeCreation($timeCreation)
    {
        $this->timeCreation = $timeCreation;
    }

    /**
     * @return \DateTime
     */
    public function getTimeCreation()
    {
        return $this->timeCreation;
    }

    /**
     * @param \DateTime $timeLastEdition
     */
    public function setTimeLastEdition($timeLastEdition)
    {
        $this->timeLastEdition = $timeLastEdition;
    }

    /**
     * @return \DateTime
     */
    public function getTimeLastEdition()
    {
        return $this->timeLastEdition;
    }

    /****************************************
     * FUNCTIONS
     ****************************************/

} 
<?php
/**
 * Created by PhpStorm.
 * User: Beber
 * Date: 11/03/14
 * Time: 19:35
 */

namespace GGTeam\ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Class Message
 * @package GGTeam\ForumBundle\Entity
 * @ORM\Table(name="message")
 * @ORM\Entity
 */
class Message
{

    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(name="id",type="integer",nullable=false)
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var String
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
     * @var \GGTeam\ForumBundle\Entity\Forum
     * @ORM\ManyToOne(targetEntity="GGTeam\ForumBundle\Entity\Forum", inversedBy="messages")
     * @ORM\JoinColumns({
     *  @ORM\JoinColumn(name="id_forum", referencedColumnName="id", onDelete="CASCADE")
     * })
     */
    private $forum;

    /****************************************
     * CONSTRUCTORS
     ****************************************/

    public function __construct()
    {
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
     * @param String $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return String
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param \GGTeam\ForumBundle\Entity\Forum $forum
     */
    public function setForum($forum)
    {
        $this->forum = $forum;
    }

    /**
     * @return \GGTeam\ForumBundle\Entity\Forum
     */
    public function getForum()
    {
        return $this->forum;
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
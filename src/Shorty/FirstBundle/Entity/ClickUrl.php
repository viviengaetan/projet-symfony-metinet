<?php
/**
 * Created by PhpStorm.
 * FileName: ClickUrl.php
 * User: GuGarcia
 * Date: 3/12/14
 * Time: 11:39 AM
 */

namespace Shorty\FirstBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Class ClickUrl
 * @package Shorty\FirstBundle\Entity
 * @ORM\Table(name="clickurl")
 * @ORM\Entity
 */
class ClickUrl
{

    /****************************************
     * ATTRIBUTES
     ****************************************/

    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \DateTime
     * @ORM\Column(name="time", type="datetime", nullable=false)
     */
    private $time;

    /**
     * @var
     * @ORM\Column(name="precedenturl", type="text", nullable=true)
     */
    private $precedentUrl;

    /**
     * @var ShortenedUrl
     * @ORM\ManyToOne(targetEntity="Shorty\FirstBundle\Entity\ShortenedUrl", inversedBy="clicks")
     * @ORM\JoinColumns({
     *  @ORM\JoinColumn(name="id_shorturl", referencedColumnName="id", onDelete="CASCADE")
     * })
     */
    private $shortenedUrl;

    /****************************************
     * CONSTRUCTORS
     ****************************************/

    public function __construct() {
        $this->time = new \DateTime();
    }

    /****************************************
     * GETTERS AND SETTERS
     ****************************************/

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param \Shorty\FirstBundle\Entity\ShortenedUrl $shortenedUrl
     */
    public function setShortenedUrl($shortenedUrl)
    {
        $this->shortenedUrl = $shortenedUrl;
    }

    /**
     * @return \Shorty\FirstBundle\Entity\ShortenedUrl
     */
    public function getShortenedUrl()
    {
        return $this->shortenedUrl;
    }

    /**
     * @param mixed $time
     */
    public function setTime($time)
    {
        $this->time = $time;
    }

    /**
     * @return mixed
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @param mixed $precedentUrl
     */
    public function setPrecedentUrl($precedentUrl)
    {
        $this->precedentUrl = $precedentUrl;
    }

    /**
     * @return mixed
     */
    public function getPrecedentUrl()
    {
        return $this->precedentUrl;
    }

    /****************************************
     * FUNCTIONS
     ****************************************/

} 
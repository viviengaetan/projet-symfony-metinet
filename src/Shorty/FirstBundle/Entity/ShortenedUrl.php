<?php

namespace Shorty\FirstBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class ShortenedUrl
 * @package Shorty\FirstBundle\Entity
 * @ORM\Table(name="shorturl")
 * @ORM\Entity
 */
class ShortenedUrl {

    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(name="id",type="integer",nullable=false)
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * OriginURL
     * @var String
     * @ORM\Column(name="lien",type="text",nullable=false)
     * @Assert\NotBlank(message="Ne peut pas être Vide")
     * @Assert\Url(message="Cette Url n'est pas Valide")
     */
    private $lien;

    /**
     * ShortURL
     * @var String
     * @ORM\Column(name="slug",type="text",nullable=false,unique=true)
     */
    private $slug;

    /** GETTERS AND SETTERS**/

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
     * @param String $lien
     */
    public function setLien($lien)
    {
        $this->lien = $lien;
    }

    /**
     * @return String
     */
    public function getLien()
    {
        return $this->lien;
    }

    /**
     * @param String $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * @return String
     */
    public function getSlug()
    {
        return $this->slug;
    }






} 
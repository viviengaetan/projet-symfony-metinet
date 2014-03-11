<?php

namespace Shorty\FirstBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class ShortenedUrl {

    /**
     * @Assert\NotBlank(message="Ne peut pas être Vide")
     * @var String
     */
    private $lien;

    /**
     * @Assert\NotBlank(message="Ne peut pas être Vide")
     * @var String
     */
    private $slug;

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
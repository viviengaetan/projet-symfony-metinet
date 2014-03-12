<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 3/11/14
 * Time: 3:49 PM
 */

namespace Shorty\FirstBundle\Services;

class HashSlugGenerator implements SlugGeneratorInterface{

    private $sha1;

    /**
     * @param HashInterface $sha1
     */
    public function __construct(HashInterface $sha1) {
        $this->sha1 = $sha1;
    }

    /**
     * @param String $slug
     * @return string
     */
    public function generateSlug($slug)
    {
        return $this->sha1->hash($slug);
    }
}
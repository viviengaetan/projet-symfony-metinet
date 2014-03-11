<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 3/11/14
 * Time: 3:45 PM
 */

namespace Shorty\FirstBundle\Services;

class Sha1 {
    public function hash($slug) {
        return substr(sha1($slug),0,8);
    }
} 
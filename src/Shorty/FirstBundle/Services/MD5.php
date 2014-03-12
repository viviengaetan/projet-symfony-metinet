<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 3/12/14
 * Time: 11:19 AM
 */

namespace Shorty\FirstBundle\Services;


class MD5 implements HashInterface {

    public function hash($slug)
    {
        return substr(md5($slug),0,8);
    }
}
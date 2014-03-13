<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 3/13/14
 * Time: 9:47 AM
 */

namespace GGTeam\ForumBundle\Manager;

use Doctrine\ORM\EntityManager;

abstract class BaseManager {
    protected $em;
    protected $repository;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    protected function remove($entity)
    {
        $this->em->remove($entity);
        $this->em->flush();
    }

    /**
     * Save Entity in database
     * @param Entity $entity
     * @param bool $persist false when updating
     */
    protected function save($entity, $persist = true)
    {
        if (property_exists($entity, 'timeLastEdition')) {
            $entity->setTimeLastEdition(new \DateTime('now'));
        }
        if ($persist) {
            if (property_exists($entity, 'timeCreation')) {
                $entity->setTimeCreation(new \DateTime('now'));
            }
            $this->em->persist($entity);
        }
        $this->em->flush();
    }
} 
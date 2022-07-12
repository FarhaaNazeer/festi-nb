<?php

namespace App\Generator;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Id\AbstractIdGenerator;
use Symfony\Component\Uid\UuidV4;


/**
 * class UuidGenerator
 */
class UuidGenerator extends AbstractIdGenerator
{
    /**
     * @param EntityManager $em
     * @param $entity
     *
     * @return UuidV4
     */
    public function generate(EntityManager $em, $entity)
    {
      return new UuidV4();
    }
}
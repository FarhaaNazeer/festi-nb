<?php

namespace App\Assembler;

class AbstractAssembler
{
    /**
     * @param $entities
     */
    public function transformArray($entities): array
    {
        $objects = [];

        foreach ($entities as $entity) {
            $objects[] = $this->transform($entity);
        }

        return $objects;
    }
}
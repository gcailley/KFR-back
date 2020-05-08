<?php

namespace App\Entity;

interface  IRtlqEntity {

    public function getId();
    public function isInto($collections);
    public function isEquals(IRtlqEntity $entity);

}

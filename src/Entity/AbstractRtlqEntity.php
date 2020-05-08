<?php

namespace App\Entity;

abstract class AbstractRtlqEntity implements IRtlqEntity{

    abstract function getId();

    public function __construct()
    {
    }


    public function isInto($collections) {
        foreach ($collections as $key => $value) {
            if ($this->isEquals($value)) {
                return $value;
            }
        }
        return null;
    }

    public function isEquals(IRtlqEntity $entity) {
        if ($entity != null && $entity->getId() == $this->getId()) {
            return true;
        }
        return false;
    }

}

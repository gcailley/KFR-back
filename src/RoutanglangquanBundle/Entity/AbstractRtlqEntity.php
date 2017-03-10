<?php

namespace RoutanglangquanBundle\Entity;

abstract class AbstractRtlqEntity {

    abstract function getId();

    public function isInto($collections) {
        foreach ($collections as $key => $value) {
            if ($this->isEquals($value)) {
                return true;
            }
        }
        return false;
    }

    public function isEquals(AbstractRtlqEntity $entity) {
        if ($entity != null && $entity->getId() == $this->getId()) {
            return true;
        }
        return false;
    }

}

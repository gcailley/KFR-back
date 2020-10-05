<?php

namespace App\Form\Type\Kungfu;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use App\Form\Type\AbstractRtlqType;

class RtlqKungfuTaoReferentType extends AbstractRtlqType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nb_moves', NumberType::class);
    }

    public function getName()
    {
        return 'kungfu-tao-referent';
    }
}

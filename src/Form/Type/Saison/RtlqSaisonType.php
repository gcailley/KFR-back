<?php

namespace App\Form\Type\Saison;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

use App\Form\Type\AbstractRtlqType;

class RtlqSaisonType extends AbstractRtlqType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', NumberType::class)
            ->add('nom', TextType::class)
            ->add('active', CheckboxType::class)
            ->add('date_debut', DateType::class, $this->getDateFormatTZ())
            ->add('date_fin', DateType::class, $this->getDateFormatTZ())
            ->add('nb_adherents', NumberType::class);
    }
    public function getName()
    {
        return 'saison';
    }
}

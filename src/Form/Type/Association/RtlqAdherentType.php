<?php

namespace App\Form\Type\Association;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use App\Form\Type\AbstractRtlqType;

class RtlqAdherentType extends AbstractRtlqType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', NumberType::class)
            ->add('email', EmailType::class)
            ->add('username', TextType::class)
            ->add('pwd', PasswordType::class)
            ->add('telephone', TextType::class)
            ->add('nom', TextType::class)
            ->add('prenom', TextType::class)
            ->add('date_naissance', DateType::class, $this->getDateFormatTZ())
            ->add('actif', CheckBoxType::class)
            ->add('saison_courante', CheckBoxType::class)
            ->add('public', CheckBoxType::class)
            ->add('adresse', TextType::class)
            ->add('avatar', TextType::class)
            ->add('code_postal', TextType::class)
            ->add('ville', TextType::class)
            ->add('forum_uid', TextType::class)
            ->add('forum_username', TextType::class)
            ->add('date_creation', DateType::class, $this->getDateFormatTZ())
            ->add('date_last_auth', DateType::class, $this->getDateFormatTZ())
            ->add('licence_number', TextType::class)
            ->add('licence_etat', TextType::class)
            ->add('groupes', CollectionType::class, array('entry_type' => NumberType::class))
            ->add('cotisation_id', NumberType::class )
            ->add('tresories', CollectionType::class, array('entry_type' => NumberType::class))
            ->add('saisons', CollectionType::class, array('entry_type' => NumberType::class));
    }

    public function getName()
    {
        return 'Adherent';
    }
}

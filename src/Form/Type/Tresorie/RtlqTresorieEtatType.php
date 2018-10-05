<?php

namespace App\Form\Type\Tresorie;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use App\Form\Type\AbstractRtlqEnumType;

class RtlqTresorieEtatType extends AbstractRtlqEnumType {

	public function buildForm(FormBuilderInterface $builder, array $options)
    {
		parent::buildForm($builder, $options);
		$builder
			->add ( 'next_etat_name', TextType::class )
			->add ( 'next_etat_id', NumberType::class );
		dump($builder);
		return $builder;
    }

	public function getName() {
		return 'tresorie_etat';
	}
}
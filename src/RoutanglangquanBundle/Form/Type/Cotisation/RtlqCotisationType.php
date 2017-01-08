<?php

namespace RoutanglangquanBundle\Form\Type\Cotisation;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use RoutanglangquanBundle\Form\Type\AbstractRtlqType;


class RtlqCotisationType extends AbstractRtlqType {
	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder
                        ->add ( 'description', TextType::class )
                        ->add ( 'cotisation', MoneyType::class )
			->add ( 'repartitionCheque', TextType::class )
			->add ( 'active', CheckBoxType::class )
			->add ( 'saison_id', TextType::class )
			->add ( 'categorie_id', TextType::class );
	}
	public function getName() {
		return 'Cotisation';
	}
        
}
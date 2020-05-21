<?php

namespace App\Form\Type\Saison;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use App\Form\Type\AbstractRtlqType;


class RtlqCategorieVoteeType extends AbstractRtlqType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('id', NumberType::class)
			->add('montant', MoneyType::class)
			->add('saison_id', TextType::class)
			->add('categorie_id', TextType::class);
	}
	public function getName()
	{
		return 'categorievotee';
	}
}

<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class ExportStockType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$choice = array(
		        'Aucun' => '0',
		        'Pn' => 'pn',
		        'Désignation' => 'nom',
		        'Prix Ht (€)' => 'last_prix',
		        'Marge (%)' => 'marge',
		        'Quantité' => 'quantite',
		);

	    $builder->add('field1', ChoiceType::class, array(
	    	'label' => false, 
	        'choices'  => $choice,
	        'data' => 'pn'
	    ));
	    $builder->add('field2', ChoiceType::class, array(
	    	'label' => false, 
	        'choices'  => $choice,
	        'data' => 'nom'
	    ));
	    $builder->add('field3', ChoiceType::class, array(
	    	'label' => false, 
	        'choices'  => $choice,
	        'data' => 'last_prix'
	    ));
	    $builder->add('field4', ChoiceType::class, array(
	    	'label' => false, 
	        'choices'  => $choice,
	        'data' => 'marge'
	    ));
	    $builder->add('field5', ChoiceType::class, array(
	    	'label' => false, 
	        'choices'  => $choice,
	        'data' => 'quantite'
	    ));
	    $builder->add('export', SubmitType::class, array('label' => 'Exporter', 'attr' => array('class' => 'btn btn-primary action-save')));
	}

	public function configureOptions(OptionsResolver $resolver)
    {
        /*$resolver->setDefaults(array(
            'data_class' => 'App\Entity\DevisArticle',
        ));*/
    }
}
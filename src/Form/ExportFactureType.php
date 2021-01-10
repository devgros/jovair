<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class ExportFactureType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$current_year = date("Y");
		$current_month = date("m");
		$month_list = array("12" => "Décembre", "11" => "Novembre", "10" => "Octobre", "09" => "Septembre", "08" => "Août", "07" => "Juillet", "06" => "Juin", "05" => "Mai", "04" => "Avril", "03" => "Mars", "02" => "Février", "01" => "Janvier"
                );
		$yearArray = range($current_year, 2018);
		$choice = array();
		foreach ($yearArray as $year) {
	            foreach ($month_list as $key_month=>$month) {
	            	$choice_ok = false;
	            	if($year == $current_year){
	            		if($key_month <= $current_month){
	            			$choice_ok = true;
	            		}
	            	}else{
	            		$choice_ok = true;
	            	}

	            	if($choice_ok){
	            		$choice[$month." ".$year] = $key_month."-".$year;
	            	}
			    }
	    }
	    
	    $builder->add('month', ChoiceType::class, array(
	    	'label' => false, 
	        'choices'  => $choice,
	        'data' => '18-04'
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
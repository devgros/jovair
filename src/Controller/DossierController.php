<?php

namespace App\Controller;

use App\Controller\AdminController as MyAdminController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use EasyCorp\Bundle\EasyAdminBundle\Event\EasyAdminEvents;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use App\Entity\Mecanicien;
use App\Entity\Facture;

use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class DossierController extends MyAdminController
{
	protected function prePersistEntity($entity)
    {
    	$last_dossier =  $this->em->getRepository('App:Dossier')->getLastDossier();
        if(sizeof($last_dossier)>0){
        	$last_num = $last_dossier->getNumBl();
        	$last_num = substr($last_num, 9, 3);
        	$new_num = "JOVAIR-".date("y").str_pad(($last_num+1), 3, "0", STR_PAD_LEFT);
        }else{
            $new_num = "JOVAIR-".date("y")."001";
        }
    	$entity->setNumBl($new_num);
    	parent::prePersistEntity($entity);
    }

    protected function validateAction(){
    	$this->request->query->set("menuIndex", "1");
    	$id = $this->request->query->get('id');
    	$easyadmin = $this->request->attributes->get('easyadmin');
        $entity = $easyadmin['item'];
    	
    	$editForm = $this->createFormBuilder($entity)
            ->add('horametreAprs', IntegerType::class, array("label"=>"Horamètre APRS", 'attr' => ['min' => '0', 'value'=>'0']))
            ->add('remarqueAprs', TextType::class, array("label"=>"Remarques CRS"))
            ->add('isValidCtrlOk', CheckboxType::class, array('label'=> "Sous réserve de l’exécution satisfaisante du vol de contrôle", 'required' => false))
            ->add('dateCf', DateType::class, array("label"=>"Date du contrôle final", 'widget'=> 'single_text', 'attr' => ['value'=>date('Y-m-d')]))
            ->add('timeCf', TimeType::class, array("label"=>"Heure du contrôle final", 'input'  => 'string', 'widget'=> 'single_text', 'attr' => ['value'=>date('H:i')]))
            ->add('lieuCf', TextType::class, array("label"=>"Lieu du contrôle final"))
            
            ->add('carteTravailFile', VichFileType::class, [
            	"label"=>"Carte de travail",
	            'required' => false,
	            'allow_delete' => true, 
	            //'download_uri' => '...',
	            //'download_label' => '...',
	        ])
	        ->add('mecanicien', EntityType::class, array('class' => Mecanicien::class, 'attr' => ['data-widget' => 'select2']))
            ->add('save', SubmitType::class, array('label' => 'Cloturer le dossier', 'attr' => ['class'=>"btn btn-danger"]))
            ->getForm()
        ;

        $editForm->handleRequest($this->request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            

            $facture = new Facture();

            $last_facture =  $this->em->getRepository('App:Facture')->getLastFacture();
            if(sizeof($last_facture)>0){
                $last_num_facture = $last_facture[0]->getNumFacture();
                $last_num_facture = substr($last_num_facture, 2, 3);
                $new_num_facture = date("y").str_pad(($last_num_facture+1), 3, "0", STR_PAD_LEFT);
            }else{
                $new_num_facture = date("y")."001";
            }
            $facture->setNumFacture($new_num_facture);
            $facture->setStatut(1);
            $facture->setDossier($entity);
            $facture->setClient($entity->getAppareil()->getClient());
            $this->em->persist($facture);

            $entity->setStatut(1);
            $entity->setFacture($facture);

        	$this->em->flush();

            $this->container->get('knp_snappy.pdf')->generateFromHtml(
                $this->renderView(
                    'easy_admin/Dossier/pdf_cri.html.twig',
                    array('entity' => $entity)
                ),
                '%kernel.root_dir%/../dossier/'.$entity->getNumBl().'_CRI.pdf'
            );
            $this->container->get('knp_snappy.pdf')->generateFromHtml(
                $this->renderView(
                    'easy_admin/Dossier/pdf_crs.html.twig',
                    array('entity' => $entity)
                ),
                '%kernel.root_dir%/../dossier/'.$entity->getNumBl().'_CRS.pdf',
                array('orientation'=>'Landscape')
            );
            $this->container->get('knp_snappy.pdf')->generateFromHtml(
                $this->renderView(
                    'easy_admin/Dossier/pdf_aprs.html.twig',
                    array('entity' => $entity)
                ),
                '%kernel.root_dir%/../dossier/'.$entity->getNumBl().'_APRS.pdf'
            );

            $this->container->get('knp_snappy.pdf')->generateFromHtml(
                $this->renderView(
                    'easy_admin/Facture/pdf_facture.html.twig',
                    array('entity' => $facture)
                ),
                '%kernel.root_dir%/../facture/facture_'.$facture->getNumFacture().'.pdf'
            );

        	return $this->redirectToRoute('dossier_cri', ['entity' => 'Dossier', 'id' => $entity->getId()]);

        }


        $parameters = array(
            'form' => $editForm->createView(),
            'entity_fields' => array(),
            'entity' => $entity,
            'delete_form' => $editForm->createView(),
        );

        //return $this->executeDynamicMethod('render<EntityName>Template', array('validate', $this->entity['templates']['validate'], $parameters));
        return $this->render("easy_admin/Dossier/validate.html.twig", $parameters);
    }
}
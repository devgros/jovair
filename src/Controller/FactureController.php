<?php 

namespace App\Controller;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;

class FactureController extends BaseAdminController
{
	protected function showAction()
    {
        $response = parent::showAction();

        /*$facture = $this->request->attributes->get('easyadmin')['item'];

        if($facture->getNumFacture() == "F297-18-JOV'AIR" or $facture->getNumFacture() == "F296-18-JOV'AIR" or $facture->getNumFacture() == "F295-18-JOV'AIR"){
        
	        $path_pdf = $this->container->get('kernel')->getProjectDir().'/public/facture/facture_'.$facture->getNumFacture().'.pdf';

	        if(file_exists($path_pdf)){
				unlink($path_pdf);
			}

			$this->container->get('knp_snappy.pdf')->generateFromHtml(
					$this->renderView(
						'easy_admin/Facture/pdf_facture.html.twig',
						array('entity' => $facture)
					),
					$path_pdf
				);
		}*/
		

        return $response;
    }
}
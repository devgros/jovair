<?php 

namespace App\Controller;

use App\Controller\AdminController as MyAdminController;

class FactureController extends MyAdminController
{
    
	
	protected function showAction()
    {
        $response = parent::showAction();	

        $facture = $this->request->attributes->get('easyadmin')['item'];

        /*if($facture->getNumFacture() == "F076-19-JOV'AIR"){
        
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
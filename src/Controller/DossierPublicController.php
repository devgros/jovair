<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class DossierPublicController extends Controller
{
	/**
     * @Route(path = "/dossier/cri", name = "dossier_cri")
     */
    public function viewCriAction(Request $request)
    {
    	if (null !== $dossier_id = $request->get('id')) {
    		$dossier = $this->getDoctrine()->getManager()->getRepository('App:Dossier')->find($dossier_id);
    		if($dossier){
                
    			return $this->render('easy_admin/Dossier/view_cri.html.twig', array('entity' => $dossier));
    		}else{
    			return $this->redirectToRoute('admin', ['entity' => 'Dossier', 'action' => 'list']);
    		}
        }else{
        	return $this->redirectToRoute('admin', ['entity' => 'Dossier', 'action' => 'list']);
        }
    }

    /**
     * @Route(path = "/dossier/crs", name = "dossier_crs")
     */
    public function viewCrsAction(Request $request)
    {
    	if (null !== $dossier_id = $request->get('id')) {
    		$dossier = $this->getDoctrine()->getManager()->getRepository('App:Dossier')->find($dossier_id);
    		if($dossier){

    			return $this->render('easy_admin/Dossier/view_crs.html.twig', array('entity' => $dossier));
    		}else{
    			return $this->redirectToRoute('admin', ['entity' => 'Dossier', 'action' => 'list']);
    		}
        }else{
        	return $this->redirectToRoute('admin', ['entity' => 'Dossier', 'action' => 'list']);
        }
    }

    /**
     * @Route(path = "/dossier/aprs", name = "dossier_aprs")
     */
    public function viewAprsAction(Request $request)
    {
    	if (null !== $dossier_id = $request->get('id')) {
    		$dossier = $this->getDoctrine()->getManager()->getRepository('App:Dossier')->find($dossier_id);
    		if($dossier){

    			return $this->render('easy_admin/Dossier/view_aprs.html.twig', array('entity' => $dossier));
    		}else{
    			return $this->redirectToRoute('admin', ['entity' => 'Dossier', 'action' => 'list']);
    		}
        }else{
        	return $this->redirectToRoute('admin', ['entity' => 'Dossier', 'action' => 'list']);
        }
    }
}
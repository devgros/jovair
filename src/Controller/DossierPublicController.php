<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\URLGeneratorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

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
                $url = $this->generateUrl('dossier_qrcode', array('entity'=> 'Dossier', 'id'=> $dossier->getId()), URLGeneratorInterface::ABSOLUTE_URL);
    			return $this->render('easy_admin/Dossier/view_aprs.html.twig', array('entity' => $dossier, 'url'=> $url));
    		}else{
    			return $this->redirectToRoute('admin', ['entity' => 'Dossier', 'action' => 'list']);
    		}
        }else{
        	return $this->redirectToRoute('admin', ['entity' => 'Dossier', 'action' => 'list']);
        }
    }

    /**
     * @Route(path = "/dossier/qrcode", name = "dossier_qrcode")
     */
    public function viewQrcodeAction(Request $request)
    {
        if (null !== $dossier_id = $request->get('id')) {
            $dossier = $this->getDoctrine()->getManager()->getRepository('App:Dossier')->find($dossier_id);
            if($dossier){
                if($dossier->getStatut() > 0 && $dossier->getDossierFinal() != null){
                    $dossier_path = $this->container->get('kernel')->getProjectDir().'/public/dossier_final/'.$dossier->getNumBl().'.pdf';
                }else{
                    $dossier_path = $this->container->get('kernel')->getProjectDir().'/public/dossier/'.$dossier->getNumBl().'.pdf';
                }

                $response = new BinaryFileResponse($dossier_path);
                $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_INLINE, $dossier->getNumBl().'.pdf');
                return $response;
            }else{
                return $this->redirectToRoute('homepage');
            }
        }else{
            return $this->redirectToRoute('homepage');
        }
    }
}
<?php

namespace App\Controller;

use App\Controller\AdminController as MyAdminController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use EasyCorp\Bundle\EasyAdminBundle\Event\EasyAdminEvents;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ExportStockType;
use App\Entity\Article;

class ArticleController extends MyAdminController
{
    protected function createEditForm($entity, array $entityProperties)
    {
        $entity->setPrixHt($entity->getLastPrix()->getPrixHt());

        return parent::createEditForm($entity, $entityProperties);
    }

    protected function newAction()
    {
        $response = parent::newAction();
        $entity = $this->request->attributes->get('easyadmin')['item'];
        if ($response instanceof RedirectResponse) {
            return $this->redirectToRoute('admin', ['entity' => 'ArticleFormone', 'action' => 'new', 'article_id' => $entity->getId()]);
        }

        return $response;
    }

    public function addFormoneAction()
    {
    	$article_id = $this->request->query->get('id');
    	$referer = $this->request->query->get('referer');
    	if($referer != "")
    	{
	    	$referer = str_replace("list", "show", $referer);
	    	$referer .= "%26id%3D".$article_id;
	    }
    	return $this->redirectToRoute('easyadmin', array(
            'action' => 'new',
            'entity' => 'ArticleFormone',
            'article_id' => $article_id,
            'menuIndex' => 5,
            'referer' => $referer,
        ));
    }

    public function deletedAction()
    {
        $easyadmin = $this->request->attributes->get('easyadmin');
        $entity = $easyadmin['item'];
        $entity->setDeleted(1);
        $entity->setDeletedAt(new \DateTime());

        $this->em->flush();

        return $this->redirectToRoute('admin', ['entity' => 'Article', 'action' => 'list', 'menuIndex' => '6']);
    }

    public function undeletedAction()
    {
        $easyadmin = $this->request->attributes->get('easyadmin');
        $entity = $easyadmin['item'];
        $entity->setDeleted(0);
        $entity->setDeletedAt(null);
        $this->em->flush();

        return $this->redirectToRoute('admin', ['entity' => 'ArticleSuppr', 'action' => 'list', 'menuIndex' => '15']);
    }

    public function exportAction()
    {
        $form = $this->createForm(ExportStockType::class, array());
        $form->handleRequest($this->request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fields = $form->getData();
            $articles = $this->getDoctrine()->getRepository(Article::class)->findAll();

            $date = new \Datetime();
            //$path_pdf = $this->container->get('kernel')->getProjectDir().'/public/stock/export_'.$date->format("YmdHis").'.pdf';
            
            /*$this->container->get('knp_snappy.pdf')->generateFromHtml(
                $this->renderView(
                    'easy_admin/Article/pdf_export.html.twig',
                    array('entity' => $entity, 'fields' => $fields)
                ),
                $path_pdf
            );*/
            //$url = $this->request->getScheme().'://'.$this->request->getHttpHost().$this->request->getBasePath().'/public/devis/devis_'.$entity->getNumDevis().'.pdf';
            //return new RedirectResponse($url);
        }
        
        return $this->render('easy_admin/Article/export.html.twig', array('form' => $form->createView()));
    }
}
<?php

namespace App\Controller;

use App\Controller\AdminController as MyAdminController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use EasyCorp\Bundle\EasyAdminBundle\Event\EasyAdminEvents;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ExportStockType;
use App\Entity\Article;
use Symfony\Component\HttpFoundation\Response;


class ArticleController extends MyAdminController
{
    protected function createEditForm($entity, array $entityProperties)
    {
        $entity->setPrixHt($entity->getLastPrix()->getPrixHt());
        //$entity->setPrixHt($entity->getLastPrix()->getPrixHt());

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

            $filename = 'export_'.$date->format("YmdHis").'.pdf';
            $path_pdf = $this->container->get('kernel')->getProjectDir().'/public/stock/'.$filename;

            $content = $this->renderView('easy_admin/Article/pdf_export.html.twig',array('articles' => $articles, 'fields' => $fields, 'date_export' => $date));
            
            return new Response(
                $this->container->get('knp_snappy.pdf')->getOutputFromHtml($content),
                200,
                array(
                    'Content-Type'          => 'application/pdf',
                    'Content-Disposition'   => 'attachment; filename="'.$filename
                )
            );
            
        }
        
        return $this->render('easy_admin/Article/export.html.twig', array('form' => $form->createView()));
    }
}
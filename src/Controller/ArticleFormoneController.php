<?php

namespace App\Controller;

use App\Controller\AdminController as MyAdminController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use EasyCorp\Bundle\EasyAdminBundle\Event\EasyAdminEvents;

class ArticleFormoneController extends MyAdminController
{
    protected function prePersistEntity($entity)
    {
        if (null !== $article_id = $this->request->query->get('article_id')) {
            $article =  $this->em->getRepository('App:Article')->find($article_id);
            $entity->setArticle($article);
        }
        parent::prePersistEntity($entity);
    }

    protected function newAction()
    {
        $response = parent::newAction();
        $entity = $this->request->attributes->get('easyadmin')['item'];
        if ($response instanceof RedirectResponse) {
            return $this->redirectToRoute('admin', ['entity' => 'Article', 'action' => 'show', 'id' => $entity->getArticle()->getId()]);
        }

        return $response;
    }

    protected function editAction()
    {
        $response = parent::editAction();
        $entity = $this->request->attributes->get('easyadmin')['item'];
        if ($response instanceof RedirectResponse) {
            return $this->redirectToRoute('admin', ['entity' => 'Article', 'action' => 'show', 'id' => $entity->getArticle()->getId()]);
        }

        return $response;
    }

    protected function deleteAction()
    {
        $response = parent::deleteAction();

        $entity = $this->request->attributes->get('easyadmin')['item'];
        if ($response instanceof RedirectResponse) {
            return $this->redirectToRoute('admin', ['entity' => 'Article', 'action' => 'show', 'id' => $entity->getArticle()->getId()]);
        }

        return $response;
    }

    protected function listAction()
    {
        $response = parent::deleteAction();

        if ($response instanceof RedirectResponse) {
            return $this->redirectToRoute('admin', ['entity' => 'Article', 'action' => 'list']);
        }

        return $response;
    }
}
<?php
namespace App\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use app\entity\Alerte;
use app\entity\Article;
use app\entity\ArticlePrix;
use app\entity\ArticleMarge;
use app\entity\MainOeuvre;
use app\entity\MainOeuvrePrix;
use app\entity\Outillage;
use app\entity\OutillagePrix;
use app\entity\DossierArticle;
use app\entity\DevisArticle;
use app\entity\ArticleFormone;
use app\entity\OutillageCertificat;

class EasyAdminSubscriber implements EventSubscriberInterface
{

    public static function getSubscribedEvents()
    {
        return array(
            'easy_admin.post_persist' => array(array('addArticlePrix'), array('addArticleMarge'), array('addMainOeuvrePrix'), array('addOutillagePrix'), array('newQteArticle'), array('newOutillageCertificat')),
            'easy_admin.post_update' => array(array('addArticlePrix'), array('addArticleMarge'), array('addMainOeuvrePrix'), array('addOutillagePrix')),
            'easy_admin.pre_edit' => array(array('storeQteArticle'), array('addFirstArticleMarge')),
            'easy_admin.pre_update' => array(array('updateQteArticle')),
            'easy_admin.pre_remove' => array(array('restockQteArticle'), array('removeCompressiometre')),
        );
    }

    public function addArticlePrix(GenericEvent $event)
    {
        $entity = $event->getSubject();
        if ($entity instanceof Article) {
            $create_articleprix = false;
            if($entity->getLastPrix())
            {
                if($entity->getPrixHt() != $entity->getLastPrix()->getPrixHt()) $create_articleprix = true;
            }else{
                $create_articleprix = true;
            }
            if($create_articleprix)
            {
                $article_prix = new ArticlePrix();
                $article_prix->setPrixHt($entity->getPrixHt());
                $article_prix->setArticle($entity);
                $event['em']->persist($article_prix);
                $event['em']->flush($article_prix);
            }
        }
    }

    public function addFirstArticleMarge(GenericEvent $event)
    {
        $entity = $event->getSubject();
        if($entity['name'] == "Article")
        {
            $old_article = $event['em']->getRepository(Article::class, 'default')->find($event['request']->get('id'));
            if($old_article->getArticleMarge()->isEmpty())
            {
                $article_marge = new ArticleMarge();
                $article_marge->setMarge($old_article->getMarge());
                $article_marge->setArticle($old_article);
                $event['em']->persist($article_marge);
                $article_marge->setDateChange(new \Datetime('2018-01-01'));
                $event['em']->persist($article_marge);
                $event['em']->flush($article_marge);
            }
        }
    }

    public function addArticleMarge(GenericEvent $event)
    {
        $entity = $event->getSubject();
        if ($entity instanceof Article) {
            $create_articlemarge = false;
            if($entity->getArticleMarge()->isEmpty())
            {
                $create_articlemarge = true;
            }else{
                if($entity->getMarge() != $entity->getLastMarge()->getMarge()) $create_articlemarge = true;
            }
            if($create_articlemarge)
            {
                $article_marge = new ArticleMarge();
                $article_marge->setMarge($entity->getMarge());
                $article_marge->setArticle($entity);
                $event['em']->persist($article_marge);
                $event['em']->flush($article_marge);
            }
        }
    }

    public function addMainOeuvrePrix(GenericEvent $event)
    {
        $entity = $event->getSubject();
        if ($entity instanceof MainOeuvre) {
            $create_prix = false;
            if($entity->getLastPrix())
            {
                if($entity->getPrixHt() != $entity->getLastPrix()->getPrixHt()) $create_prix = true;
            }else{
                $create_prix = true;
            }
            if($create_prix)
            {
                $main_oeuvre_prix = new MainOeuvrePrix();
                $main_oeuvre_prix->setPrixHt($entity->getPrixHt());
                $main_oeuvre_prix->setMainOeuvre($entity);
                $event['em']->persist($main_oeuvre_prix);
                $event['em']->flush($main_oeuvre_prix);
            }
        }
    }

    public function addOutillagePrix(GenericEvent $event)
    {
        $entity = $event->getSubject();
        if ($entity instanceof Outillage) {
            $create_outillageprix = false;
            if($entity->getLastPrix())
            {
                if($entity->getPrixHt() != $entity->getLastPrix()->getPrixHt()) $create_outillageprix = true;
            }else{
                $create_outillageprix = true;
            }
            if($create_outillageprix)
            {
                $outillage_prix = new OutillagePrix();
                $outillage_prix->setPrixHt($entity->getPrixHt());
                $outillage_prix->setOutillage($entity);
                $event['em']->persist($outillage_prix);
                $event['em']->flush($outillage_prix);
            }
        }
    }

    public function newQteArticle(GenericEvent $event)
    {
        $entity = $event->getSubject();
        if ($entity instanceof DossierArticle or $entity instanceof DevisArticle) {
            $qte_stock = $entity->getArticleFormone()->getQuantite();
            $qte_utilise = $entity->getQuantite();

            $new_qte_stock = $qte_stock - $qte_utilise;
            $entity->getArticleFormone()->setQuantite($new_qte_stock);
            $event['em']->persist($entity->getArticleFormone());
            $event['em']->flush($entity->getArticleFormone());

            $this->seuilAlerte($event['em'], $new_qte_stock, $entity->getArticleFormone()->getArticle()->getSeuilAlert(), $entity->getArticleFormone()->getArticle()->getId(), $entity->getArticleFormone()->getArticle()->getNom(), $entity->getArticleFormone()->getArticle()->getPn());
        }
    }

    public function newOutillageCertificat(GenericEvent $event)
    {
        $entity = $event->getSubject();
        if ($entity instanceof OutillageCertificat ) {
            $current_date = new \DateTime();
            $alerte_bdd = $event['em']->getRepository('App:Alerte')->findBy(array('type' => '1', 'id_entity' => $entity->getOutillage()->getId()));
            if($alerte_bdd != null){
                $last_date_certificat = $entity->getOutillage()->getLastDateCertificat()->getDateValidite();
                $last_date_certificat_at_one_month = $last_date_certificat->modify('-1 month');
                if($last_date_certificat_at_one_month > $current_date) {
                    $event['em']->remove($alerte_bdd[0]);
                    $event['em']->flush();  
                }
            }
        }
    }

    public function storeQteArticle(GenericEvent $event)
    {
        $entity = $event->getSubject();
        if($entity['name'] == "DossierArticle")
        {
            $old_qte_dossier_article = $event['em']->getRepository(DossierArticle::class, 'default')->findOldQte($event['request']->get('id'));
            $session = new Session();
            $session->set('old_qte_dossier_article', $old_qte_dossier_article->getQuantite());
        }
        if($entity['name'] == "DevisArticle")
        {
            $old_qte_dossier_article = $event['em']->getRepository(DevisArticle::class, 'default')->findOldQte($event['request']->get('id'));
            $session = new Session();
            $session->set('old_qte_dossier_article', $old_qte_dossier_article->getQuantite());
        }
    }

    public function updateQteArticle(GenericEvent $event)
    {
        $entity = $event->getSubject();
        if ($entity instanceof DossierArticle or $entity instanceof DevisArticle) {
            $session = new Session();
            $old_qte_dossier_article = $session->get('old_qte_dossier_article');

            $qte_stock = $entity->getArticleFormone()->getQuantite();
            $qte_utilise = $entity->getQuantite();

            if($qte_utilise == $old_qte_dossier_article){
                $new_qte_stock = $qte_stock;
            }elseif($qte_utilise > $old_qte_dossier_article){
                $new_qte_stock = $qte_stock - ($qte_utilise-$old_qte_dossier_article);
            }else{
                $new_qte_stock = $qte_stock + ($old_qte_dossier_article-$qte_utilise);
            }

            $entity->getArticleFormone()->setQuantite($new_qte_stock);

            $event['em']->persist($entity->getArticleFormone());
            $event['em']->flush($entity->getArticleFormone());
            $session->remove('old_qte_dossier_article');

            $this->seuilAlerte($event['em'], $new_qte_stock, $entity->getArticleFormone()->getArticle()->getSeuilAlert(), $entity->getArticleFormone()->getArticle()->getId(), $entity->getArticleFormone()->getArticle()->getNom(), $entity->getArticleFormone()->getArticle()->getPn());
        }
        
        if($entity instanceof ArticleFormone){
            $this->seuilAlerte($event['em'], $entity->getQuantite(), $entity->getArticle()->getSeuilAlert(), $entity->getArticle()->getId(), $entity->getArticle()->getNom(), $entity->getArticle()->getPn());
        }
    }

    public function restockQteArticle(GenericEvent $event)
    {
        $entity = $event->getSubject();
        if ($entity instanceof DossierArticle or $entity instanceof DevisArticle) {

            $qte_to_restock = $entity->getQuantite();
            $qte_stock = $entity->getArticleFormone()->getQuantite();
            $new_qte_stock = $qte_stock + $qte_to_restock;
            $entity->getArticleFormone()->setQuantite($new_qte_stock);
            $event['em']->persist($entity->getArticleFormone());
            $event['em']->flush($entity->getArticleFormone());

            $this->seuilAlerte($event['em'], $new_qte_stock, $entity->getArticleFormone()->getArticle()->getSeuilAlert(), $entity->getArticleFormone()->getArticle()->getId(), $entity->getArticleFormone()->getArticle()->getNom(), $entity->getArticleFormone()->getArticle()->getPn());
        }
    }

    public function seuilAlerte($em, $qte, $seuil_alerte, $article_id, $article_name, $article_pn){
        $alerte_bdd = $em->getRepository('App:Alerte')->findBy(array('name_entity' => 'Article', 'id_entity' => $article_id));
        if($qte <= $seuil_alerte && $alerte_bdd == null){
            $alerte = new Alerte();
            $alerte->setType(0);
            $alerte->setIdEntity($article_id);
            $alerte->setNameEntity("Article");
            $alerte->setDesignation($article_name." (pn: ".$article_pn.") - Moins de ".$seuil_alerte." éléments");
            $em->persist($alerte);
            $em->flush($alerte);
        }

        if($qte > $seuil_alerte && $alerte_bdd != null){
            $em->remove($alerte_bdd[0]);
            $em->flush();  
        }


        
    }

    public function removeCompressiometre(GenericEvent $event)
    {
        /*$entity = $event->getSubject();
        dump($entity);
        exit(0);*/
        /*if ($entity instanceof DossierArticle or $entity instanceof DevisArticle) {

            $qte_to_restock = $entity->getQuantite();
            $qte_stock = $entity->getArticleFormone()->getQuantite();
            $new_qte_stock = $qte_stock + $qte_to_restock;
            $entity->getArticleFormone()->setQuantite($new_qte_stock);
            $event['em']->persist($entity->getArticleFormone());
            $event['em']->flush($entity->getArticleFormone());

            $this->seuilAlerte($event['em'], $new_qte_stock, $entity->getArticleFormone()->getArticle()->getSeuilAlert(), $entity->getArticleFormone()->getArticle()->getId(), $entity->getArticleFormone()->getArticle()->getNom(), $entity->getArticleFormone()->getArticle()->getPn());
        }*/
    }
}
<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 */
class Article
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pn;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="decimal", scale=2)
     * @Assert\GreaterThanOrEqual(0)
     */
    private $marge;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\GreaterThanOrEqual(0)
     */
    private $seuil_alert;

    /**
     * @ORM\Column(type="integer")
     * @Assert\GreaterThanOrEqual(0)
     */
    private $deleted = 0;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var \DateTime
     */
    private $deletedAt;

    /**
     * @ORM\OneToMany(targetEntity="ArticlePrix", mappedBy="article", cascade={"ALL"}, indexBy="date_change")
     * @ORM\OrderBy({"date_change" = "DESC"})
     */
    private $article_prix;

    /**
     * @ORM\OneToMany(targetEntity="ArticleFormone", mappedBy="article", cascade={"ALL"}, indexBy="id")
     */
    private $article_formone;

    /**
     * @Assert\NotBlank()
     * @Assert\GreaterThanOrEqual(0)
     */
    private $prix_ht;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ArticleMarge", mappedBy="article", cascade={"ALL"}, indexBy="date_change")
     * @ORM\OrderBy({"date_change" = "DESC"})
     */
    private $article_marge;

    public function __toString()
    {
        return $this->nom;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->article_prix = new \Doctrine\Common\Collections\ArrayCollection();
        $this->article_formone = new \Doctrine\Common\Collections\ArrayCollection();
        $this->article_marge = new ArrayCollection();
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set sn.
     *
     * @param string $sn
     *
     * @return Article
     */
    public function setPn($pn)
    {
        $this->pn = $pn;

        return $this;
    }

    /**
     * Get sn.
     *
     * @return string
     */
    public function getPn()
    {
        return $this->pn;
    }

    /**
     * Set nom.
     *
     * @param string $nom
     *
     * @return Article
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom.
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set marge.
     *
     * @param string $marge
     *
     * @return Article
     */
    public function setMarge($marge)
    {
        $this->marge = $marge;

        return $this;
    }

    /**
     * Get marge.
     *
     * @return string
     */
    public function getMarge()
    {
        return $this->marge;
    }

    public function getLastMarge(){
        if($this->article_marge->isEmpty()){
            return $this->marge; 
        }else{
            return $this->article_marge->first(); 
        }
    }

    public function getPeriodeMarge($date){
        if($this->article_marge->isEmpty()){
            return $this->marge; 
        }else{
            $marge = null;
            foreach($this->article_marge as $article_marge){
                if($article_marge->getDateChange() < $date){
                    $marge = $article_marge->getMarge();
                    break;
                }
            }
            if($marge == null){
                $article_marge = $this->article_marge->last();
                $marge = $article_marge->getMarge();
            }
            
            return $marge;
        }
    }

    /**
     * Add articlePrix.
     *
     * @param \App\Entity\ArticlePrix $articlePrix
     *
     * @return Article
     */
    public function addArticlePrix(\App\Entity\ArticlePrix $articlePrix)
    {
        $this->article_prix[] = $articlePrix;

        return $this;
    }

    /**
     * Remove articlePrix.
     *
     * @param \App\Entity\ArticlePrix $articlePrix
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeArticlePrix(\App\Entity\ArticlePrix $articlePrix)
    {
        return $this->article_prix->removeElement($articlePrix);
    }

    /**
     * Get articlePrix.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getArticlePrix()
    {
        return $this->article_prix;
    }

    /**
     * Set prixHt.
     *
     * @param string $prixHt
     *
     * @return ArticlePrix
     */
    public function setPrixHt($prixHt)
    {
        $this->prix_ht = $prixHt;

        return $this;
    }

    /**
     * Get prixHt.
     *
     * @return string
     */
    public function getPrixHt()
    {
        return $this->prix_ht;
    }

    public function getLastPrix(){
    	return $this->article_prix->first();
    }

    public function getPeriodePrix($date){
        $prix_ht = 0;
        foreach($this->article_prix as $article_prix){
            if($article_prix->getDateChange() < $date){
                $prix_ht = $article_prix->getPrixHT();
                break;
            }
        }
        if($prix_ht == 0){
            $article_prix = $this->article_prix->last();
            $prix_ht = $article_prix->getPrixHT();
        }
        
        return $prix_ht;
    }

    /**
     * Set seuilAlert.
     *
     * @param int $seuilAlert
     *
     * @return Article
     */
    public function setSeuilAlert($seuilAlert)
    {
        $this->seuil_alert = $seuilAlert;

        return $this;
    }

    /**
     * Get seuilAlert.
     *
     * @return int
     */
    public function getSeuilAlert()
    {
        return $this->seuil_alert;
    }

    /**
     * Add articleFormone.
     *
     * @param \App\Entity\ArticleFormone $articleFormone
     *
     * @return Article
     */
    public function addArticleFormone(\App\Entity\ArticleFormone $articleFormone)
    {
        $this->article_formone[] = $articleFormone;

        return $this;
    }

    /**
     * Remove articleFormone.
     *
     * @param \App\Entity\ArticleFormone $articleFormone
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeArticleFormone(\App\Entity\ArticleFormone $articleFormone)
    {
        return $this->article_formone->removeElement($articleFormone);
    }

    /**
     * Get articleFormone.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getArticleFormone()
    {
        return $this->article_formone;
    }

    public function getquantite()
    {
        $list_formone = $this->article_formone;
        $qte = 0;
        foreach($list_formone as $key=>$formone)
        {
            $qte += $formone->getQuantite();
        }
        return $qte;
    }


    /**
     * Set deleted.
     *
     * @param int $deleted
     *
     * @return Article
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * Get deleted.
     *
     * @return int
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * Set deletedAt.
     *
     * @param \DateTime $deletedAt
     *
     * @return Article
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * Get deletedAt.
     *
     * @return \DateTime
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * @return Collection|ArticleMarge[]
     */
    public function getArticleMarge(): Collection
    {
        return $this->article_marge;
    }

    public function addArticleMarge(ArticleMarge $articleMarge): self
    {
        if (!$this->article_marge->contains($articleMarge)) {
            $this->article_marge[] = $articleMarge;
            $articleMarge->setArticle($this);
        }

        return $this;
    }

    public function removeArticleMarge(ArticleMarge $articleMarge): self
    {
        if ($this->article_marge->contains($articleMarge)) {
            $this->article_marge->removeElement($articleMarge);
        }

        return $this;
    }
}

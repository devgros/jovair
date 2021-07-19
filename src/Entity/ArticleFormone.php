<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticleFormoneRepository")
 * @Vich\Uploadable
 */
class ArticleFormone
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $sn;

    /**
     * @ORM\Column(type="decimal", scale=2)
     * @Assert\GreaterThanOrEqual(0)
     */
    private $quantite;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $from_tracking;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string
     */
    private $formone;

    /**
     * @Assert\File(
     *     mimeTypes = {"application/pdf", "application/x-pdf"},
     *     mimeTypesMessage = "Merci de sélectionner un fichier PDF"
     * )
     * @Vich\UploadableField(mapping="formone_files", fileNameProperty="formone")
     * @var File
     */
    private $formoneFile;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="Article", inversedBy="article_formone")
     */
    private $article;

    /**
     * @ORM\OneToMany(targetEntity="DossierArticle", mappedBy="article_formone", cascade={"persist", "remove"}, orphanRemoval=true)
     * @Assert\Valid()
     */
    private $dossier_article;

    /**
     * @ORM\OneToMany(targetEntity="DevisArticle", mappedBy="article_formone", cascade={"persist", "remove"}, orphanRemoval=true)
     * @Assert\Valid()
     */
    private $devis_article;

    /**
     * @ORM\Column(type="decimal", scale=2, nullable=true)
     * @Assert\GreaterThanOrEqual(0)
     */
    private $montant_fdp_ht;

    /**
     * @ORM\Column(type="decimal", scale=2, nullable=true)
     * @Assert\GreaterThanOrEqual(0)
     */
    private $montant_fdc_ht;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->dossier_article = new \Doctrine\Common\Collections\ArrayCollection();
        $this->devis_article = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString()
    {
        return "Pn:".$this->article->getPn().' | '.$this->article->getNom()." | Sn:".$this->sn." | qte:".$this->quantite;
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
     * @return ArticleFormone
     */
    public function setSn($sn)
    {
        $this->sn = $sn;

        return $this;
    }

    /**
     * Get sn.
     *
     * @return string
     */
    public function getSn()
    {
        return $this->sn;
    }

    /**
     * Set quantite.
     *
     * @param int $quantite
     *
     * @return ArticleFormone
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;

        return $this;
    }

    /**
     * Get quantite.
     *
     * @return int
     */
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * Set fromTracking.
     *
     * @param string $fromTracking
     *
     * @return ArticleFormone
     */
    public function setFromTracking($fromTracking)
    {
        $this->from_tracking = $fromTracking;

        return $this;
    }

    /**
     * Get fromTracking.
     *
     * @return string
     */
    public function getFromTracking()
    {
        return $this->from_tracking;
    }

    /**
     * Set formone.
     *
     * @param string $formone
     *
     * @return ArticleFormone
     */
    public function setFormone($formone)
    {
        $this->formone = $formone;

        return $this;
    }

    /**
     * Get formone.
     *
     * @return string
     */
    public function getFormone()
    {
        return $this->formone;
    }

    public function setFormoneFile(File $file = null)
    {
        $this->formoneFile = $file;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($file) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getFormoneFile()
    {
        return $this->formoneFile;
    }

    /**
     * Set updatedAt.
     *
     * @param \DateTime $updatedAt
     *
     * @return ArticleFormone
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt.
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set article.
     *
     * @param \App\Entity\Article|null $article
     *
     * @return ArticleFormone
     */
    public function setArticle(\App\Entity\Article $article = null)
    {
        $this->article = $article;

        return $this;
    }

    /**
     * Get article.
     *
     * @return \App\Entity\Article|null
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * Add dossierArticle.
     *
     * @param \App\Entity\DossierArticle $dossierArticle
     *
     * @return ArticleFormone
     */
    public function addDossierArticle(\App\Entity\DossierArticle $dossierArticle)
    {
        $dossierArticle->setArticleFormone($this);
        $this->dossier_article[] = $dossierArticle;

        return $this;
    }

    /**
     * Remove dossierArticle.
     *
     * @param \App\Entity\DossierArticle $dossierArticle
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeDossierArticle(\App\Entity\DossierArticle $dossierArticle)
    {
        return $this->dossier_article->removeElement($dossierArticle);
    }

    /**
     * Get dossierArticle.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDossierArticle()
    {
        return $this->dossier_article;
    }

    /**
     * Add devisArticle.
     *
     * @param \App\Entity\DevisArticle $devisArticle
     *
     * @return ArticleFormone
     */
    public function addDevisArticle(\App\Entity\DevisArticle $devisArticle)
    {
        $devisArticle->setArticleFormone($this);
        $this->devis_article[] = $devisArticle;

        return $this;
    }

    /**
     * Remove devisArticle.
     *
     * @param \App\Entity\DevisArticle $devisArticle
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeDevisArticle(\App\Entity\DevisArticle $devisArticle)
    {
        return $this->devis_article->removeElement($devisArticle);
    }

    /**
     * Get devisArticle.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDevisArticle()
    {
        return $this->devis_article;
    }

    public function getMontantFdpHt(): ?string
    {
        return $this->montant_fdp_ht;
    }

    public function setMontantFdpHt(?string $montant_fdp_ht): self
    {
        $this->montant_fdp_ht = $montant_fdp_ht;

        return $this;
    }

    public function getMontantFdcHt(): ?string
    {
        return $this->montant_fdc_ht;
    }

    public function setMontantFdcHt(?string $montant_fdc_ht): self
    {
        $this->montant_fdc_ht = $montant_fdc_ht;

        return $this;
    }
}

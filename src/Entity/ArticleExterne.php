<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticleExterneRepository")
 * @Vich\Uploadable
 */
class ArticleExterne
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
    private $ref;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="decimal", scale=2)
     * @Assert\GreaterThanOrEqual(0)
     */
    private $quantite;

    /**
     * @ORM\Column(type="decimal", scale=2)
     * @Assert\GreaterThanOrEqual(0)
     */
    private $prix_ht;

    /**
     * @ORM\Column(type="decimal", nullable=true, scale=2, options={"default" : 0})
     * @Assert\GreaterThanOrEqual(0)
     */
    private $remise;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string
     */
    private $formone_externe;

    /**
     * @Assert\File(
     *     mimeTypes = {"application/pdf", "application/x-pdf"},
     *     mimeTypesMessage = "Merci de sélectionner un fichier PDF"
     * )
     * @Vich\UploadableField(mapping="formone_externe_files", fileNameProperty="formone_externe")
     * @var File
     */
    private $formoneExterneFile;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var \DateTime
     */
    private $updatedAt;

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
     * @ORM\ManyToOne(targetEntity="Devis", inversedBy="article_externe")
     * @ORM\JoinColumn(nullable=false)
     */
    private $devis;

    public function __toString()
    {
        return $this->nom;
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
     * Set ref.
     *
     * @param string $ref
     *
     * @return ArticleExterne
     */
    public function setRef($ref)
    {
        $this->ref = $ref;

        return $this;
    }

    /**
     * Get ref.
     *
     * @return string
     */
    public function getRef()
    {
        return $this->ref;
    }

    /**
     * Set nom.
     *
     * @param string $nom
     *
     * @return ArticleExterne
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
     * Set quantite.
     *
     * @param string $quantite
     *
     * @return ArticleExterne
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;

        return $this;
    }

    /**
     * Get quantite.
     *
     * @return string
     */
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * Set remise.
     *
     * @param string|null $remise
     *
     * @return ArticleExterne
     */
    public function setRemise($remise = null)
    {
        $this->remise = $remise;

        return $this;
    }

    /**
     * Get remise.
     *
     * @return string|null
     */
    public function getRemise()
    {
        return $this->remise;
    }

    /**
     * Set formone_externe.
     *
     * @param string $formone_externe
     *
     * @return ArticleFormone
     */
    public function setFormoneExterne($formone_externe)
    {
        $this->formone_externe = $formone_externe;

        return $this;
    }

    /**
     * Get formone_externe.
     *
     * @return string
     */
    public function getFormoneExterne()
    {
        return $this->formone_externe;
    }

    public function setFormoneExterneFile(File $file = null)
    {
        $this->formoneExterneFile = $file;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($file) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getFormoneExterneFile()
    {
        return $this->formoneExterneFile;
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
     * Set devis.
     *
     * @param \App\Entity\Devis $devis
     *
     * @return ArticleExterne
     */
    public function setDevis(\App\Entity\Devis $devis)
    {
        $this->devis = $devis;

        return $this;
    }

    /**
     * Get devis.
     *
     * @return \App\Entity\Devis
     */
    public function getDevis()
    {
        return $this->devis;
    }

    /**
     * Set prixHt.
     *
     * @param string $prixHt
     *
     * @return ArticleExterne
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

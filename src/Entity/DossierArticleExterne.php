<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DossierArticleExterneRepository")
 */
class DossierArticleExterne
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
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
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $quantite;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $prix_ht;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    private $remise;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $dossier_formone_externe;

    /**
     * @Assert\File(
     *     mimeTypes = {"application/pdf", "application/x-pdf"},
     *     mimeTypesMessage = "Merci de sélectionner un fichier PDF"
     * )
     * @Vich\UploadableField(mapping="dossier_formone_externe_files", fileNameProperty="dossier_formone_externe")
     * @var File
     */
    private $dossierFormoneExterneFile;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated_at;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Dossier", inversedBy="dossier_article_externes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $dossier;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $sn;

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

    public function __toString()
    {
        return $this->nom;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPn(): ?string
    {
        return $this->pn;
    }

    public function setPn(string $pn): self
    {
        $this->pn = $pn;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getQuantite()
    {
        return $this->quantite;
    }

    public function setQuantite($quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getPrixHt()
    {
        return $this->prix_ht;
    }

    public function setPrixHt($prix_ht): self
    {
        $this->prix_ht = $prix_ht;

        return $this;
    }

    public function getRemise()
    {
        return $this->remise;
    }

    public function setRemise($remise): self
    {
        $this->remise = $remise;

        return $this;
    }

    public function getFormoneExterne(): ?string
    {
        return $this->formone_externe;
    }

    public function setFormoneExterne(?string $formone_externe): self
    {
        $this->formone_externe = $formone_externe;

        return $this;
    }

    public function setDossierFormoneExterneFile(File $file = null)
    {
        $this->dossierFormoneExterneFile = $file;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($file) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getDossierFormoneExterneFile()
    {
        return $this->dossierFormoneExterneFile;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getDossier(): ?Dossier
    {
        return $this->dossier;
    }

    public function setDossier(?Dossier $dossier): self
    {
        $this->dossier = $dossier;

        return $this;
    }

    public function getSn(): ?string
    {
        return $this->sn;
    }

    public function setSn(?string $sn): self
    {
        $this->sn = $sn;

        return $this;
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

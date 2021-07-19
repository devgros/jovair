<?php

namespace App\Entity;

use App\Repository\DossierFraisCertifRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DossierFraisCertifRepository::class)
 */
class DossierFraisCertif
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Dossier", inversedBy="dossier_frais_certif")
     * @ORM\JoinColumn(nullable=false)
     */
    private $dossier;

    /**
     * @ORM\ManyToOne(targetEntity="FraisCertif", inversedBy="dossier_frais_certif")
     * @ORM\JoinColumn(nullable=false)
     */
    private $frais_certif;

    /**
     * @ORM\ManyToMany(targetEntity="Devis", mappedBy="dossier_fraiscertifs")
     */
    private $devis;

    public function __toString()
    {
        return $this->dossier->getNumBl()." - ".$this->frais_certif->getDesignation();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Set dossier.
     *
     * @param \App\Entity\Dossier|null $dossier
     *
     * @return DossierFraisCertif
     */
    public function setDossier(\App\Entity\Dossier $dossier = null)
    {
        $this->dossier = $dossier;

        return $this;
    }

    /**
     * Get dossier.
     *
     * @return \App\Entity\Dossier|null
     */
    public function getDossier()
    {
        return $this->dossier;
    }

    /**
     * Set fraisCertif.
     *
     * @param \App\Entity\FraisCertif|null $fraisCertif
     *
     * @return DossierFraisCertif
     */
    public function setFraisCertif(\App\Entity\FraisCertif $fraisCertif = null)
    {
        $this->frais_certif = $fraisCertif;

        return $this;
    }

    /**
     * Get fraisCertif.
     *
     * @return \App\Entity\FraisCertif|null
     */
    public function getFraisCertif()
    {
        return $this->frais_certif;
    }

    public function getDossierId()
    {
        return $this->dossier->getId();
    }

    public function getDossierFraisCertifLabel()
    {
        return $this->frais_certif->getDesignation();
    }

    /**
     * @return Collection|Devis[]
     */
    public function getDevis()
    {
        return $this->devis;
    }

    public function addDevis(Devis $devis): self
    {
        if (!$this->devis->contains($devis)) {
            $this->devis[] = $devis;
        }

        return $this;
    }

    public function addNewDevis(Devis $devis): self
    {
        $this->devis[] = $devis;


        return $this;
    }

    public function removeDevis(Devis $devis): self
    {
        if ($this->devis->contains($devis)) {
            $this->devis->removeElement($devis);
        }

        return $this;
    }
}

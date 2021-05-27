<?php

namespace App\Entity;

use App\Repository\DossierFraisPortRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DossierFraisPortRepository::class)
 */
class DossierFraisPort
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Dossier", inversedBy="dossier_frais_port")
     * @ORM\JoinColumn(nullable=false)
     */
    private $dossier;

    /**
     * @ORM\ManyToOne(targetEntity="FraisPort", inversedBy="dossier_frais_port")
     * @ORM\JoinColumn(nullable=false)
     */
    private $frais_port;

    /**
     * @ORM\ManyToMany(targetEntity="Devis", mappedBy="dossier_fraisports")
     */
    private $devis;

    public function __toString()
    {
        return $this->dossier->getNumBl()." - ".$this->frais_port->getDesignation();
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
     * @return DossierFraisPort
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
     * Set fraisPort.
     *
     * @param \App\Entity\FraisPort|null $fraisPort
     *
     * @return DossierFraisPort
     */
    public function setFraisPort(\App\Entity\FraisPort $fraisPort = null)
    {
        $this->frais_port = $fraisPort;

        return $this;
    }

    /**
     * Get fraisPort.
     *
     * @return \App\Entity\FraisPort|null
     */
    public function getFraisPort()
    {
        return $this->frais_port;
    }

    public function getDossierId()
    {
        return $this->dossier->getId();
    }

    public function getDossierFraisPortLabel()
    {
        return $this->frais_port->getDesignation();
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

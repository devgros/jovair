<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DossierMainOeuvreRepository")
 */
class DossierMainOeuvre
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $date_realisation;

    /**
     * @ORM\Column(type="decimal", scale=2)
     * @Assert\GreaterThanOrEqual(0)
     */
    private $quantite;

    /**
     * @ORM\ManyToOne(targetEntity="Dossier", inversedBy="dossier_main_oeuvre")
     * @ORM\JoinColumn(nullable=false)
     */
    private $dossier;

    /**
     * @ORM\ManyToOne(targetEntity="MainOeuvre", inversedBy="dossier_main_oeuvre")
     * @ORM\JoinColumn(nullable=false)
     */
    private $main_oeuvre;

    /**
     * @ORM\ManyToMany(targetEntity="Devis", mappedBy="dossier_mainoeuvres")
     */
    private $devis;

    public function __toString()
    {
        return $this->dossier->getNumBl()." - ".$this->main_oeuvre->getNom()." | qte:".$this->quantite;
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
     * Set quantite.
     *
     * @param int $quantite
     *
     * @return DossierMainOeuvre
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
     * Set dossier.
     *
     * @param \App\Entity\Dossier|null $dossier
     *
     * @return DossierMainOeuvre
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
     * Set mainOeuvre.
     *
     * @param \App\Entity\MainOeuvre|null $mainOeuvre
     *
     * @return DossierMainOeuvre
     */
    public function setMainOeuvre(\App\Entity\MainOeuvre $mainOeuvre = null)
    {
        $this->main_oeuvre = $mainOeuvre;

        return $this;
    }

    /**
     * Get mainOeuvre.
     *
     * @return \App\Entity\MainOeuvre|null
     */
    public function getMainOeuvre()
    {
        return $this->main_oeuvre;
    }

    /**
     * Set dateRealisation.
     *
     * @param \DateTime $dateRealisation
     *
     * @return DossierMainOeuvre
     */
    public function setDateRealisation($dateRealisation)
    {
        $this->date_realisation = $dateRealisation;

        return $this;
    }

    /**
     * Get dateRealisation.
     *
     * @return \DateTime
     */
    public function getDateRealisation()
    {
        return $this->date_realisation;
    }

    public function getDossierId()
    {
        return $this->dossier->getId();
    }

    public function getDossierMainOeuvreLabel()
    {
        return $this->main_oeuvre->getNom()." | qte:".$this->quantite;
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

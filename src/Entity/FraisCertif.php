<?php

namespace App\Entity;

use App\Repository\FraisCertifRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=FraisCertifRepository::class)
 */
class FraisCertif
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $designation;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     * @Assert\GreaterThanOrEqual(0)
     */
    private $prix_ht;

    /**
     * @ORM\OneToMany(targetEntity="DevisFraisCertif", mappedBy="frais_certif", cascade={"persist", "remove"}, orphanRemoval=true)
     * @Assert\Valid()
     */
    private $devis_frais_certif;

    /**
     * @ORM\OneToMany(targetEntity="DossierFraisCertif", mappedBy="frais_certif", cascade={"persist", "remove"}, orphanRemoval=true)
     * @Assert\Valid()
     */
    private $dossier_frais_certif;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->devis_frais_certif = new \Doctrine\Common\Collections\ArrayCollection();
        $this->dossier_frais_certif = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString()
    {
        return $this->designation;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(?string $designation): self
    {
        $this->designation = $designation;

        return $this;
    }

    public function getPrixHt(): ?string
    {
        return $this->prix_ht;
    }

    public function setPrixHt(string $prix_ht): self
    {
        $this->prix_ht = $prix_ht;

        return $this;
    }

    /**
     * Add devisFraisCertif.
     *
     * @param \App\Entity\DevisFraisCertif $devisFraisCertif
     *
     * @return MainOeuvre
     */
    public function addDevisFraisCertif(\App\Entity\DevisFraisCertif $devisFraisCertif)
    {
        $devisFraisCertif->setFraisCertif($this);
        $this->devis_frais_certif[] = $devisFraisCertif;

        return $this;
    }

    /**
     * Remove devisFraisCertif.
     *
     * @param \App\Entity\DevisFraisCertif $devisFraisCertif
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeDevisFraisCertif(\App\Entity\DevisFraisCertif $devisFraisCertif)
    {
        return $this->devis_frais_certif->removeElement($devisFraisCertif);
    }

    /**
     * Get devisFraisCertif.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDevisFraisCertif()
    {
        return $this->devis_frais_certif;
    }


    /**
     * Add dossierFraisCertif.
     *
     * @param \App\Entity\DossierFraisCertif $dossierFraisCertif
     *
     * @return FraisCertif
     */
    public function addDossierFraisCertif(\App\Entity\DossierFraisCertif $dossierFraisCertif)
    {
        $dossierFraisCertif->setFraisCertif($this);
        $this->dossier_frais_certif[] = $dossierFraisCertif;

        return $this;
    }

    /**
     * Remove dossierFraisCertif.
     *
     * @param \App\Entity\DossierFraisCertif $dossierFraisCertif
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeDossierFraisCertif(\App\Entity\DossierFraisCertif $dossierFraisCertif)
    {
        return $this->dossier_frais_certif->removeElement($dossierFraisCertif);
    }

    /**
     * Get dossierFraisPort.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDossierFraisCertif()
    {
        return $this->dossier_frais_certif;
    }
}

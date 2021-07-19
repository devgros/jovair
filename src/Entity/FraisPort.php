<?php

namespace App\Entity;

use App\Repository\FraisPortRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=FraisPortRepository::class)
 */
class FraisPort
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
     * @ORM\OneToMany(targetEntity="DevisFraisPort", mappedBy="frais_port", cascade={"persist", "remove"}, orphanRemoval=true)
     * @Assert\Valid()
     */
    private $devis_frais_port;

    /**
     * @ORM\OneToMany(targetEntity="DossierFraisPort", mappedBy="frais_port", cascade={"persist", "remove"}, orphanRemoval=true)
     * @Assert\Valid()
     */
    private $dossier_frais_port;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->devis_frais_port = new \Doctrine\Common\Collections\ArrayCollection();
        $this->dossier_frais_port = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add devisFraisPort.
     *
     * @param \App\Entity\DevisFraisPort $devisFraisPort
     *
     * @return MainOeuvre
     */
    public function addDevisFraisPort(\App\Entity\DevisFraisPort $devisFraisPort)
    {
        $devisFraisPort->setFraisPort($this);
        $this->devis_frais_port[] = $devisFraisPort;

        return $this;
    }

    /**
     * Remove devisFraisPort.
     *
     * @param \App\Entity\DevisFraisPort $devisFraisPort
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeDevisFraisPort(\App\Entity\DevisFraisPort $devisFraisPort)
    {
        return $this->devis_frais_port->removeElement($devisFraisPort);
    }

    /**
     * Get devisFraisPort.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDevisFraisPort()
    {
        return $this->devis_frais_port;
    }

    /**
     * Add dossierFraisPort.
     *
     * @param \App\Entity\DossierFraisPort $dossierFraisPort
     *
     * @return FraisPort
     */
    public function addDossierFraisPort(\App\Entity\DossierFraisPort $dossierFraisPort)
    {
        $dossierFraisPort->setFraisPort($this);
        $this->dossier_frais_port[] = $dossierFraisPort;

        return $this;
    }

    /**
     * Remove dossierFraisPort.
     *
     * @param \App\Entity\DossierFraisPort $dossierFraisPort
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeDossierFraisPort(\App\Entity\DossierFraisPort $dossierFraisPort)
    {
        return $this->dossier_frais_port->removeElement($dossierFraisPort);
    }

    /**
     * Get dossierFraisPort.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDossierFraisPort()
    {
        return $this->dossier_frais_port;
    }
}

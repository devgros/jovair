<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DossierTravauxRepository")
 */
class DossierTravaux
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $designation;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $commentaire;

    /**
     * @ORM\Column(type="integer")
     * @Assert\GreaterThanOrEqual(0)
     */
    private $statut = 0;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_valid = false;

    /**
     * @ORM\ManyToOne(targetEntity="Dossier", inversedBy="travaux")
     * @ORM\JoinColumn(nullable=false)
     */
    private $dossier;

    /**
     * @ORM\ManyToOne(targetEntity="Mecanicien", inversedBy="travaux")
     * @ORM\JoinColumn(nullable=true)
     */
    private $mecanicien;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="change", field={"mecanicien"})
     */
    private $date_signature;

    /**
     * @ORM\ManyToOne(targetEntity="Mecanicien", inversedBy="travaux_control")
     * @ORM\JoinColumn(nullable=true)
     */
    private $mecanicien_control;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="change", field={"mecanicien_control"})
     */
    private $date_signature_control;

    public function __toString()
    {
        return $this->designation;
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
     * Set designation.
     *
     * @param string $designation
     *
     * @return DossierTravaux
     */
    public function setDesignation($designation)
    {
        $this->designation = $designation;

        return $this;
    }

    /**
     * Get designation.
     *
     * @return string
     */
    public function getDesignation()
    {
        return $this->designation;
    }

    /**
     * Set commentaire.
     *
     * @param string $commentaire
     *
     * @return DossierTravaux
     */
    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    /**
     * Get commentaire.
     *
     * @return string
     */
    public function getCommentaire()
    {
        return $this->commentaire;
    }

    /**
     * Set statut.
     *
     * @param int $statut
     *
     * @return DossierTravaux
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * Get statut.
     *
     * @return int
     */
    public function getStatut()
    {
        return $this->statut;
    }

    /**
     * Set isValid.
     *
     * @param bool $isValid
     *
     * @return DossierTravaux
     */
    public function setIsValid($isValid)
    {
        $this->is_valid = $isValid;

        return $this;
    }

    /**
     * Get isValid.
     *
     * @return bool
     */
    public function getIsValid()
    {
        return $this->is_valid;
    }

    /**
     * Set dossier.
     *
     * @param \App\Entity\Dossier|null $dossier
     *
     * @return DossierTravaux
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
     * Set mecanicien.
     *
     * @param \App\Entity\Mecanicien|null $mecanicien
     *
     * @return DossierTravaux
     */
    public function setMecanicien(\App\Entity\Mecanicien $mecanicien = null)
    {
        $this->mecanicien = $mecanicien;

        return $this;
    }

    /**
     * Get mecanicien.
     *
     * @return \App\Entity\Mecanicien|null
     */
    public function getMecanicien()
    {
        return $this->mecanicien;
    }

    /**
     * Set dateSignature.
     *
     * @param \DateTime|null $dateSignature
     *
     * @return DossierTravaux
     */
    public function setDateSignature($dateSignature = null)
    {
        $this->date_signature = $dateSignature;

        return $this;
    }

    /**
     * Get dateSignature.
     *
     * @return \DateTime|null
     */
    public function getDateSignature()
    {
        return $this->date_signature;
    }

    /**
     * Set dateSignatureControl.
     *
     * @param \DateTime|null $dateSignatureControl
     *
     * @return DossierTravaux
     */
    public function setDateSignatureControl($dateSignatureControl = null)
    {
        $this->date_signature_control = $dateSignatureControl;

        return $this;
    }

    /**
     * Get dateSignatureControl.
     *
     * @return \DateTime|null
     */
    public function getDateSignatureControl()
    {
        return $this->date_signature_control;
    }

    /**
     * Set mecanicienControl.
     *
     * @param \App\Entity\Mecanicien|null $mecanicienControl
     *
     * @return DossierTravaux
     */
    public function setMecanicienControl(\App\Entity\Mecanicien $mecanicienControl = null)
    {
        $this->mecanicien_control = $mecanicienControl;

        return $this;
    }

    /**
     * Get mecanicienControl.
     *
     * @return \App\Entity\Mecanicien|null
     */
    public function getMecanicienControl()
    {
        return $this->mecanicien_control;
    }
}

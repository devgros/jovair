<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DossierCnadRepository")
 */
class DossierCnad
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
     * @ORM\ManyToOne(targetEntity="Dossier", inversedBy="cnad")
     * @ORM\JoinColumn(nullable=false)
     */
    private $dossier;

    /**
     * @ORM\ManyToOne(targetEntity="Mecanicien", inversedBy="cnad")
     * @ORM\JoinColumn(nullable=true)
     */
    private $mecanicien;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="change", field={"mecanicien"})
     */
    private $date_signature;

    /**
     * @ORM\ManyToOne(targetEntity="Mecanicien", inversedBy="cnad_control")
     * @ORM\JoinColumn(nullable=true)
     */
    private $mecanicien_control;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="change", field={"mecanicien_control"})
     */
    private $date_signature_control;

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
     * @return DossierCnad
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
     * @param string|null $commentaire
     *
     * @return DossierCnad
     */
    public function setCommentaire($commentaire = null)
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    /**
     * Get commentaire.
     *
     * @return string|null
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
     * @return DossierCnad
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
     * @return DossierCnad
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
     * @param \App\Entity\Dossier $dossier
     *
     * @return DossierCnad
     */
    public function setDossier(\App\Entity\Dossier $dossier)
    {
        $this->dossier = $dossier;

        return $this;
    }

    /**
     * Get dossier.
     *
     * @return \App\Entity\Dossier
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
     * @return DossierCnad
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
     * @return DossierCnad
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
     * @return DossierCnad
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
     * @return DossierCnad
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

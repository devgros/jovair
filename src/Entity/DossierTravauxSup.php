<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DossierTravauxSupRepository")
 */
class DossierTravauxSup
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
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $action_corrective;

    /**
     * @ORM\ManyToOne(targetEntity="Dossier", inversedBy="travaux_sup")
     * @ORM\JoinColumn(nullable=false)
     */
    private $dossier;

    /**
     * @ORM\ManyToOne(targetEntity="Mecanicien", inversedBy="travaux_sup")
     * @ORM\JoinColumn(nullable=false)
     */
    private $mecanicien;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="change", field={"mecanicien"})
     */
    private $date_signature;

    /**
     * @ORM\ManyToOne(targetEntity="Mecanicien", inversedBy="travaux_sup_control")
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
     * @return DossierTravauxSup
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
     * Set actionCorrective.
     *
     * @param string $actionCorrective
     *
     * @return DossierTravauxSup
     */
    public function setActionCorrective($actionCorrective)
    {
        $this->action_corrective = $actionCorrective;

        return $this;
    }

    /**
     * Get actionCorrective.
     *
     * @return string
     */
    public function getActionCorrective()
    {
        return $this->action_corrective;
    }

    /**
     * Set dossier.
     *
     * @param \App\Entity\Dossier $dossier
     *
     * @return DossierTravauxSup
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
     * @return DossierTravauxSup
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
     * @return DossierTravauxSup
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
     * @return DossierTravauxSup
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
     * @return DossierTravauxSup
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

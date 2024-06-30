<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProgrammeEntretienRepository")
 */
class ProgrammeEntretien
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
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $edition;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $revision;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="Appareil", inversedBy="appareil_pe")
     */
    private $appareil;

    public function __toString()
    {
        return $this->type;
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
     * Set type.
     *
     * @param string $type
     *
     * @return ProgrammeEntretien
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set edition.
     *
     * @param string $edition
     *
     * @return ProgrammeEntretien
     */
    public function setEdition($edition)
    {
        $this->edition = $edition;

        return $this;
    }

    /**
     * Get edition.
     *
     * @return string
     */
    public function getEdition()
    {
        return $this->edition;
    }

    /**
     * Set revision.
     *
     * @param string $revision
     *
     * @return ProgrammeEntretien
     */
    public function setRevision($revision)
    {
        $this->revision = $revision;

        return $this;
    }

    /**
     * Get revision.
     *
     * @return string
     */
    public function getRevision()
    {
        return $this->revision;
    }

    /**
     * Set date.
     *
     * @param \DateTime|null $date
     *
     * @return ProgrammeEntretien
     */
    public function setDate($date = null)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date.
     *
     * @return \DateTime|null
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set appareil.
     *
     * @param \App\Entity\Appareil|null $appareil
     *
     * @return ProgrammeEntretien
     */
    public function setAppareil(\App\Entity\Appareil $appareil = null)
    {
        $this->appareil = $appareil;

        return $this;
    }

    /**
     * Get appareil.
     *
     * @return \App\Entity\Appareil|null
     */
    public function getAppareil()
    {
        return $this->appareil;
    }
}

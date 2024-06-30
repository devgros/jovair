<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AmmMoteurRepository")
 */
class AmmMoteur
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
     * @ORM\ManyToOne(targetEntity="Appareil", inversedBy="appareil_amm_moteur")
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
     * @return AmmMoteur
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
     * @return AmmMoteur
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
     * @return AmmMoteur
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
     * @param \DateTime $date
     *
     * @return AmmMoteur
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date.
     *
     * @return \DateTime
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
     * @return AmmMoteur
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

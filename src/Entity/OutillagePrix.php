<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OutillagePrixRepository")
 */
class OutillagePrix
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $date_change;

    /**
     * @ORM\Column(type="decimal", scale=2)
     * @Assert\GreaterThanOrEqual(0)
     */
    private $prix_ht;

    /**
     * @ORM\ManyToOne(targetEntity="Outillage", inversedBy="outillage_prix")
     */
    private $outillage;

    public function __toString()
    {
        return $this->prix_ht;
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
     * Set dateChange.
     *
     * @param \DateTime $dateChange
     *
     * @return OutillagePrix
     */
    public function setDateChange($dateChange)
    {
        $this->date_change = $dateChange;

        return $this;
    }

    /**
     * Get dateChange.
     *
     * @return \DateTime
     */
    public function getDateChange()
    {
        return $this->date_change;
    }

    /**
     * Set prixHt.
     *
     * @param string $prixHt
     *
     * @return OutillagePrix
     */
    public function setPrixHt($prixHt)
    {
        $this->prix_ht = $prixHt;

        return $this;
    }

    /**
     * Get prixHt.
     *
     * @return string
     */
    public function getPrixHt()
    {
        return $this->prix_ht;
    }

    /**
     * Set outillage.
     *
     * @param \App\Entity\Outillage|null $outillage
     *
     * @return OutillagePrix
     */
    public function setOutillage(\App\Entity\Outillage $outillage = null)
    {
        $this->outillage = $outillage;

        return $this;
    }

    /**
     * Get outillage.
     *
     * @return \App\Entity\Outillage|null
     */
    public function getOutillage()
    {
        return $this->outillage;
    }
}

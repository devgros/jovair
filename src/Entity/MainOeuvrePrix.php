<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MainOeuvrePrixRepository")
 */
class MainOeuvrePrix
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
     * @ORM\ManyToOne(targetEntity="MainOeuvre", inversedBy="main_oeuvre_prix")
     */
    private $main_oeuvre;

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
     * @return MainOeuvrePrix
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
     * @return MainOeuvrePrix
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
     * Set mainOeuvre.
     *
     * @param \App\Entity\MainOeuvre|null $mainOeuvre
     *
     * @return MainOeuvrePrix
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
}

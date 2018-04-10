<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TodoRepository")
 */
class Todo
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $date_creation;

    /**
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="update")
     */
    private $date_modif;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titre;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $note;

    /**
     * @ORM\ManyToOne(targetEntity="Client", inversedBy="todos")
     * @ORM\JoinColumn(nullable=true)
     */
    private $client;

    /**
     * @ORM\ManyToOne(targetEntity="Appareil", inversedBy="todos")
     * @ORM\JoinColumn(nullable=true)
     */
    private $appareil;

    public function __toString()
    {
        return $this->titre;
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
     * Set dateCreation.
     *
     * @param \DateTime $dateCreation
     *
     * @return Todo
     */
    public function setDateCreation($dateCreation)
    {
        $this->date_creation = $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation.
     *
     * @return \DateTime
     */
    public function getDateCreation()
    {
        return $this->date_creation;
    }

    /**
     * Set dateModif.
     *
     * @param \DateTime $dateModif
     *
     * @return Todo
     */
    public function setDateModif($dateModif)
    {
        $this->date_modif = $dateModif;

        return $this;
    }

    /**
     * Get dateModif.
     *
     * @return \DateTime
     */
    public function getDateModif()
    {
        return $this->date_modif;
    }

    /**
     * Set titre.
     *
     * @param string $titre
     *
     * @return Todo
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre.
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set note.
     *
     * @param string|null $note
     *
     * @return Todo
     */
    public function setNote($note = null)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note.
     *
     * @return string|null
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set client.
     *
     * @param \App\Entity\Client|null $client
     *
     * @return Todo
     */
    public function setClient(\App\Entity\Client $client = null)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get client.
     *
     * @return \App\Entity\Client|null
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set appareil.
     *
     * @param \App\Entity\Appareil|null $appareil
     *
     * @return Todo
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

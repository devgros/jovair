<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AlerteRepository")
 */
class Alerte
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
     * @ORM\Column(type="string", length=255)
     */
    private $designation;

    /**
     * @ORM\Column(type="integer")
     * @Assert\GreaterThanOrEqual(0)
     *
     * 0: stock
     * 1: outillage
     */
    private $type = 0;

    /**
     * @ORM\Column(type="integer")
     * @Assert\GreaterThanOrEqual(0)
     */
    private $id_entity = 0;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name_entity;

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
     * @return Alerte
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
     * Set type.
     *
     * @param int $type
     *
     * @return Alerte
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type.
     *
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set idEntity.
     *
     * @param int $idEntity
     *
     * @return Alerte
     */
    public function setIdEntity($idEntity)
    {
        $this->id_entity = $idEntity;

        return $this;
    }

    /**
     * Get idEntity.
     *
     * @return int
     */
    public function getIdEntity()
    {
        return $this->id_entity;
    }

    /**
     * Set nameEntity.
     *
     * @param string $nameEntity
     *
     * @return Alerte
     */
    public function setNameEntity($nameEntity)
    {
        $this->name_entity = $nameEntity;

        return $this;
    }

    /**
     * Get nameEntity.
     *
     * @return string
     */
    public function getNameEntity()
    {
        return $this->name_entity;
    }

    /**
     * Set designation.
     *
     * @param string $designation
     *
     * @return Alerte
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
}

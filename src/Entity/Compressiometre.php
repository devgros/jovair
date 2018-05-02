<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CompressiometreRepository")
 */
class Compressiometre
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /*
     * @ORM\ManyToOne(targetEntity="Dossier", inversedBy="compressiometres")
     * @ORM\JoinColumn(nullable=false)
     */
    //private $dossier;

    /**
     * @ORM\OneToOne(targetEntity="DossierOutils", mappedBy="compressiometre", cascade={"persist", "remove"})
     */
    private $dossier_outils;

    /**
     * @ORM\Column(type="decimal", scale=2, nullable=true)
     * @Assert\GreaterThanOrEqual(0)
     */
    private $g1;

    /**
     * @ORM\Column(type="decimal", scale=2, nullable=true)
     * @Assert\GreaterThanOrEqual(0)
     */
    private $g2;

    /**
     * @ORM\Column(type="decimal", scale=2, nullable=true)
     * @Assert\GreaterThanOrEqual(0)
     */
    private $g3;

    /**
     * @ORM\Column(type="decimal", scale=2, nullable=true)
     * @Assert\GreaterThanOrEqual(0)
     */
    private $g4;

   	/**
     * @ORM\Column(type="decimal", scale=2, nullable=true)
     * @Assert\GreaterThanOrEqual(0)
     */
    private $g5;

    /**
     * @ORM\Column(type="decimal", scale=2, nullable=true)
     * @Assert\GreaterThanOrEqual(0)
     */
    private $g6;

    /**
     * @ORM\Column(type="decimal", scale=2, nullable=true)
     * @Assert\GreaterThanOrEqual(0)
     */
    private $d1;

    /**
     * @ORM\Column(type="decimal", scale=2, nullable=true)
     * @Assert\GreaterThanOrEqual(0)
     */
    private $d2;

    /**
     * @ORM\Column(type="decimal", scale=2, nullable=true)
     * @Assert\GreaterThanOrEqual(0)
     */
    private $d3;

    /**
     * @ORM\Column(type="decimal", scale=2, nullable=true)
     * @Assert\GreaterThanOrEqual(0)
     */
    private $d4;

    /**
     * @ORM\Column(type="decimal", scale=2, nullable=true)
     * @Assert\GreaterThanOrEqual(0)
     */
    private $d5;

    /**
     * @ORM\Column(type="decimal", scale=2, nullable=true)
     * @Assert\GreaterThanOrEqual(0)
     */
    private $d6;

    public function __toString()
    {
        return $this->id;
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
     * Set g1.
     *
     * @param string|null $g1
     *
     * @return Compressiometre
     */
    public function setG1($g1 = null)
    {
        $this->g1 = $g1;

        return $this;
    }

    /**
     * Get g1.
     *
     * @return string|null
     */
    public function getG1()
    {
        return $this->g1;
    }

    /**
     * Set g2.
     *
     * @param string|null $g2
     *
     * @return Compressiometre
     */
    public function setG2($g2 = null)
    {
        $this->g2 = $g2;

        return $this;
    }

    /**
     * Get g2.
     *
     * @return string|null
     */
    public function getG2()
    {
        return $this->g2;
    }

    /**
     * Set g3.
     *
     * @param string|null $g3
     *
     * @return Compressiometre
     */
    public function setG3($g3 = null)
    {
        $this->g3 = $g3;

        return $this;
    }

    /**
     * Get g3.
     *
     * @return string|null
     */
    public function getG3()
    {
        return $this->g3;
    }

    /**
     * Set g4.
     *
     * @param string|null $g4
     *
     * @return Compressiometre
     */
    public function setG4($g4 = null)
    {
        $this->g4 = $g4;

        return $this;
    }

    /**
     * Get g4.
     *
     * @return string|null
     */
    public function getG4()
    {
        return $this->g4;
    }

    /**
     * Set g5.
     *
     * @param string|null $g5
     *
     * @return Compressiometre
     */
    public function setG5($g5 = null)
    {
        $this->g5 = $g5;

        return $this;
    }

    /**
     * Get g5.
     *
     * @return string|null
     */
    public function getG5()
    {
        return $this->g5;
    }

    /**
     * Set g6.
     *
     * @param string|null $g6
     *
     * @return Compressiometre
     */
    public function setG6($g6 = null)
    {
        $this->g6 = $g6;

        return $this;
    }

    /**
     * Get g6.
     *
     * @return string|null
     */
    public function getG6()
    {
        return $this->g6;
    }

    /**
     * Set d1.
     *
     * @param string|null $d1
     *
     * @return Compressiometre
     */
    public function setD1($d1 = null)
    {
        $this->d1 = $d1;

        return $this;
    }

    /**
     * Get d1.
     *
     * @return string|null
     */
    public function getD1()
    {
        return $this->d1;
    }

    /**
     * Set d2.
     *
     * @param string|null $d2
     *
     * @return Compressiometre
     */
    public function setD2($d2 = null)
    {
        $this->d2 = $d2;

        return $this;
    }

    /**
     * Get d2.
     *
     * @return string|null
     */
    public function getD2()
    {
        return $this->d2;
    }

    /**
     * Set d3.
     *
     * @param string|null $d3
     *
     * @return Compressiometre
     */
    public function setD3($d3 = null)
    {
        $this->d3 = $d3;

        return $this;
    }

    /**
     * Get d3.
     *
     * @return string|null
     */
    public function getD3()
    {
        return $this->d3;
    }

    /**
     * Set d4.
     *
     * @param string|null $d4
     *
     * @return Compressiometre
     */
    public function setD4($d4 = null)
    {
        $this->d4 = $d4;

        return $this;
    }

    /**
     * Get d4.
     *
     * @return string|null
     */
    public function getD4()
    {
        return $this->d4;
    }

    /**
     * Set d5.
     *
     * @param string|null $d5
     *
     * @return Compressiometre
     */
    public function setD5($d5 = null)
    {
        $this->d5 = $d5;

        return $this;
    }

    /**
     * Get d5.
     *
     * @return string|null
     */
    public function getD5()
    {
        return $this->d5;
    }

    /**
     * Set d6.
     *
     * @param string|null $d6
     *
     * @return Compressiometre
     */
    public function setD6($d6 = null)
    {
        $this->d6 = $d6;

        return $this;
    }

    /**
     * Get d6.
     *
     * @return string|null
     */
    public function getD6()
    {
        return $this->d6;
    }

    /**
     * Set dossierOutils.
     *
     * @param \App\Entity\DossierOutils|null $dossierOutils
     *
     * @return Compressiometre
     */
    public function setDossierOutils(\App\Entity\DossierOutils $dossierOutils = null)
    {
        $this->dossier_outils = $dossierOutils;
        $dossierOutils->setCompressiometre($this);
        
        return $this;
    }

    /**
     * Get dossierOutils.
     *
     * @return \App\Entity\DossierOutils|null
     */
    public function getDossierOutils()
    {
        return $this->dossier_outils;
    }
}

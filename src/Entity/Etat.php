<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EtatRepository")
 */
class Etat
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="bigint",nullable=false)
     * @ORM\SequenceGenerator(sequenceName="etat_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $etat;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Borne", mappedBy="etat")
     */
    private $bornes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Serveur", mappedBy="etat")
     */
    private $serveurs;

    public function __construct()
    {
        $this->bornes = new ArrayCollection();
        $this->serveurs= new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }
}

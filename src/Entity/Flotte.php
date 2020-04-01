<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FlotteRepository")
 */
class Flotte
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="bigint",nullable=false)
     * @ORM\SequenceGenerator(sequenceName="flotte_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nom_flotte;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Manager", inversedBy="flottes")
     */
    private $manager;

    /**
     * @ORM\ManyToMany(targetEntity="Borne", mappedBy="flottes")
     */
    private $bornes;

    public function __construct()
    {
        $this->bornes = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getBornes()
    {
        return $this->bornes;
    }

    /**
     * @param mixed $bornes
     */
    public function setBornes($bornes): void
    {
        $this->bornes = $bornes;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomFlotte(): ?string
    {
        return $this->nom_flotte;
    }

    public function setNomFlotte(string $nom_flotte): self
    {
        $this->nom_flotte = $nom_flotte;

        return $this;
    }

    public function getManager(): ?Manager
    {
        return $this->manager;
    }

    public function setManager(?Manager $manager): self
    {
        $this->manager = $manager;

        return $this;
    }
}

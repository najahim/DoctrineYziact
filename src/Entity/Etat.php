<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Activation", mappedBy="type")
     */
    private $activations;

    public function __construct()
    {
        $this->bornes = new ArrayCollection();
        $this->serveurs= new ArrayCollection();
        $this->activations = new ArrayCollection();
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

    /**
     * @return Collection|Activation[]
     */
    public function getActivations(): Collection
    {
        return $this->activations;
    }

    public function addActivation(Activation $activation): self
    {
        if (!$this->activations->contains($activation)) {
            $this->activations[] = $activation;
            $activation->setType($this);
        }

        return $this;
    }

    public function removeActivation(Activation $activation): self
    {
        if ($this->activations->contains($activation)) {
            $this->activations->removeElement($activation);
            // set the owning side to null (unless already changed)
            if ($activation->getType() === $this) {
                $activation->setType(null);
            }
        }

        return $this;
    }
}

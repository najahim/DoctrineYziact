<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AdminRepository")
 */
class Admin extends Personne
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="bigint",nullable=false)
     * @ORM\SequenceGenerator(sequenceName="admin_id_seq", allocationSize=1, initialValue=1)
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $prenom;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Activation", mappedBy="admin")
     */
    private $activations;

    public function __construct()
    {
        $this->activations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

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
            $activation->setAdmin($this);
        }

        return $this;
    }

    public function removeActivation(Activation $activation): self
    {
        if ($this->activations->contains($activation)) {
            $this->activations->removeElement($activation);
            // set the owning side to null (unless already changed)
            if ($activation->getAdmin() === $this) {
                $activation->setAdmin(null);
            }
        }

        return $this;
    }
}

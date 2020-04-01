<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ManagerRepository")
 */

class Manager extends Personne
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="bigint",nullable=false)
     * @ORM\SequenceGenerator(sequenceName="manager_id_seq", allocationSize=1, initialValue=1)
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $identifiant;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom_manager;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom_manager;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Organisation", mappedBy="manager")
     */
    private $organisations;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Flotte", mappedBy="manager")
     */
    private $flottes;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\NiveauPrivilege", inversedBy="managers")
     */
    private $niveau_privilege;

    public function __construct()
    {
        $this->organisations = new ArrayCollection();
        $this->flottes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdentifiant(): ?string
    {
        return $this->identifiant;
    }

    public function setIdentifiant(string $identifiant): self
    {
        $this->identifiant = $identifiant;

        return $this;
    }

    public function getNomManager(): ?string
    {
        return $this->nom_manager;
    }

    public function setNomManager(string $nom_manager): self
    {
        $this->nom_manager = $nom_manager;

        return $this;
    }

    public function getPrenomManager(): ?string
    {
        return $this->prenom_manager;
    }

    public function setPrenomManager(string $prenom_manager): self
    {
        $this->prenom_manager = $prenom_manager;

        return $this;
    }

    /**
     * @return Collection|Organisation[]
     */
    public function getOrganisations(): Collection
    {
        return $this->organisations;
    }

    public function addOrganisation(Organisation $organisation): self
    {
        if (!$this->organisations->contains($organisation)) {
            $this->organisations[] = $organisation;
            $organisation->setManager($this);
        }

        return $this;
    }

    public function removeOrganisation(Organisation $organisation): self
    {
        if ($this->organisations->contains($organisation)) {
            $this->organisations->removeElement($organisation);
            // set the owning side to null (unless already changed)
            if ($organisation->getManager() === $this) {
                $organisation->setManager(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Flotte[]
     */
    public function getFlottes(): Collection
    {
        return $this->flottes;
    }

    public function addFlotte(Flotte $flotte): self
    {
        if (!$this->flottes->contains($flotte)) {
            $this->flottes[] = $flotte;
            $flotte->setManager($this);
        }

        return $this;
    }

    public function removeFlotte(Flotte $flotte): self
    {
        if ($this->flottes->contains($flotte)) {
            $this->flottes->removeElement($flotte);
            // set the owning side to null (unless already changed)
            if ($flotte->getManager() === $this) {
                $flotte->setManager(null);
            }
        }

        return $this;
    }

    public function getNiveauPrivilege(): ?NiveauPrivilege
    {
        return $this->niveau_privilege;
    }

    public function setNiveauPrivilege(?NiveauPrivilege $niveau_privilege): self
    {
        $this->niveau_privilege = $niveau_privilege;

        return $this;
    }
}

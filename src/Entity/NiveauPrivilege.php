<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NiveauPrivilegeRepository")
 */
class NiveauPrivilege
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="bigint",nullable=false)
     * @ORM\SequenceGenerator(sequenceName="niveauPrivilege_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $niveau_privilege;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Manager", mappedBy="niveau_privilege")
     */
    private $managers;

    public function __construct()
    {
        $this->managers = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNiveauPrivilege(): ?string
    {
        return $this->niveau_privilege;
    }

    public function setNiveauPrivilege(string $niveau_privilege): self
    {
        $this->niveau_privilege = $niveau_privilege;

        return $this;
    }

    /**
     * @return Collection|Manager[]
     */
    public function getManagers(): Collection
    {
        return $this->managers;
    }

    public function addManager(Manager $manager): self
    {
        if (!$this->managers->contains($manager)) {
            $this->managers[] = $manager;
            $manager->setNiveauPrivilege($this);
        }

        return $this;
    }

    public function removeManager(Manager $manager): self
    {
        if ($this->managers->contains($manager)) {
            $this->managers->removeElement($manager);
            // set the owning side to null (unless already changed)
            if ($manager->getNiveauPrivilege() === $this) {
                $manager->setNiveauPrivilege(null);
            }
        }

        return $this;
    }
}

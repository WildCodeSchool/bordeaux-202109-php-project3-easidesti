<?php

namespace App\Entity;

use App\Repository\SchoolRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SchoolRepository::class)
 * @UniqueEntity(fields={"name"}, message="Ce nom d'école est déjà utilisé, merci d'en choissir un autre.")
 */
class School
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true, nullable=true)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=SchoolLevel::class, mappedBy="school")
     */
    private $schoolLevels;

    public function __construct()
    {
        $this->user = new ArrayCollection();
        $this->schoolLevels = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|SchoolLevel[]
     */
    public function getSchoolLevels(): Collection
    {
        return $this->schoolLevels;
    }

    public function addSchoolLevel(SchoolLevel $schoolLevel): self
    {
        if (!$this->schoolLevels->contains($schoolLevel)) {
            $this->schoolLevels[] = $schoolLevel;
            $schoolLevel->setSchool($this);
        }

        return $this;
    }

    public function removeSchoolLevel(SchoolLevel $schoolLevel): self
    {
        if ($this->schoolLevels->removeElement($schoolLevel)) {
            // set the owning side to null (unless already changed)
            if ($schoolLevel->getSchool() === $this) {
                $schoolLevel->setSchool(null);
            }
        }

        return $this;
    }
}

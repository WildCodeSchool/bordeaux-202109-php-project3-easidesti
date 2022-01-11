<?php

namespace App\Entity;

use App\Repository\StudyLetterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StudyLetterRepository::class)
 */
class StudyLetter
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private int $position;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $audio;

    public function getLetterPosition(): string
    {
        return 'Lettre [ ' . substr($this->getAudio(),0,1) . ' ] à la position ' . $this->getPosition();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function getAudio(): ?string
    {
        return $this->audio;
    }

    public function setAudio(string $audio): self
    {
        $this->audio = $audio;

        return $this;
    }
}

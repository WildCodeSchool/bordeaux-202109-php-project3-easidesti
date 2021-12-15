<?php

namespace App\Entity;

use App\Repository\MuteLetterRepository;
use Doctrine\ORM\Mapping as ORM;
use DateTime;

/**
 * @ORM\Entity(repositoryClass=MuteLetterRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class MuteLetter
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\Column(type="integer")
     */
    private int $position;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTimeInterface $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=Word::class, inversedBy="muteLetters")
     */
    private ?Word $word;

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

    public function getWord(): ?Word
    {
        return $this->word;
    }

    public function setWord(?Word $word): self
    {
        $this->word = $word;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAt(): void
    {
        $this->createdAt = new DateTime();
    }
}

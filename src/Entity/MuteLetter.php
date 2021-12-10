<?php

namespace App\Entity;

use App\Repository\MuteLetterRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MuteLetterRepository::class)
 */
class MuteLetter
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="integer")
     */
    private int $position;

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
}

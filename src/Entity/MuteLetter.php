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
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $letterPosition;

    /**
     * @ORM\ManyToOne(targetEntity=Word::class, inversedBy="muteLetters")
     * @ORM\JoinColumn(nullable=false)
     */
    private $word;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLetterPosition(): ?int
    {
        return $this->letterPosition;
    }

    public function setLetterPosition(?int $letterPosition): self
    {
        $this->letterPosition = $letterPosition;

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

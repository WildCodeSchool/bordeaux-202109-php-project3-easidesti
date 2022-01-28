<?php

namespace App\Entity;

use App\Repository\HelpStatRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HelpStatRepository::class)
 */
class HelpStat
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
    private int $helpNumber;

    /**
     * @ORM\ManyToOne(targetEntity=Word::class, inversedBy="helpStats")
     * @ORM\JoinColumn(nullable=false)
     */
    private Word $word;

    /**
     * @ORM\ManyToOne(targetEntity=Game::class, inversedBy="helpStats")
     * @ORM\JoinColumn(nullable=false)
     */
    private Game $game;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHelpNumber(): int
    {
        return $this->helpNumber;
    }

    public function setHelpNumber(int $helpNumber): self
    {
        $this->helpNumber = $helpNumber;

        return $this;
    }

    public function getWord(): Word
    {
        return $this->word;
    }

    public function setWord(Word $word): self
    {
        $this->word = $word;

        return $this;
    }

    public function getGame(): Game
    {
        return $this->game;
    }

    public function setGame(Game $game): self
    {
        $this->game = $game;

        return $this;
    }
}

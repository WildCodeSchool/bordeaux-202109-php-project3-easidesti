<?php

namespace App\Entity;

use App\Repository\WordRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=WordRepository::class)
 */
class Word
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $content;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $definition;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $audio;

    /**
     * @ORM\OneToMany(targetEntity=MuteLetter::class, mappedBy="word")
     */
    private Collection $muteLetters;

    /**
     * @ORM\OneToMany(targetEntity=Letter::class, mappedBy="word", orphanRemoval=true)
     */
    private Collection $letters;

    /**
     * @ORM\OneToMany(targetEntity=Endpoint::class, mappedBy="word", orphanRemoval=true)
     */
    private Collection $endpoints;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTimeInterface $createdAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $picture;

    public function __construct()
    {
        $this->muteLetters = new ArrayCollection();
        $this->letters = new ArrayCollection();
        $this->endpoints = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getDefinition(): ?string
    {
        return $this->definition;
    }

    public function setDefinition(?string $definition): self
    {
        $this->definition = $definition;

        return $this;
    }

    public function getAudio(): ?string
    {
        return $this->audio;
    }

    public function setAudio(?string $audio): self
    {
        $this->audio = $audio;

        return $this;
    }

    /**
     * @return Collection|MuteLetter[]
     */
    public function getMuteLetters(): Collection
    {
        return $this->muteLetters;
    }

    public function addMuteLetter(MuteLetter $muteLetter): self
    {
        if (!$this->muteLetters->contains($muteLetter)) {
            $this->muteLetters[] = $muteLetter;
            $muteLetter->setWord($this);
        }

        return $this;
    }

    public function removeMuteLetter(MuteLetter $muteLetter): self
    {
        if ($this->muteLetters->removeElement($muteLetter)) {
            // set the owning side to null (unless already changed)
            if ($muteLetter->getWord() === $this) {
                $muteLetter->setWord(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Letter[]
     */
    public function getLetters(): Collection
    {
        return $this->letters;
    }

    public function addLetter(Letter $letter): self
    {
        if (!$this->letters->contains($letter)) {
            $this->letters[] = $letter;
            $letter->setWord($this);
        }

        return $this;
    }

    public function removeLetter(Letter $letter): self
    {
        if ($this->letters->removeElement($letter)) {
            // set the owning side to null (unless already changed)
            if ($letter->getWord() === $this) {
                $letter->setWord(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Endpoint[]
     */
    public function getEndpoints(): Collection
    {
        return $this->endpoints;
    }

    public function addEndpoint(Endpoint $endpoint): self
    {
        if (!$this->endpoints->contains($endpoint)) {
            $this->endpoints[] = $endpoint;
            $endpoint->setWord($this);
        }

        return $this;
    }

    public function removeEndpoint(Endpoint $endpoint): self
    {
        if ($this->endpoints->removeElement($endpoint)) {
            // set the owning side to null (unless already changed)
            if ($endpoint->getWord() === $this) {
                $endpoint->setWord(null);
            }
        }

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }
}

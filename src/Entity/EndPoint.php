<?php

namespace App\Entity;

use App\Repository\EndPointRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EndPointRepository::class)
 */
class EndPoint
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
    private $endpointPosition;

    /**
     * @ORM\ManyToOne(targetEntity=Word::class, inversedBy="endPoints")
     * @ORM\JoinColumn(nullable=false)
     */
    private $word;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEndpointPosition(): ?int
    {
        return $this->endpointPosition;
    }

    public function setEndpointPosition(int $endpointPosition): self
    {
        $this->endpointPosition = $endpointPosition;

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

<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\PriorityRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Prioritäten für Aufgaben.
 */
#[ORM\Entity(repositoryClass: PriorityRepository::class)]
#[ApiResource(
    description: 'Prioritäten für Aufgaben.',
    operations: [
        new Get(),
        new GetCollection(),
    ],
    normalizationContext: [
        'groups' => ['priority:read']
    ],
    denormalizationContext: [
        'groups' => ['priority:write']
    ]
)]
class Priority
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['priority:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 120)]
    #[Groups(['priority:read'])]
    private ?string $code = null;

    #[ORM\Column(length: 255)]
    #[Groups(['priority:read'])]
    private ?string $name = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getName();
    }
}

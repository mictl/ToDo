<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\StatusRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Status für Aufgaben.
 */
#[ORM\Entity(repositoryClass: StatusRepository::class)]
#[ApiResource(
    shortName: 'Status',
    description: 'Status für Aufgaben.',
    operations: [
        new Get(uriTemplate: '/status/{id}'),
        new GetCollection(uriTemplate: '/status'),
    ],
    normalizationContext: [
        'groups' => ['status:read']
    ],
    denormalizationContext: [
        'groups' => ['status:write']
    ]
)]
class Status
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['status:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 120)]
    #[Groups(['status:read'])]
    private ?string $name = null;

    public function getId(): ?int
    {
        return $this->id;
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

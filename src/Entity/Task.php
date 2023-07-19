<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use App\Repository\TaskRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Aufgaben der ToDoApp.
 */
#[ORM\Entity(repositoryClass: TaskRepository::class)]
#[ApiResource(
    description: 'In der ToDoApp angelegte Aufgaben.',
    operations: [
        new Get(),
        new GetCollection(),
        new Patch(),
    ],
    normalizationContext: [
        'groups' => ['task:read']
    ],
    denormalizationContext: [
        'groups' => ['task:write']
    ]
)]
class Task
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    /**
     * Ein kurzer, aussagekräftiger Titel für die Aufgabe.
     */
    #[ORM\Column(length: 255)]
    #[Groups(['task:read'])]
    private ?string $title = null;

    /**
     * Name oder Nummer des Projekts, zu der diese Aufgabe gehört.
     */
    #[ORM\Column(length: 255)]
    #[Groups(['task:read','task:write'])]
    private ?string $project = null;

    /**
     * Ausführliche Beschreibung der Aufgabe oder ergänzende Informationen.
     */
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['task:read'])]
    private ?string $text = null;

    /**
     * Status der Aufgabe - zugeordneter Datensatz der Status-Entity.
     */
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['task:read','task:write'])]
    private ?Status $status = null;

    /**
     * Zugeordnete Oberaufgabe - falls existierend. Optional.
     */
    #[ORM\ManyToOne(targetEntity: Task::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: 'parent_id', nullable: true)]
    #[Groups(['task:read'])]
    private ?self $parent = null;

    /**
     * Priorität der Aufgabe - zugeordneter Datensatz der Priority-Entity.
     */
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['task:read'])]
    private ?Priority $priority = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    public function getProject(): ?string
    {
        return $this->project;
    }

    public function setProject(?string $project): void
    {
        $this->project = $project;
    }

    /**
     * @return string|null
     */
    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): void
    {
        $this->text = $text;
    }

    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public function setStatus(?Status $status): void
    {
        $this->status = $status;
    }

    public function getParent(): ?Task
    {
        return $this->parent;
    }

    public function setParent(?Task $parent): void
    {
        $this->parent = $parent;
    }

    public function getPriority(): ?Priority
    {
        return $this->priority;
    }

    public function setPriority(?Priority $priority): static
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * Gibt eine Kurzform der Aufgabe aus. Bestehend aus Id, Titel und Anfang des Beschreibungstextes.
     */
    #[Groups('task:read')]
    public function getShortForm(): string
    {
        $shortForm = $this->getId()."|";
        $shortForm .= $this->getTitle()."|";
        $shortForm .= substr($this->getText(),0,25);
        if(strlen($this->getText()) >= 25){
            $shortForm .= "...";
        }
        return $shortForm;
    }

    /**
     * Gibt Titel aus, bei Entity-Verknüpfungen.
     */
    public function __toString(): string
    {
        return $this->getTitle();
    }


}

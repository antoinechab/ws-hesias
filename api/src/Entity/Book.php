<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\BookRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: BookRepository::class)]
#[ApiResource(
    collectionOperations: [
        'get',
        'post',
        'get' => [
            'path' => '/grimoire',
            'status' => 200,
        ],
    ],
    itemOperations: [
        'get',
        'delete',
        'put'
    ],
    denormalizationContext: ['groups' => ['book:write']],
    normalizationContext: ['groups' => ['book:read']],
)]
#[ApiFilter(SearchFilter::class, properties: ['title' => 'partial'])]
#[ApiFilter(DateFilter::class, properties: ['publicationDate'])]
#[ApiFilter(BooleanFilter::class, properties: ['visible'])]
#[ApiFilter(OrderFilter::class, properties: ['title'=>'ASC'])]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["book:write", "book:write"])]
    private $id;

    #[ORM\Column(type: 'integer')]
    #[Groups(["book:write", "book:write"])]
    private $nbPages;

    #[ORM\Column(type: 'datetime')]
    #[Groups(["book:write", "book:write"])]
    private $publicationDate;

    #[ORM\Column(type: 'text', nullable: true)]
    #[Groups(["book:write", "book:write"])]
    private $resum;

    #[ORM\ManyToOne(targetEntity: Author::class, inversedBy: 'books')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["book:read"])]
    private $author;

    #[ORM\ManyToOne(targetEntity: Editor::class, inversedBy: 'books')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["book:read"])]
    private $editor;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["book:write", "book:write"])]
    private $title;

    #[ORM\Column(type: 'boolean')]
    #[Groups(["book:write", "book:write"])]
    private $visible;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbPages(): ?int
    {
        return $this->nbPages;
    }

    public function setNbPages(int $nbPages): self
    {
        $this->nbPages = $nbPages;

        return $this;
    }

    public function getPublicationDate(): ?\DateTimeInterface
    {
        return $this->publicationDate;
    }

    public function setPublicationDate(\DateTimeInterface $publicationDate): self
    {
        $this->publicationDate = $publicationDate;

        return $this;
    }

    public function getResum(): ?string
    {
        return $this->resum;
    }

    public function setResum(?string $resum): self
    {
        $this->resum = $resum;

        return $this;
    }

    public function getAuthor(): ?Author
    {
        return $this->author;
    }

    public function setAuthor(?Author $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getEditor(): ?Editor
    {
        return $this->editor;
    }

    public function setEditor(?Editor $editor): self
    {
        $this->editor = $editor;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getVisible(): ?bool
    {
        return $this->visible;
    }

    public function setVisible(bool $visible): self
    {
        $this->visible = $visible;

        return $this;
    }
}

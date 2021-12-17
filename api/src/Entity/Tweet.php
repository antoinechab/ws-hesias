<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\TweetRepository;
use Doctrine\ORM\Mapping as ORM;
use EasyRdf\Literal\DateTime;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TweetRepository::class)]
#[ApiResource(
    denormalizationContext: ['groups' => ['tweet:write']],
    normalizationContext: ['groups' => ['tweet:read']]
)]
#[ApiFilter(BooleanFilter::class, properties: ['deleted'])]
#[ApiFilter(SearchFilter::class, properties: [
    'subject' => 'ipartial'
])]
class Tweet
{

    const TWEET_TYPE = 1;
    const COMMENT_TYPE = 2;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['tweet:write','tweet:read','user:read'])]
    private $id;

    #[ORM\Column(type: 'text')]
    #[Groups(['tweet:write','tweet:read'])]
    private $subject;

    #[ORM\Column(type: 'datetime', nullable: true)]
    #[Groups(['tweet:write','tweet:read'])]
    private $createdAt;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'tweets')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['tweet:write','tweet:read'])]
    private $author;

    #[ORM\Column(type: 'boolean', nullable: true, options: ["default"=>false])]
    #[Groups(['tweet:write','tweet:read'])]
    private $deleted;

    #[ORM\Column(type: 'boolean', nullable: true, options: ["default"=>false])]
    #[Groups(['tweet:write','tweet:read'])]
    private $fav;

    #[ORM\Column(type: 'boolean', nullable: true, options: ["default"=>false])]
    #[Groups(['tweet:write','tweet:read'])]
    private $reTweet;

    #[ORM\Column(type: 'integer', nullable: true, options: ["default"=>self::TWEET_TYPE])]
    #[Groups(['tweet:write','tweet:read'])]
    private $type;

    public function __construct()
    {
        $this->createdAt = new DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): self
    {
        $this->subject = $subject;

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

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getDeleted(): ?bool
    {
        return $this->deleted;
    }

    public function setDeleted(bool $deleted): self
    {
        $this->deleted = $deleted;

        return $this;
    }

    public function getFav(): ?bool
    {
        return $this->fav;
    }

    public function setFav(bool $fav): self
    {
        $this->fav = $fav;

        return $this;
    }

    public function getReTweet(): ?bool
    {
        return $this->reTweet;
    }

    public function setReTweet(bool $reTweet): self
    {
        $this->reTweet = $reTweet;

        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }
}

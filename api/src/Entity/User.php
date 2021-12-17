<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\ProfilController;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\DocBlock\Tags\Method;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ApiResource(
    collectionOperations:[
        'post',
        'put',
        'update_profile'=> [
            'method'=>"GET",
            'route_name' => 'user_update_profile',
            'controller'=> ProfilController::class,
        ]
    ],
    itemOperations: [
        'get',
        'patch',
        'delete',
        'get_profile'=> [
            'method'=>"GET",
            'route_name' => 'user_get_profile',
            'controller'=> ProfilController::class
        ]
    ],
    denormalizationContext: ['groups' => ['user:write']],
    normalizationContext: ['groups' => ['user:read']]
)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['tweet:read','user:write','user:read'])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['user:write','user:read'])]
    private $firstName;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['user:write','user:read'])]
    private $lastName;

    #[ORM\Column(type: 'datetime')]
    #[Groups(['user:write','user:read'])]
    private $birthDate;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['user:write','user:read'])]
    private $email;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['user:write','user:read'])]
    private $password;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['tweet:read','user:write','user:read'])]
    private $userName;

    #[ORM\OneToMany(mappedBy: 'author', targetEntity: Tweet::class, orphanRemoval: true)]
    #[Groups(['user:read'])]
    private $tweets;

    #[ORM\OneToMany(mappedBy: 'source', targetEntity: Message::class)]
    #[Groups(['user:read'])]
    private $sourceMessages;

    #[ORM\OneToMany(mappedBy: 'target', targetEntity: Message::class, orphanRemoval: true)]
    #[Groups(['user:write','user:read'])]
    private $targetMessages;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'follows')]
    #[Groups(['user:write','user:read'])]
    private $follow;

    #[ORM\OneToMany(mappedBy: 'follow', targetEntity: User::class)]
    #[Groups(['user:write','user:read'])]
    private $follows;

    public function __construct()
    {
        $this->tweets = new ArrayCollection();
        $this->sourceMessages = new ArrayCollection();
        $this->targetMessages = new ArrayCollection();
        $this->follows = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(\DateTimeInterface $birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getUserName(): ?string
    {
        return $this->userName;
    }

    public function setUserName(string $userName): self
    {
        $this->userName = $userName;

        return $this;
    }

    /**
     * @return Collection|Tweet[]
     */
    public function getTweets(): Collection
    {
        return $this->tweets;
    }

    public function addTweet(Tweet $tweet): self
    {
        if (!$this->tweets->contains($tweet)) {
            $this->tweets[] = $tweet;
            $tweet->setAuthor($this);
        }

        return $this;
    }

    public function removeTweet(Tweet $tweet): self
    {
        if ($this->tweets->removeElement($tweet)) {
            // set the owning side to null (unless already changed)
            if ($tweet->getAuthor() === $this) {
                $tweet->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Message[]
     */
    public function getSourceMessages(): Collection
    {
        return $this->sourceMessages;
    }

    public function addSourceMessage(Message $sourceMessages): self
    {
        if (!$this->sourceMessages->contains($sourceMessages)) {
            $this->sourceMessages[] = $sourceMessages;
            $sourceMessages->setSource($this);
        }

        return $this;
    }

    public function removeSourceMessage(Message $sourceMessages): self
    {
        if ($this->sourceMessages->removeElement($sourceMessages)) {
            // set the owning side to null (unless already changed)
            if ($sourceMessages->getSource() === $this) {
                $sourceMessages->setSource(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Message[]
     */
    public function getTargetMessages(): Collection
    {
        return $this->targetMessages;
    }

    public function addTargetMessage(Message $targetMessage): self
    {
        if (!$this->targetMessages->contains($targetMessage)) {
            $this->targetMessages[] = $targetMessage;
            $targetMessage->setTarget($this);
        }

        return $this;
    }

    public function removeTargetMessage(Message $targetMessage): self
    {
        if ($this->targetMessages->removeElement($targetMessage)) {
            // set the owning side to null (unless already changed)
            if ($targetMessage->getTarget() === $this) {
                $targetMessage->setTarget(null);
            }
        }

        return $this;
    }

    public function getFollow(): ?self
    {
        return $this->follow;
    }

    public function setFollow(?self $follow): self
    {
        $this->follow = $follow;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getFollows(): Collection
    {
        return $this->follows;
    }

    public function addFollow(self $follow): self
    {
        if (!$this->follows->contains($follow)) {
            $this->follows[] = $follow;
            $follow->setFollow($this);
        }

        return $this;
    }

    public function removeFollow(self $follow): self
    {
        if ($this->follows->removeElement($follow)) {
            // set the owning side to null (unless already changed)
            if ($follow->getFollow() === $this) {
                $follow->setFollow(null);
            }
        }

        return $this;
    }
}

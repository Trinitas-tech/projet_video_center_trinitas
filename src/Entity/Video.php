<?php

namespace App\Entity;

use App\Entity\Trait\TimestampableTrait;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\VideoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'videos')]
#[ORM\Entity(repositoryClass: VideoRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Video
{
    use TimestampableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: 'video.title.not_blank')]
    #[Assert\Length(
        min: 3,
        max: 50,
        minMessage: 'video.title.min_length',
        maxMessage: 'video.title.max_length'
    )]
    #[Assert\Regex(
        pattern: '/shit/i',
        match: false,
        message: 'video.forbidden_word'
    )]
    private ?string $title = null;

    #[ORM\Column(length: 500)]
    #[Assert\NotBlank(message: 'video.link.not_blank')]
    private ?string $videoLink = null;

    #[ORM\Column(type: 'text')]
    #[Assert\NotBlank(message: 'video.description.not_blank')]
    #[Assert\Length(
        min: 20,
        minMessage: 'video.description.min_length'
    )]
    #[Assert\Regex(
        pattern: '/callypige/i',
        match: false,
        message: 'video.forbidden_word'
    )]
    private ?string $description = null;

    #[ORM\Column]
    private bool $premiumVideo = false;

    #[ORM\ManyToOne(inversedBy: 'videos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getVideoLink(): ?string
    {
        return $this->videoLink;
    }

    public function setVideoLink(string $videoLink): static
    {
        $this->videoLink = $videoLink;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function isPremiumVideo(): bool
    {
        return $this->premiumVideo;
    }

    public function setPremiumVideo(bool $premiumVideo): static
    {
        $this->premiumVideo = $premiumVideo;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}

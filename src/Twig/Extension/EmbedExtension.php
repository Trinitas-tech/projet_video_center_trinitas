<?php

namespace App\Twig\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class EmbedExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('embed', [$this, 'toEmbed']),
            new TwigFilter('youtube_thumbnail', [$this, 'toThumbnail']),
        ];
    }

    /**
     * Convertit un lien YouTube en URL d'intégration, quel que soit son format
     * (watch?v=, youtu.be/, avec ou sans paramètres &list=...).
     */
    public function toEmbed(string $link): string
    {
        if (null !== $id = $this->extractId($link)) {
            return 'https://www.youtube.com/embed/' . $id;
        }

        return str_replace('watch?v=', 'embed/', $link);
    }

    /**
     * URL de la miniature officielle de la vidéo (480x360),
     * ou null si le lien n'est pas reconnu.
     */
    public function toThumbnail(string $link): ?string
    {
        if (null !== $id = $this->extractId($link)) {
            return 'https://img.youtube.com/vi/' . $id . '/hqdefault.jpg';
        }

        return null;
    }

    private function extractId(string $link): ?string
    {
        if (preg_match('/(?:v=|youtu\.be\/|embed\/)([A-Za-z0-9_-]{11})/', $link, $matches)) {
            return $matches[1];
        }

        return null;
    }
}

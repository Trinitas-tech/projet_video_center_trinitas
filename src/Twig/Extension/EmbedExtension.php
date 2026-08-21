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

    public function toEmbed(string $link): string
    {
        return str_replace('watch?v=', 'embed/', $link);
    }

    /**
     * Extrait l'identifiant YouTube du lien et renvoie l'URL de la miniature,
     * ou null si le lien n'est pas reconnu (on affichera alors le lecteur).
     */
    public function toThumbnail(string $link): ?string
    {
        if (preg_match('/(?:v=|youtu\.be\/|embed\/)([A-Za-z0-9_-]{11})/', $link, $matches)) {
            return 'https://img.youtube.com/vi/' . $matches[1] . '/hqdefault.jpg';
        }

        return null;
    }
}

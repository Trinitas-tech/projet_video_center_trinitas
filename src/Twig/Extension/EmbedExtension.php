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
        ];
    }

    public function toEmbed(string $link): string
    {
        return str_replace('watch?v=', 'embed/', $link);
    }
}

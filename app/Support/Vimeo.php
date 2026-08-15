<?php

namespace App\Support;

class Vimeo
{
    /**
     * Normalize a Vimeo page link, player link, or pasted <iframe> embed code
     * into a playable https://player.vimeo.com/video/{id} embed URL.
     */
    public static function embedUrl(?string $link): ?string
    {
        if (! $link) {
            return null;
        }

        if (preg_match('/vimeo\.com\/(?:video\/)?(\d+)/i', $link, $matches)) {
            return "https://player.vimeo.com/video/{$matches[1]}";
        }

        return null;
    }
}

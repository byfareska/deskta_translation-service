<?php declare(strict_types=1);

namespace App\Serializer;

use JetBrains\PhpStorm\Pure;

final class EncodingDetector
{
    public function __construct(
        private array $mimeToFormat
    )
    {
    }

    #[Pure]
    public function detect(string ...$mimeTypes): ?string
    {
        foreach ($mimeTypes as $mimeType) {
            $format = $this->matchFormat($mimeType);

            if ($format !== null) {
                return $format;
            }
        }

        return null;
    }

    private function matchFormat(string $mimeType): ?string
    {
        return $this->mimeToFormat[$mimeType] ?? null;
    }
}
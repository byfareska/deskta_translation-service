<?php declare(strict_types=1);

namespace App\Controller;

use App\Serializer\EncodingDetector;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface as Serializer;
use Symfony\Contracts\Translation\TranslatorInterface as Translator;

final class TranslatorController extends AbstractController
{
    private const DEFAULT_CONTENT_TYPE = 'application/json';
    private const DEFAULT_FORMAT = 'json';

    public function __construct(
        private Translator $translator,
        private Serializer $serializer,
        private EncodingDetector $encodingDetector,
    )
    {
    }

    #[Route('/translate/{lang}/{key}', name: 'translate', methods: ['GET'])]
    public function translate(string $lang, string $key, Request $request): Response
    {
        $contentTypes = $request->getAcceptableContentTypes() ?? [self::DEFAULT_CONTENT_TYPE];
        $format = $this->encodingDetector->detect(...$contentTypes) ?? self::DEFAULT_FORMAT;

        $content = [
            "message" => $this->translator->trans($key, [], null, $lang)
        ];

        return new Response(
            $this->serializer->serialize($content, $format),
            200,
            ['Content-Type' => $contentTypes[0]],
        );
    }
}
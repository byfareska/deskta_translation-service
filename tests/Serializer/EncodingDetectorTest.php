<?php

namespace App\Tests\Serializer;

use App\Serializer\EncodingDetector;
use PHPUnit\Framework\TestCase;

class EncodingDetectorTest extends TestCase
{
    public function detectDataProvider(): array
    {
        return [
            [['text/csv'], 'csv', true],
            [['text/html', 'application/json'], 'json', true],
            [[], null, true],
            [['invalid/format'], 'exe', false],
        ];
    }

    /**
     * @dataProvider detectDataProvider
     */
    public function testDetect(array $mimes, ?string $extension, bool $shouldEqual): void
    {
        $encodingDetector = new EncodingDetector([
            'text/csv' => 'csv',
            'application/json' => 'json',
        ]);

        if ($shouldEqual) {
            $this->assertEquals($extension, $encodingDetector->detect(...$mimes), json_encode($mimes) . " should be detected as {$extension}.");
        } else {
            $this->assertNotEquals($extension, $encodingDetector->detect(...$mimes), json_encode($mimes) . " should not be detected as {$extension}.");
        }
    }
}

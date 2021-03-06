<?php
declare(strict_types=1);

namespace Typofixer\Tests;

use PHPUnit\Framework\TestCase;
use Typofixer\Typofixer;
use Typofixer\Fixers\Quotes;

class QuotesTest extends TestCase
{
    public function dataProvider()
    {
        return [
            [
                'Hello "world"',
                'Hello «world»',
            ],
            [
                'Hello "world”',
                'Hello «world»',
            ],
            [
                'Hello ‘world’',
                'Hello «world»',
            ],
            [
                '<p><strong>Hello</strong> "world"</p>',
                '<p><strong>Hello</strong> «world»</p>',
            ],
            [
                '<p><strong>"Hello</strong> world"</p>',
                '<p><strong>«Hello</strong> world»</p>',
            ],
            [
                '<p><strong>´Hello</strong> world´</p>',
                '<p><strong>«Hello</strong> world»</p>',
            ],
            [
                '<p>"<strong>Hello"</strong> world</p>',
                '<p>«<strong>Hello»</strong> world</p>',
            ],
            [
                '<p><strong>"Hello</strong>" world</p>',
                '<p><strong>«Hello</strong>» world</p>',
            ],
            [
                '<em><strong>"Hello world"</strong> "Hello world"</em>',
                '<em><strong>«Hello world»</strong> «Hello world»</em>',
            ],
            [
                '<p><strong>“Hello</strong> \'world\'”</p>',
                '<p><strong>«Hello</strong> “world”»</p>',
            ],
            [
                '<p><strong>\'Hello\'</strong></p>',
                '<p><strong>«Hello»</strong></p>',
            ],
            [
                '<p><strong>"Hello\'s"</strong></p>',
                '<p><strong>«Hello’s»</strong></p>',
            ],
            [
                '<p><strong>Hello\'s "world"</strong></p>',
                '<p><strong>Hello’s «world»</strong></p>',
            ],
            [
                '<p><strong>"Hello’s world"</strong></p>',
                '<p><strong>«Hello’s world»</strong></p>',
            ],
            [
                '<p><strong>"Hellos’ world"</strong></p>',
                '<p><strong>«Hellos’ world»</strong></p>',
            ],
            [
                '<p><strong>“Hellos’ world“</strong></p>',
                '<p><strong>«Hellos’ world»</strong></p>',
            ],
            [
                '<p>Hello 70\'s world</p>',
                '<p>Hello 70’s world</p>',
            ],
        ];
    }

    /**
     * @dataProvider dataProvider
     */
    public function testFixer($text, $expect)
    {
        $result = Typofixer::runFixers($text, new Quotes(['language' => 'es']));

        $this->assertSame($expect, $result);
    }
}

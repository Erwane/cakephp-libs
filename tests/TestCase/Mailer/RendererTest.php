<?php
declare(strict_types=1);

namespace Ecl\Test\TestCase\Mailer;

use Cake\Chronos\Chronos;
use Cake\I18n\FrozenTime;
use Cake\ORM\Entity;
use DateTime;
use Ecl\Mailer\Renderer;
use PHPUnit\Framework\TestCase;

/**
 * Class RendererTest
 *
 * @package Ecl\Test\TestCase\Mailer
 * @coversDefaultClass \Ecl\Mailer\Renderer
 */
class RendererTest extends TestCase
{
    /**
     * @var \Ecl\Mailer\Renderer
     */
    private $renderer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->renderer = new Renderer();
    }

    /**
     * @test
     * @covers ::setAllowedVars
     */
    public function testSetAllowedVarsMerge(): void
    {
        $this->renderer
            ->setAllowedVars(['a'])
            ->setAllowedVars(['b'])
            ->set(['A' => 1, 'B' => 2]);

        self::assertSame(['A' => 1, 'B' => 2], $this->renderer->getVars());
    }

    public function dataGetVars(): array
    {
        return [
            // No data
            [[], [], []],
            // Not allowed vars
            [
                ['TITLE'],
                ['key' => 'value'],
                [],
            ],
            // String value
            [
                ['TITLE'],
                ['title' => 'value'],
                ['TITLE' => 'value'],
            ],
            // Scalar value
            [
                ['VALUE'],
                ['value' => 0.5],
                ['VALUE' => 0.5],
            ],
            // I18nDateTimeInterface
            [
                ['DATE'],
                ['DATE' => new FrozenTime('now')],
                ['DATE' => '2021-01-02 15:30:25'],
            ],
            // Link in array
            [
                ['ARY_LINK'],
                ['ary' => ['link' => 'https://url.com/page.php?q=<tag>']],
                ['ARY_LINK' => 'https://url.com/page.php?q=&lt;tag&gt;'],
            ],
            // All cases
            [
                [
                    'SUBJECT',
                    'OBJECT_TITLE',
                    'OBJECT_DATE',
                    'OBJECT_STRINGABLE',
                    'ARRAY_OBJECT',
                    'ARRAY_ARRAY',
                ],
                [
                    'subject' => 'Subject',
                    'array' => [
                        'object' => new DateTime('now'),
                        'array' => [],
                    ],
                    'object' => new Entity([
                        'title' => 'Title',
                        'date' => new FrozenTime('now'),
                        'int' => 1,
                        'stringable' => Chronos::now(),
                    ]),
                ],
                [
                     'SUBJECT' => 'Subject',
                     'ARRAY_OBJECT' => null,
                     'ARRAY_ARRAY' => null,
                     'OBJECT_TITLE' => 'Title',
                     'OBJECT_DATE' => '2021-01-02 15:30:25',
                     'OBJECT_STRINGABLE' => '2021-01-02 15:30:25',
                ],
            ],
        ];
    }

    /**
     * @test
     * @covers ::setAllowedVars
     * @covers ::getVars
     * @covers ::_getValue
     * @dataProvider dataGetVars
     */
    public function testGetVars($allowed, $input, $expected)
    {
        $vars = $this->renderer
            ->setAllowedVars($allowed)
            ->set($input)
            ->getVars();

        self::assertSame($expected, $vars);
    }

    /**
     * @test
     * @covers ::render
     */
    public function testRender()
    {
        $content = 'Hello {{USER_NAME}}';

        $output = $this->renderer
            ->setAllowedVars(['user_name'])
            ->set(['user' => new Entity(['name' => 'Testing'])])
            ->render($content, ['text']);

        self::assertSame('Hello Testing', $output['text']);
    }

    public function dataGetVarsQuote(): array
    {
        return [
            // Simple
            ['Testing', 'Testing'],
            // Script/Tag
            [
                '<script src="https://unsecure.com/script.js">',
                '&lt;script src=&quot;https://unsecure.com/script.js&quot;&gt;',
            ],
            // Url
            [
                'https://url.com/page.php?q=<tag>',
                'https://url.com/page.php?q=&lt;tag&gt;',
            ],
        ];
    }

    /**
     * @test
     * @dataProvider dataGetVarsQuote
     * @covers ::render
     */
    public function testGetVarsQuote($var, $expected)
    {
        $output = $this->renderer
            ->setAllowedVars(['var'])
            ->set(['var' => $var])
            ->getVars();

        self::assertSame(['VAR' => $expected], $output);
    }

}

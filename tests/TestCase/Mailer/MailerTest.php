<?php
declare(strict_types=1);

namespace Ecl\Test\TestCase\Mailer;

use Ecl\Mailer\Mailer;
use Ecl\Mailer\Renderer;
use PHPUnit\Framework\TestCase;

/**
 * Class MailerTest
 *
 * @package Ecl\Test\TestCase\Mailer
 * @coversDefaultClass \Ecl\Mailer\Mailer
 */
class MailerTest extends TestCase
{
    /**
     * @var \Ecl\Mailer\Mailer
     */
    private $mailer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mailer = new Mailer();
    }

    /**
     * @test
     * @covers ::getRenderer
     */
    public function testGetRenderer()
    {
        $renderer = $this->mailer->getRenderer();

        self::assertInstanceOf(Renderer::class, $renderer);
    }

    /**
     * @test
     * @covers ::setAllowedVars
     */
    public function testSetAllowedVars()
    {
        $vars = $this->mailer->setAllowedVars(['name'])
            ->setViewVars(['title' => 'Subject', 'name' => 'Name'])
            ->getRenderer()
            ->getVars();

        self::assertSame(['NAME' => 'Name'], $vars);
    }
}

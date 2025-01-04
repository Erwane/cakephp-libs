<?php
declare(strict_types=1);

namespace Ecl\Test\TestCase\Mailer;

use Ecl\Mailer\Mailer;
use Ecl\Mailer\Renderer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

/**
 * Mailer tests
 */
#[UsesClass(Renderer::class)]
#[CoversClass(Renderer::class)]
class MailerTest extends TestCase
{
    /**
     * @var \Ecl\Mailer\Mailer
     */
    private Mailer $mailer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mailer = new Mailer();
    }

    public function testGetRenderer()
    {
        $renderer = $this->mailer->getRenderer();

        self::assertInstanceOf(Renderer::class, $renderer);
    }

    public function testSetAllowedVars()
    {
        $vars = $this->mailer->setAllowedVars(['name'])
            ->setViewVars(['title' => 'Subject', 'name' => 'Name'])
            ->getRenderer()
            ->getVars();

        self::assertSame(['NAME' => 'Name'], $vars);
    }
}

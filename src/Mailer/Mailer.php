<?php
declare(strict_types=1);

namespace Ecl\Mailer;

use Cake\Mailer\Mailer as CakeMailer;
use Cake\Mailer\Renderer as CakeMailerRenderer;

/**
 * Class Mailer
 *
 * @package Ecl\Mailer
 */
class Mailer extends CakeMailer
{
    /**
     * Get email renderer.
     *
     * @return \Ecl\Mailer\Renderer
     */
    public function getRenderer(): CakeMailerRenderer
    {
        if ($this->renderer === null) {
            $this->renderer = new Renderer();
        }

        return $this->renderer;
    }

    /**
     * Set allowed vars in renderer
     *
     * @param  array $vars allowed vars keys
     * @return self
     */
    public function setAllowedVars(array $vars): self
    {
        $this->getRenderer()->setAllowedVars($vars);

        return $this;
    }
}

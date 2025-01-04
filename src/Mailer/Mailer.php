<?php
declare(strict_types=1);

/**
 * CakePHP Erwane libs
 * Copyright (c) Erwane BRETON
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright   Copyright (c) Erwane BRETON
 * @see         https://github.com/Erwane/cakephp-libs
 * @license     https://opensource.org/licenses/mit-license.php MIT License
 */
namespace Ecl\Mailer;

use Cake\Mailer\Mailer as CakeMailer;
use Cake\Mailer\Renderer as CakeMailerRenderer;

/**
 * Class Mailer
 */
class Mailer extends CakeMailer
{
    /**
     * Get email renderer.
     *
     * @return \Ecl\Mailer\Renderer
     * @noinspection PhpMissingParentCallCommonInspection
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
     * @param array $vars allowed vars keys
     * @return self
     */
    public function setAllowedVars(array $vars): self
    {
        $this->getRenderer()->setAllowedVars($vars);

        return $this;
    }
}

<?php
declare(strict_types=1);

namespace Ecl\Mailer;

use Cake\Core\App;
use Cake\Mailer\Exception\MissingMailerException;

/**
 * Trait MailerAwareTrait
 *
 * @package Ecl\Mailer
 */
trait MailerAwareTrait
{
    /**
     * get Mailer set app Email instead of Cake Email
     *
     * @param  string $name Email instance.
     * @param  \Ecl\Mailer\Email|null $email specifique email object
     * @return \Cake\Mailer\Mailer
     */
    protected function getMailer($name, ?Email $email = null)
    {
        if ($email === null) {
            $email = new Email();
        }

        $className = App::className($name, 'Mailer', 'Mailer');

        if (empty($className)) {
            throw new MissingMailerException(compact('name'));
        }

        return new $className($email);
    }
}

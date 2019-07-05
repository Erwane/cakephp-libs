<?php
namespace Ecl\Mailer;

use Cake\Core\App;
use Cake\Mailer\Exception\MissingMailerException;

trait MailerAwareTrait
{
    /**
     * get Mailer set app Email instead of Cake Email
     * @param null $name Email instance.
     * @param \Cake\Mailer\Mailer|null $email specifique email object
     * @return \Cake\Mailer\Mailer
     * @throws \Cake\Mailer\Exception\MissingMailerException if undefined mailer class.
     */
    protected function getMailer($name, Email $email = null)
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

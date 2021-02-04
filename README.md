# cakephp-libs

## Mailer

Mailer class are mades to simplify the customization of e-mail templates.

Imagine you want to allow your App users or admins to customize theirs e-mails. With this classes, you can set some allowedVars in template and users can use it with `{{USER_NAME}}` syntax in email.

All vars need to be allowed with `setAllowedVars()` and are quoted. No injection risk.

### Mailer

```php
use Ecl\Mailer\Mailer;
use Cake\ORM\Entity;

$mailer = new Mailer();
$mailer
    ->setAllowedVars(['USER_NAME'])
    ->setViewVars([
        'user' => new Entity(['name' => 'User Name']),
    ])
    ->setEmailFormat('text')
    ->deliver('Hello {{USER_NAME}}');
```

This will send a text e-mail with content below:
```
Hello User Name
```

This, work with reusable Mailer and templates too.
```php
namespace App\Mailer;

use Ecl\Mailer\Mailer;

class UserMailer extends Mailer
{
    public function welcome($user)
    {
        $this
            ->setTo($user->email)
            ->setSubject(sprintf('Welcome %s', $user->name))
            ->setAllowedVars(['USER_NAME'])
            ->set(['user' => $user]);
    }
}

// templates/email/html/welcome.php
<p>Hi {{USER_NAME}}</p>
```

The Mailer add one new method `setAllowedVars(array): self`, required for template var replacement.

### Renderer

The rendered can be used without `Ecl\Mailer\Mailer` if you want to pre-fill a wysiwyg textarea.

```php
use Ecl\Mailer\Renderer;

$invoice = $this->Invoices->get(1, ['contain' => ['Customers']]);

// Get template from DB (or templates dir)
/** @var \App\Model\Entity\EmailTemplate $emailTemplate */
$emailTemplate = $this->EmailTemplates
    ->find()
    ->where(['type' => 'invoice_send'])
    ->first();

$body = '';
if ($emailTemplate && $emailTemplate->body) {
    $renderer = new Renderer();
    $rendered = $renderer
        ->setAllowedVars([
            'INVOICE_NUM',
            'CUSTOMER_TITLE', 
        ])
        ->set([
            'invoice' => $invoice, 
            'customer' => $invoice->customer,
        ])
        ->render($emailTemplate->body, ['html']);

    $body = $rendered['html'];
}

```
`$body` now contain the formatted body e-mail with all allowed vars replaced by values in entities.

```html
<!-- Template -->
<p>Hi {{CUSTOMER_TITLE}}.</p>

<p>
    Please find your invoice <b>{{INVOICE_NUM}}<b> attached.
</p>

<!-- Body for wysiwyg -->
<p>Hi Company name.</p>

<p>
    Please find your invoice <b>FC-202102-01234<b> attached.
</p>
```

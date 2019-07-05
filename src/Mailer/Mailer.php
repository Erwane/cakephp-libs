<?php
namespace Ecl\Mailer;

use Cake\Mailer\Mailer as CakeMailer;

class Mailer extends CakeMailer
{
    /**
     * a button with label and url
     * @param  string $label button label
     * @param  string $url   button url
     * @return html
     */
    public function button($label, $url)
    {
        $template = <<<BUTTON
<div align="center" class="button-container center" style="padding-right: 10px; padding-left: 10px; padding-top:15px; padding-bottom:10px;">
    <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="border-spacing: 0; border-collapse: collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top:15px; padding-bottom:10px;" align="center"><v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="{{BTN_URL}}" style="height:42px; v-text-anchor:middle; width:338px;" arcsize="0%" strokecolor="{{BTN_BG}}" fillcolor="{{BTN_BG}}"><w:anchorlock/><center style="color:{{BTN_TEXT}}; font-family:Arial, \'Helvetica Neue\', Helvetica, sans-serif; font-size:16px;"><![endif]-->
    <a href="{{BTN_URL}}" target="_blank" style="display: inline-block;text-decoration: none;-webkit-text-size-adjust: none;text-align: center;color: {{BTN_TEXT}}; background-color: {{BTN_BG}}; border-radius: 0px; -webkit-border-radius: 0px; -moz-border-radius: 0px; max-width: 338px; width: 158px; width: 60%; border-top: 0px solid transparent; border-right: 0px solid transparent; border-bottom: 0px solid transparent; border-left: 0px solid transparent; padding-top: 5px; padding-right: 20px; padding-bottom: 5px; padding-left: 20px; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif;mso-border-alt: none">
        <span style="font-size:16px;line-height:32px;">
            {{BTN_LABEL}}
        </span>
    </a>
    <!--[if mso]></center></v:roundrect></td></tr></table><![endif]-->
</div>
BUTTON;

        return $this->_render($template, ['BTN_LABEL' => $label, 'BTN_URL' => $url]);
    }
}

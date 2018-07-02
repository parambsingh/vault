<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Mailer\Email;
use Cake\Network\Exception\NotFoundException;
use App\Mailer\Transport\CustomTransport;

class EmailManagerComponent extends Component {

    private $emailResponse;

    public function sendEmail($options = []) {
        $this->emailResponse['error'] = true;
        $siteUrl = $this->request->scheme() . '://' . $this->request->host();
        $defaultOptions = [
            'template' => 'deafult',
            'layout' => 'default',
            'emailFormat' => 'both',
            'to' => null,
            'cc' => null,
            'from' => [FROM_EMAIL => SITE_TITLE],
            'sender' => [FROM_EMAIL => SITE_TITLE],
            'subject' => SITE_TITLE,
            'viewVars' => [
                'logo' => SITE_URL . "/img/vault_logo.png",
                'appName' => SITE_TITLE,
                'appUrl' => $siteUrl
            ]
        ];

        if (!empty($options['viewVars'])) {
            $options['viewVars'] = array_merge($defaultOptions['viewVars'], $options['viewVars']);
        }
        if (!empty($options['from'])) {
            $options['from'] = array_merge($defaultOptions['from'], $options['from']);
        }
        if (!empty($options['sender'])) {
            $options['sender'] = array_merge($defaultOptions['sender'], $options['sender']);
        }
        $finalOptions = array_merge($defaultOptions, $options);

        extract($finalOptions);
        $hasDestination = false;
        try {
            $email = new Email();
            $email->from($from);
            $email->template($template, $layout);
            if ($to != null) {
                if (filter_var($to, FILTER_VALIDATE_EMAIL)) {
                    $email->to($to);
                    $hasDestination = true;
                } else {
                    $hasDestination = false;
                }
            }
            if ($cc != null) {
                if (filter_var($cc, FILTER_VALIDATE_EMAIL)) {
                    $email->cc($cc);
                    $hasDestination = true;
                } else {
                    if (!$hasDestination)
                        $hasDestination = false;
                }
            }

            if ($sender != null) {
                $email->sender(array_keys($sender)[0], array_Values($sender)[0]);
            }

            $email->emailFormat($emailFormat);
            $email->subject($subject);
            $email->viewVars($viewVars);
            if ($hasDestination) {
                $this->emailResponse['error'] = false;
                $this->emailResponse['status'] = 'Email Sent';
                $email->send();
            } else {
                $this->emailResponse['status'] = 'Email did not send, destination email not found';
            }
        } catch (Exception $e) {
            throw new NotFoundException(__('Destination email not found'));
        }
        return $this->emailResponse;
    }

}

?>

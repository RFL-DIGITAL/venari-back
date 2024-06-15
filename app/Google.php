<?php

namespace App;

use Google_Client;

class Google
{
    private string $SECRETS_PATH = __DIR__.'\secrets.json';


    public function client()
    {
        $client = new Google_Client();
        $client->setAuthConfig($this->SECRETS_PATH);
        $client->setClientId('789109854481-se2ttlco5kh487ne4vcjkhv9rhpogj3a.apps.googleusercontent.com');
        $client->setClientSecret('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');
        $client->setRedirectUri('http://localhost:5173/hr/calendar');
        $client->setScopes('https://www.googleapis.com/auth/calendar.app.created');
        $client->setApprovalPrompt('force');
        $client->setAccessType('offline');
        return $client;
    }
}

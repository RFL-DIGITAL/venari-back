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
        $client->setClientId(env('GOOGLE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
        $client->setRedirectUri(env('GOOGLE_REDIRECT_URL'));
        $client->setScopes(explode(',', env('GOOGLE_SCOPES')));
        $client->setApprovalPrompt(env('GOOGLE_APPROVAL_PROMPT'));
        $client->setAccessType(env('GOOGLE_ACCESS_TYPE'));
        return $client;
    }
}

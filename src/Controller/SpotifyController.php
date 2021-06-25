<?php

namespace App\Controller;
use Cake\Http\Response;
use Cake\Http\Client;

class SpotifyController extends AppController
{
    public function index()
    {

    }

    public function login()
    {
        $client_id="e2b133fbed154e4da76e32c74c8fd751";
        $redirect_uri= "http://localhost:8765/login/vali";
        $scopes = "user-read-private user-read-email";
        $url= "https://accounts.spotify.com/authorize";
        $urlFinal = $url . '?response_type=code' . '&client_id=' . $client_id . ('&scope=' . $scopes . '&redirect_uri=' . $redirect_uri);
        $url2= $urlFinal;
        $link = new Client();
        $response = $link->get($url2,['q' => 'widget'],['redirect' => '1']);
        $this->autoRender = false;
        echo $response->getStringBody();
    }

}
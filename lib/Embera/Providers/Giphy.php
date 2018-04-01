<?php

namespace Embera\Providers;


class Giphy extends \Embera\Adapters\Service
{
    /** inline {@inheritdoc} */
    protected $apiUrl = '';
    protected $regex = "~https?://(?|media\\.giphy\\.com/media/([^ /]+)/giphy\\.gif|i\\.giphy\\.com/([^ /]+)\\.gif|giphy\\.com/gifs/(?:.*-)?([^ /]+))~i";

    /** inline {@inheritdoc} */
    protected function validateUrl()
    {
        return (preg_match($this->regex, $this->url));
    }

    protected function normalizeUrl()
    {
        if (preg_match($this->regex, $this->url, $matches)) {
            //$this->source_url = new \Embera\Url(sprintf('https://giphy.com/gifs/%s',$matches[1]));
            $this->url = new \Embera\Url(sprintf('https://media.giphy.com/media/%s/giphy.gif',$matches[1]));
        }
    }

    public function fakeResponse()
    {
        return array(
            'type' => 'gif',
            'url' => $this->url,
            'provider_name' => 'Giphy',
            'provider_url' => 'http://www.giphy.com/',
            'thumbnail_url' => $this->url,
            'html' => sprintf('<img src="%s" />',$this->url),
        );
    }
}

?>

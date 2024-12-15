<?php

/**
 *
 * AI Labs extension
 *
 * @copyright (c) 2024, privet.fun, https://privet.fun
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace privet\ailabs\controller;

use privet\ailabs\includes\GenericCurl;
use privet\ailabs\includes\GenericController;
use privet\ailabs\includes\resultSubmit;
use privet\ailabs\includes\resultParse;

/*

config:
{
    "url_create": "https://api.useapi.net/v1/mureka/music/create/",
    "url_create_advanced": "https://api.useapi.net/v1/mureka/music/create-advanced/",
    "url_lyrics_generate": "https://api.useapi.net/v1/mureka/music/lyrics-generate/",
    "url_song_id": "https://api.useapi.net/v1/mureka/music/",
    "account": "<Optional Mureka API account, remove if only one account setup with API>",
    "api_key": "<API_KEY>",
    "timeoutAPISec": 600,
    "no_cover": false
}

template:
[quote={poster_name} post_id\{post_id} user_id\{poster_id}]{request}[quote]
{response}
{mp3}
{info}

*/

class mureka extends GenericController
{
    protected $messages = [];
    protected $settings_override = null;

    protected $url = null;
    protected $api_key = null;

    protected $param_song = '--song';
    protected $param_lyrics = '--lyrics';
    protected $param_style = '--style';

    protected $doc_links = [
        'mureka/music/lyrics-generate' => 'https://useapi.net/docs/api-mureka-v1/post-mureka-music-lyrics-generate',
        'mureka/music/create' => 'https://useapi.net/docs/api-mureka-v1/post-mureka-music-create',
        'mureka/music/create-advanced' => 'https://useapi.net/docs/api-mureka-v1/post-mureka-music-create-advanced'
    ];

    /*
        Case 1: https://useapi.net/docs/api-mureka-v1/post-mureka-music-create
        {
            "prompt": "<optional prompt>"
        }

        Request example:
        prompt text

        Case 2: https://useapi.net/docs/api-mureka-v1/post-mureka-music-create-advanced
        {
            "lyrics": "<required lyrics>",
            "desc": <optional descriptions for lyrics/hints>
        }

        Request example:
        --lyrics
        lyrics text line 1
        lyrics text line 2
        lyrics text line 3
        --hints
        hints text line 1
        hints text line 2
    */
    protected function parseTextToMureka($text)
    {
        $result = [];

        if (is_null($text) || trim($text) === '')
            return $result;

        $lines = explode("\n", trim($text));

        $isLyricsSection = false;
        $isDescSection = false;

        $prompt = '';
        $lyrics = '';
        $desc = '';

        foreach ($lines as $line) {
            $lowerTrimmedLine = strtolower(trim($line));

            if ($this->startsWith($lowerTrimmedLine, $this->param_song)) {
                $line = trim(substr(trim($line), strlen($this->param_song)));
                $this->url = $this->cfg->url_lyrics_generate;
            }

            if ($this->startsWith($lowerTrimmedLine, $this->param_lyrics)) {
                $line = trim(substr(trim($line), strlen($this->param_lyrics)));
                $isLyricsSection = true;
                $isDescSection = false;
            }

            if ($this->startsWith($lowerTrimmedLine, $this->param_style)) {
                $line = trim(substr(trim($line), strlen($this->param_style)));
                $isDescSection = true;
                $isLyricsSection = false;
            }

            if (!empty($line)) {
                if (!$isLyricsSection && !$isDescSection) {
                    // Case 1: prompt 
                    $prompt .= ($prompt === '') ? $line : "\n" . $line;
                } elseif ($isLyricsSection) {
                    // Case 2: lyrics 
                    $lyrics .= ($lyrics === '') ? $line : "\n" . $line;
                } elseif ($isDescSection) {
                    // Case 2: lyrics with desc
                    $desc .= ($desc === '') ? $line : "\n" . $line;
                }
            }
        }

        if (!empty($prompt))
            $result['prompt'] = $prompt;

        if (!empty($lyrics))
            $result['lyrics'] = $lyrics;

        if (!empty($desc))
            $result['desc'] = $desc;

        return $result;
    }

    protected function prepare($opts)
    {
        $request = $this->job['request'];

        if (isset($this->cfg->param_song) && !empty($this->cfg->param_song))
            $this->param_song = strtolower($this->cfg->param_song);

        if (isset($this->cfg->param_lyrics) && !empty($this->cfg->param_lyrics))
            $this->param_lyrics = strtolower($this->cfg->param_lyrics);

        if (isset($this->cfg->param_style) && !empty($this->cfg->param_style))
            $this->param_style = strtolower($this->cfg->param_style);

        $payload = $this->parseTextToMureka($request);

        if (isset($this->cfg->url_account) && !empty($this->cfg->url_account))
            $payload['account'] = $this->cfg->url_account;

        return $payload;
    }

    protected function submit($opts): resultSubmit
    {
        $this->api_key = $this->cfg->api_key;
        $this->cfg->api_key = null;

        $api = new GenericCurl($this->api_key);
        $api->debug = $this->debug;

        if (empty($this->url))
            $this->url = isset($opts['lyrics']) && !empty($opts['lyrics']) ? $this->cfg->url_create_advanced : $this->cfg->url_create;

        if (isset($this->cfg->timeoutAPISec))
            $api->setTimeout($this->cfg->timeoutAPISec);

        $result = new resultSubmit();
        $result->response = $api->sendRequest($this->url, 'POST', $opts);
        $result->responseCodes = $api->responseCodes;
        return $result;
    }

    protected function parse(resultSubmit $resultSubmit): resultParse
    {
        /*
            Response HTTP 200:
                {
                    "feed_id": 11223344,
                    "state": 3,
                    "songs": [
                        {
                            "song_id": "user:777-mureka:123456789-song:33445566",
                            "title": "<title>",
                            "version": "1",
                            "duration_milliseconds": 234567,
                            "generate_at": 12345677,
                            "genres": [
                                "electronic",
                                "indie"
                            ],
                            "moods": [
                                "quirky",
                                "angry",
                                "restless"
                            ],
                            "mp3_url": "https://<download link>.mp3",
                            "share_key": "<share key>",
                            "recall": true,
                            "machine_audit_state": 4,
                            "credit_type": 1,
                            "cover": "https://<cover image>.png",
                            "share_link": "https://<share link>"
                        }
                    ]
                }
    
            Response HTTP 400, 401, 500:
                {
                    "error": "<Error message>"
                }
        */

        $json = json_decode($resultSubmit->response, true);

        if (!in_array(200, $resultSubmit->responseCodes)) {
            $this->job['status'] = 'failed';
            if (!empty($json['error']))
                $this->messages = array_merge($this->messages, [$json['error']]);
            else
                $this->messages = array_merge($this->messages, ["Failed with response codes: " . implode(', ', $resultSubmit->responseCodes)]);
        } else {
            $this->job['status'] = 'ok';

            if (isset($json['lyrics']))
                $this->messages = array_merge($this->messages, [$json['lyrics']]);

            if (isset($json['songs']) && is_array($json['songs'])) {
                $json = [
                    'songs' => array_map(function ($song) {
                        return [
                            'song_id' => $song['song_id'],
                            'title' => $song['title'],
                            'version' => $song['version'],
                            'share_link' => $song['share_link'],
                            'cover' => $song['cover'],
                            'genres' => implode(', ', $song['genres']),
                            'moods' => implode(', ', $song['moods']),
                            'mp3_url' => $song['mp3_url']
                        ];
                    }, $json['songs'])
                ];

                $messages = [];

                foreach ($json['songs'] as $song) {
                    $messages[] = "#" . $song['version'] . " [url=" .  $song['share_link'] . "]" . $song['title'] . "[/url]";
                    $messages[] = "[size=85]" . $song['genres'] . " • " . $song['moods'] . "[/size]";
                    $messages[] = "[mp3]" . $song['mp3_url'] . "[/mp3]";
                    $messages = array_merge($messages, $this->getLyrics($song['song_id']));

                    if (isset($this->cfg->no_cover) && !$this->cfg->no_cover)
                        $messages[] = "[img]" . $song['cover'] . "[/img]";

                    $messages[] = "";
                }

                $this->messages = array_merge($this->messages, $messages);
            }
        }

        $result = new resultParse();
        $result->json = $json;
        $result->message = empty($this->messages) ? null : implode(PHP_EOL, $this->messages);

        foreach ($this->doc_links as $key => $value)
            if (strpos($this->url, $key) !== false)
                $result->info = "[url=" . $value . "]" . $key . "[/url]";

        return $result;
    }

    protected function getLyrics($song_id)
    {
        $api = new GenericCurl($this->api_key);
        $api->debug = $this->debug;
        $this->cfg->api_key = null;

        $response = $api->sendRequest($this->cfg->url_song_id . "" . $song_id, 'GET');
        $json = json_decode($response, true);

        $result = [];

        // https://useapi.net/docs/api-mureka-v1/get-mureka-music-song_id
        if (isset($json['song']))
            if (isset($json['song']['lyrics']) && is_array($json['song']['lyrics'])) {
                foreach ($json['song']['lyrics'] as $lyric) {
                    if (isset($lyric['rows']) && is_array($lyric['rows'])) {
                        if (isset($lyric['user_input_tag']) && !empty($lyric['user_input_tag']))
                            $result[] = $lyric['user_input_tag'];
                        foreach ($lyric['rows'] as $row) {
                            if (isset($row['text'])) {
                                $result[] = $row['text'];
                            }
                        }
                    }
                }
            }

        return $result;
    }
}

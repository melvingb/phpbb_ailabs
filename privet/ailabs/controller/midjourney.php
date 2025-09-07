<?php

/**
 *
 * AI Labs extension
 *
 * @copyright (c) 2023-2025, privet.fun, https://privet.fun
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace privet\ailabs\controller;

/*

// How to get api token and configure Discord 
// https://useapi.net/docs/start-here 

config: 

{
    "url_imagine": "https://api.useapi.net/v2/jobs/imagine",
    "url_button": "https://api.useapi.net/v2/jobs/button",
    "url_seed": "https://api.useapi.net/v2/jobs/seed_async",
    "api_key": "<API_KEY>",
    "channel": "optional|your-discord-channel-id",
    "maxJobs": 3,
    "retryCount": 80,
    "timeoutBeforeRetrySec": 15,
    "image_relax": true,
    "video_relax": true
}

template:

[quote={poster_name} post_id={post_id} user_id={poster_id}]{request}[/quote]
{response}
{images}
{mp4}
{info}

*/

class midjourney extends useapi_controller
{
    protected function setup()
    {
        $this->attachments_ext = 'image/png';
        $this->info_buttons = $this->language->lang('AILABS_MJ_BUTTONS');
        $this->callback_route = 'privet_ailabs_midjourney_callback';
        $this->extra_buttons = ['Seed'];
    }

    protected function payload()
    {
        $payload = null;

        $this->log['settings_override'] = '';

        $maxJobs = empty($this->cfg->maxJobs) ? 10 : $this->cfg->maxJobs;

        if (!empty($this->button) && !empty($this->parent_job_id)) {
            $payload = [
                'jobid'     => $this->parent_job_id,
                'replyUrl'  => $this->url_callback,
                'replyRef'  => (string) $this->job_id,
            ];

            if (!empty($this->button) && (strcasecmp($this->button, "SEED") == 0))
                $this->url_post = $this->cfg->url_seed;
            else {
                $this->url_post = $this->cfg->url_button;

                $payload = array_merge(
                    $payload,
                    [
                        'button'    => $this->button,
                        'prompt'    => empty($this->button_prompt) ? null : $this->button_prompt,
                        'maxJobs'   => $maxJobs,
                    ]
                );
            }
        } else {
            $this->url_post = $this->cfg->url_imagine;

            $request = $this->job['request'];

            if (($this->cfg->image_relax && stripos($request, '--video') == false) ||
                ($this->cfg->video_relax && stripos($request, '--video') !== false)
            ) {
                // If --turbo or --fast is present, replace it with --relax (case-insensitive)
                if (stripos($request, '--turbo') !== false) {
                    $request = str_ireplace('--turbo', '--relax', $request);
                } elseif (stripos($request, '--fast') !== false) {
                    $request = str_ireplace('--fast', '--relax', $request);
                } else {
                    // Otherwise, add --relax to the end of the prompt, but only if it's not already there.
                    if (stripos($request, '--relax') === false) {
                        $request .= ' --relax';
                    }
                }
            }

            if ($this->cfg->video_relax)
                $request .= ' --video';

            // We expect to have prompt with at least one alpha-numeric character or emoji
            if (empty($request))
                array_push($this->messages, $this->language->lang('AILABS_NO_PROMPT'));

            // https://useapi.net/docs/api-v2/post-jobs-imagine
            $payload = [
                'channel'   => empty($this->cfg->channel) ? null : $this->cfg->channel,
                'prompt'    => empty($request) ? null : $request,
                'maxJobs'   => $maxJobs,
                'replyUrl'  => $this->url_callback,
                'replyRef'  => (string) $this->job_id,
            ];
        }

        $this->log['settings_override'] =  trim("[url=https://useapi.net/docs/api-v2/post-jobs-" . basename($this->url_post) . "]midjourney/" . basename($this->url_post)  . "[/url]" . PHP_EOL .  $this->log['settings_override']);

        return $payload;
    }
}

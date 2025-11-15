<?php

use App\Helpers\VideoHelper;

if (!function_exists('video_embed_url')) {
    /**
     * Convert video URL to embed format
     *
     * @param string $url
     * @return string
     */
    function video_embed_url($url)
    {
        return VideoHelper::getEmbedUrl($url);
    }
}

if (!function_exists('is_valid_video_url')) {
    /**
     * Check if URL is a valid video URL
     *
     * @param string $url
     * @return bool
     */
    function is_valid_video_url($url)
    {
        return VideoHelper::isValidVideoUrl($url);
    }
}

if (!function_exists('video_platform')) {
    /**
     * Get video platform name
     *
     * @param string $url
     * @return string|null
     */
    function video_platform($url)
    {
        return VideoHelper::getPlatform($url);
    }
}

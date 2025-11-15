<?php

namespace App\Helpers;

class VideoHelper
{
    /**
     * Convert video URL to embed format
     * Supports YouTube and Vimeo
     *
     * @param string $url
     * @return string
     */
    public static function getEmbedUrl($url)
    {
        if (empty($url)) {
            return '';
        }

        // Handle youtube.com/watch?v=VIDEO_ID
        if (preg_match('/youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/', $url, $matches)) {
            return 'https://www.youtube.com/embed/' . $matches[1];
        }

        // Handle youtu.be/VIDEO_ID
        if (preg_match('/youtu\.be\/([a-zA-Z0-9_-]+)/', $url, $matches)) {
            return 'https://www.youtube.com/embed/' . $matches[1];
        }

        // Handle youtube.com/embed/VIDEO_ID (already in embed format)
        if (preg_match('/youtube\.com\/embed\/([a-zA-Z0-9_-]+)/', $url, $matches)) {
            return $url;
        }

        // Handle vimeo.com/VIDEO_ID
        if (preg_match('/vimeo\.com\/(\d+)/', $url, $matches)) {
            return 'https://player.vimeo.com/video/' . $matches[1];
        }

        // Handle player.vimeo.com/video/VIDEO_ID (already in embed format)
        if (preg_match('/player\.vimeo\.com\/video\/(\d+)/', $url, $matches)) {
            return $url;
        }

        // If no pattern matches, return original URL
        return $url;
    }

    /**
     * Check if URL is a valid video URL
     *
     * @param string $url
     * @return bool
     */
    public static function isValidVideoUrl($url)
    {
        if (empty($url)) {
            return false;
        }

        $patterns = [
            '/youtube\.com\/watch\?v=/',
            '/youtu\.be\//',
            '/youtube\.com\/embed\//',
            '/vimeo\.com\/\d+/',
            '/player\.vimeo\.com\/video\//',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $url)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get video platform name
     *
     * @param string $url
     * @return string|null
     */
    public static function getPlatform($url)
    {
        if (empty($url)) {
            return null;
        }

        if (preg_match('/youtube\.com|youtu\.be/', $url)) {
            return 'YouTube';
        }

        if (preg_match('/vimeo\.com/', $url)) {
            return 'Vimeo';
        }

        return null;
    }
}

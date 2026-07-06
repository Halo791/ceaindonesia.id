<?php

namespace App\Support;

class MediaUrl
{
    public static function backgroundVideo(?string $path, string $fallback = '/assets/img/cea/video.mp4'): array
    {
        $path = trim((string) $path);

        if ($path === '') {
            $path = $fallback;
        }

        $youtubeId = self::youtubeId($path);
        if ($youtubeId !== '') {
            return [
                'type' => 'youtube',
                'src' => self::youtubeEmbedSrc($youtubeId),
                'id' => $youtubeId,
            ];
        }

        $driveId = self::googleDriveId($path);
        if ($driveId !== '') {
            return [
                'type' => 'video',
                'src' => self::googleDriveDownloadSrc($driveId),
                'id' => $driveId,
            ];
        }

        return [
            'type' => 'video',
            'src' => self::publicSrc($path),
            'id' => '',
        ];
    }

    public static function heroMedia(?string $path, bool $preferVideo = false, string $fallbackImage = ''): array
    {
        $path = trim((string) $path);

        if ($path === '') {
            $path = $fallbackImage;
        }

        $youtubeId = self::youtubeId($path);
        if ($youtubeId !== '') {
            return [
                'type' => 'youtube',
                'src' => self::youtubeEmbedSrc($youtubeId),
                'id' => $youtubeId,
            ];
        }

        $driveId = self::googleDriveId($path);
        if ($driveId !== '') {
            return [
                'type' => $preferVideo ? 'video' : 'image',
                'src' => $preferVideo
                    ? self::googleDriveDownloadSrc($driveId)
                    : self::googleDriveThumbnailSrc($driveId),
                'id' => $driveId,
            ];
        }

        $isVideo = $preferVideo || (bool) preg_match('/\.(mp4|webm|ogg)(\?.*)?$/i', $path);

        return [
            'type' => $isVideo ? 'video' : 'image',
            'src' => self::publicSrc($path),
            'id' => '',
        ];
    }

    public static function googleDriveId(?string $path): string
    {
        $path = trim((string) $path);

        if ($path === '' || stripos($path, 'drive.google.com') === false) {
            return '';
        }

        if (preg_match('~/file/d/([^/?#]+)~i', $path, $matches) || preg_match('~[?&]id=([^&#]+)~i', $path, $matches)) {
            return rawurldecode($matches[1]);
        }

        return '';
    }

    public static function youtubeId(?string $path): string
    {
        $path = trim((string) $path);

        if ($path === '') {
            return '';
        }

        if (! preg_match('~^[a-z][a-z0-9+.-]*://~i', $path) && preg_match('~^(www\.)?(youtube\.com|youtu\.be|youtube-nocookie\.com)\b~i', $path)) {
            $path = 'https://'.$path;
        }

        $parts = parse_url($path);
        $host = strtolower($parts['host'] ?? '');
        $urlPath = trim($parts['path'] ?? '', '/');
        $segments = $urlPath === '' ? [] : explode('/', $urlPath);

        if (str_ends_with($host, 'youtu.be')) {
            return self::cleanYoutubeId($segments[0] ?? '');
        }

        if (! str_contains($host, 'youtube.com') && ! str_contains($host, 'youtube-nocookie.com')) {
            return '';
        }

        parse_str((string) ($parts['query'] ?? ''), $query);
        if (! empty($query['v'])) {
            return self::cleanYoutubeId((string) $query['v']);
        }

        if (in_array($segments[0] ?? '', ['embed', 'shorts', 'live'], true)) {
            return self::cleanYoutubeId($segments[1] ?? '');
        }

        return '';
    }

    public static function youtubeEmbedSrc(string $youtubeId): string
    {
        $query = http_build_query([
            'autoplay' => '1',
            'mute' => '1',
            'controls' => '0',
            'loop' => '1',
            'playlist' => $youtubeId,
            'playsinline' => '1',
            'rel' => '0',
            'modestbranding' => '1',
            'iv_load_policy' => '3',
            'disablekb' => '1',
            'fs' => '0',
        ]);

        return "https://www.youtube-nocookie.com/embed/{$youtubeId}?{$query}";
    }

    public static function googleDriveDownloadSrc(string $driveId): string
    {
        return 'https://drive.google.com/uc?export=download&id='.rawurlencode($driveId);
    }

    public static function googleDriveThumbnailSrc(string $driveId, int $width = 1600): string
    {
        return 'https://drive.google.com/thumbnail?id='.rawurlencode($driveId).'&sz=w'.$width;
    }

    public static function publicSrc(string $path): string
    {
        return preg_match('/^https?:\/\//i', $path) ? $path : asset(ltrim($path, '/'));
    }

    private static function cleanYoutubeId(string $id): string
    {
        if (preg_match('/^([A-Za-z0-9_-]{6,128})/', $id, $matches)) {
            return $matches[1];
        }

        return '';
    }
}

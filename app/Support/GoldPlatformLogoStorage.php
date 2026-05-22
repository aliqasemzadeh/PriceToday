<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class GoldPlatformLogoStorage
{
    public static function store(TemporaryUploadedFile|UploadedFile $file, string $slug, ?string $oldPath = null): string
    {
        $path = self::pathForSlug($slug);

        if ($oldPath !== null && $oldPath !== $path) {
            Storage::disk('public')->delete($oldPath);
        }

        Storage::disk('public')->put($path, self::toWebp($file));

        return $path;
    }

    public static function syncFilename(string $slug, ?string $oldPath): ?string
    {
        if ($oldPath === null) {
            return null;
        }

        $newPath = self::pathForSlug($slug);

        if ($oldPath === $newPath) {
            return $oldPath;
        }

        if (Storage::disk('public')->exists($oldPath)) {
            Storage::disk('public')->move($oldPath, $newPath);
        }

        return $newPath;
    }

    public static function delete(?string $path): void
    {
        if ($path === null) {
            return;
        }

        Storage::disk('public')->delete($path);
    }

    public static function pathForSlug(string $slug): string
    {
        return 'gold-platforms/logos/'.Str::slug($slug).'.webp';
    }

    private static function toWebp(TemporaryUploadedFile|UploadedFile $file): string
    {
        $sourcePath = $file->getRealPath();

        if ($file->getClientOriginalExtension() === 'webp' || $file->extension() === 'webp') {
            return (string) file_get_contents($sourcePath);
        }

        $mimeType = $file->getMimeType();

        $image = match (true) {
            str_contains((string) $mimeType, 'png') => imagecreatefrompng($sourcePath),
            str_contains((string) $mimeType, 'gif') => imagecreatefromgif($sourcePath),
            default => imagecreatefromjpeg($sourcePath),
        };

        if ($image === false) {
            throw new \RuntimeException('Unable to process uploaded logo.');
        }

        imagepalettetotruecolor($image);
        imagealphablending($image, true);
        imagesavealpha($image, true);

        ob_start();
        imagewebp($image, null, 85);
        imagedestroy($image);

        return (string) ob_get_clean();
    }
}

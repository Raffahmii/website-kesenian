<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ImageUploadService
{
    /**
     * Upload + resize gambar. Return path relative.
     */
    public function uploadImage(UploadedFile $file, string $folder = 'albums', int $maxWidth = 1920): string
    {
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $path = "{$folder}/{$filename}";

        // Baca image pakai Intervention
        $manager = new ImageManager(new Driver());
        $image = $manager->read($file->getRealPath());

        // Resize kalau kelebaran
        if ($image->width() > $maxWidth) {
            $image->scale(width: $maxWidth);
        }

        // Simpan ke storage
        Storage::disk('public')->put(
            $path,
            (string) $image->toJpeg(85) // kompres jadi JPEG quality 85
        );

        return $path;
    }

    /**
     * Upload cover album + buat thumbnail.
     */
    public function uploadCover(UploadedFile $file, string $folder = 'albums/covers'): string
    {
        return $this->uploadImage($file, $folder, 1200);
    }

    /**
     * Upload video (langsung, tanpa processing).
     */
    public function uploadVideo(UploadedFile $file, string $folder = 'albums/videos'): string
    {
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $path = "{$folder}/{$filename}";

        Storage::disk('public')->put(
            $path,
            file_get_contents($file->getRealPath())
        );

        return $path;
    }

    /**
     * Hapus file.
     */
    public function delete(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
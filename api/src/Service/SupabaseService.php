<?php

namespace App\Service;

use App\Exception\SupabaseUploadException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class SupabaseService
{
    public function __construct(
        private HttpClientInterface $httpClient,
        private string $supabaseUrl,
        private string $supabaseApiKey,
        private string $supabaseBucket
    )
    {
    }

    public function uploadFile(UploadedFile $file, string $path): string
    {
        $url = "{$this->supabaseUrl}/storage/v1/object/{$this->supabaseBucket}/{$path}";

        $this->deleteFile($path);

        $response = $this->httpClient->request('POST', $url, [
            'headers' => [
                'apiKey' => $this->supabaseApiKey,
                'Authorization' => 'Bearer ' . $this->supabaseApiKey,
                'Content-Type' => $file->getMimeType(),
            ],
            'body' => file_get_contents($file->getPathname())
        ]);

        if ($response->getStatusCode() > 400) {
            throw new SupabaseUploadException('Error uploading file to Supabase: ' . $response->getContent());
        }

        return "{$this->supabaseUrl}/storage/v1/object/public/{$this->supabaseBucket}/{$path}";
    }

    public function deleteFile(string $path): void
    {
        $url = "{$this->supabaseUrl}/storage/v1/object/{$this->supabaseBucket}/{$path}";

        $response = $this->httpClient->request('DELETE', $url, [
            'headers' => [
                'apiKey' => $this->supabaseApiKey,
                'Authorization' => 'Bearer ' . $this->supabaseApiKey,
            ],
        ]);

        if ($response->getStatusCode() > 400) {
            throw new SupabaseUploadException('Error deleting file from Supabase: ' . $response->getContent());
        }
    }
}

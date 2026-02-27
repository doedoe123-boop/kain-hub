<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class StoreDocumentController extends Controller
{
    /**
     * Allowed document fields that can be downloaded.
     *
     * @var list<string>
     */
    private const ALLOWED_FIELDS = ['business_permit'];

    /**
     * Generate a time-limited signed URL and redirect to the download endpoint.
     */
    public function show(Store $store, string $field): Response
    {
        $this->validateField($field);
        $this->ensureFileExists($store, $field);

        return redirect(URL::temporarySignedRoute(
            'admin.stores.document.download',
            now()->addMinutes(5),
            ['store' => $store->id, 'field' => $field]
        ));
    }

    /**
     * Serve the actual file download (protected by signed middleware).
     */
    public function download(Store $store, string $field): Response
    {
        $this->validateField($field);
        $this->ensureFileExists($store, $field);

        return Storage::disk('local')->download($store->{$field});
    }

    /**
     * Serve the file inline for preview (images / PDFs displayed in browser).
     */
    public function preview(Store $store, string $field): Response
    {
        $this->validateField($field);
        $this->ensureFileExists($store, $field);

        $path = $store->{$field};
        $mime = Storage::disk('local')->mimeType($path);

        return response(Storage::disk('local')->get($path), 200, [
            'Content-Type' => $mime,
            'Content-Disposition' => 'inline',
            'Cache-Control' => 'private, max-age=300',
        ]);
    }

    /**
     * Serve a compliance document inline for preview.
     */
    public function compliancePreview(Store $store, string $key): Response
    {
        $docs = $store->compliance_documents ?? [];

        if (! isset($docs[$key]['path'])) {
            abort(404, 'Document not found.');
        }

        $path = $docs[$key]['path'];

        if (! Storage::disk('local')->exists($path)) {
            abort(404, 'Document not found.');
        }

        $mime = Storage::disk('local')->mimeType($path);

        return response(Storage::disk('local')->get($path), 200, [
            'Content-Type' => $mime,
            'Content-Disposition' => 'inline',
            'Cache-Control' => 'private, max-age=300',
        ]);
    }

    /**
     * Abort if the field is not in the allowed list.
     */
    private function validateField(string $field): void
    {
        if (! in_array($field, self::ALLOWED_FIELDS, true)) {
            abort(404);
        }
    }

    /**
     * Abort if the file does not exist on disk.
     */
    private function ensureFileExists(Store $store, string $field): void
    {
        $path = $store->{$field};

        if (! $path || ! Storage::disk('local')->exists($path)) {
            abort(404, 'Document not found.');
        }
    }
}

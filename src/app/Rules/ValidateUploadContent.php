<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\UploadedFile;

/**
 * Validates that an uploaded file's actual MIME type (via finfo)
 * matches its claimed extension, preventing disguised uploads
 * like malicious.php.jpg or executable files with fake extensions.
 */
class ValidateUploadContent implements ValidationRule
{
    /**
     * Allowed MIME types mapped to safe extensions.
     *
     * @var array<string, list<string>>
     */
    private const ALLOWED_MIMES = [
        'application/pdf' => ['pdf'],
        'image/jpeg' => ['jpg', 'jpeg'],
        'image/png' => ['png'],
        'image/gif' => ['gif'],
        'image/webp' => ['webp'],
    ];

    /**
     * Dangerous patterns to reject regardless of MIME type.
     *
     * @var list<string>
     */
    private const DANGEROUS_PATTERNS = [
        '/\.php\d?$/i',
        '/\.phtml$/i',
        '/\.pl$/i',
        '/\.py$/i',
        '/\.rb$/i',
        '/\.sh$/i',
        '/\.bat$/i',
        '/\.cmd$/i',
        '/\.exe$/i',
        '/\.com$/i',
        '/\.js$/i',
        '/\.svg$/i',    // SVGs can contain JavaScript
        '/\.html?$/i',
        '/\.\w+\.\w+$/', // Double extensions (e.g., file.php.jpg)
    ];

    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! $value instanceof UploadedFile) {
            return;
        }

        $originalName = $value->getClientOriginalName();

        // Check for dangerous filename patterns
        foreach (self::DANGEROUS_PATTERNS as $pattern) {
            if (preg_match($pattern, $originalName)) {
                $fail('The :attribute has a disallowed file name pattern.');

                return;
            }
        }

        // Verify actual MIME type via finfo (not the client-reported type)
        $realMime = $value->getMimeType(); // Uses finfo internally

        if (! array_key_exists($realMime, self::ALLOWED_MIMES)) {
            $fail('The :attribute file type is not allowed. Accepted: PDF, JPEG, PNG.');

            return;
        }

        // Verify extension matches the detected MIME type
        $extension = strtolower($value->getClientOriginalExtension());
        $allowedExtensions = self::ALLOWED_MIMES[$realMime];

        if (! in_array($extension, $allowedExtensions, true)) {
            $fail('The :attribute file extension does not match its content type.');
        }
    }
}

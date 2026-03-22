<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Support\HtmlSanitizer;
use Illuminate\Http\JsonResponse;

class FaqController extends Controller
{
    public function index(): JsonResponse
    {
        $faqs = Faq::query()
            ->active()
            ->get(['id', 'question', 'answer']);

        return response()->json(
            $faqs->map(fn (Faq $faq): array => [
                'id' => $faq->id,
                'question' => strip_tags((string) $faq->question),
                'answer' => HtmlSanitizer::sanitize($faq->answer),
            ])
        );
    }
}

<?php

namespace App\Support;

use DOMDocument;
use DOMElement;
use DOMNode;

class HtmlSanitizer
{
    /**
     * @var array<string, list<string>>
     */
    private const ALLOWED_ATTRIBUTES = [
        'a' => ['href', 'target', 'rel'],
    ];

    /**
     * @var list<string>
     */
    private const ALLOWED_TAGS = [
        'a',
        'br',
        'em',
        'i',
        'li',
        'ol',
        'p',
        'strong',
        'ul',
    ];

    public static function sanitize(?string $html): string
    {
        if (! is_string($html) || trim($html) === '') {
            return '';
        }

        $document = new DOMDocument('1.0', 'UTF-8');
        $wrappedHtml = '<div>'.$html.'</div>';

        libxml_use_internal_errors(true);
        $document->loadHTML(
            mb_convert_encoding($wrappedHtml, 'HTML-ENTITIES', 'UTF-8'),
            LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
        );
        libxml_clear_errors();

        $root = $document->documentElement;

        if (! $root instanceof DOMElement) {
            return strip_tags($html);
        }

        self::sanitizeNode($root);

        return self::innerHtml($root);
    }

    private static function sanitizeNode(DOMNode $node): void
    {
        /** @var list<DOMNode> $children */
        $children = [];

        foreach ($node->childNodes as $child) {
            $children[] = $child;
        }

        foreach ($children as $child) {
            if ($child instanceof DOMElement) {
                $tag = strtolower($child->tagName);

                if (! in_array($tag, self::ALLOWED_TAGS, true)) {
                    self::unwrapNode($child);
                    self::sanitizeNode($node);

                    continue;
                }

                self::sanitizeAttributes($child, $tag);
            }

            self::sanitizeNode($child);
        }
    }

    private static function sanitizeAttributes(DOMElement $element, string $tag): void
    {
        $allowed = self::ALLOWED_ATTRIBUTES[$tag] ?? [];

        if ($element->hasAttributes()) {
            /** @var list<string> $attributeNames */
            $attributeNames = [];

            foreach ($element->attributes as $attribute) {
                $attributeNames[] = $attribute->nodeName;
            }

            foreach ($attributeNames as $attributeName) {
                $normalized = strtolower($attributeName);

                if (
                    str_starts_with($normalized, 'on')
                    || $normalized === 'style'
                    || ! in_array($normalized, $allowed, true)
                ) {
                    $element->removeAttribute($attributeName);
                }
            }
        }

        if ($tag === 'a') {
            $href = trim((string) $element->getAttribute('href'));

            if ($href === '' || ! preg_match('/^(https?:|mailto:|tel:)/i', $href)) {
                $element->removeAttribute('href');
            }

            if ($element->getAttribute('target') === '_blank') {
                $element->setAttribute('rel', 'noopener noreferrer');
            } else {
                $element->removeAttribute('target');
                $element->removeAttribute('rel');
            }
        }
    }

    private static function unwrapNode(DOMElement $element): void
    {
        $parent = $element->parentNode;

        if (! $parent) {
            return;
        }

        while ($element->firstChild) {
            $parent->insertBefore($element->firstChild, $element);
        }

        $parent->removeChild($element);
    }

    private static function innerHtml(DOMNode $node): string
    {
        $html = '';

        foreach ($node->childNodes as $child) {
            $html .= $node->ownerDocument?->saveHTML($child) ?? '';
        }

        return $html;
    }
}

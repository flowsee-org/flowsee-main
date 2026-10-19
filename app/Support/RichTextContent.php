<?php

namespace App\Support;

use DOMDocument;
use DOMElement;
use DOMNode;

final class RichTextContent
{
    private const ALLOWED_TAGS = ['p', 'br', 'h2', 'h3', 'h4', 'strong', 'b', 'em', 'i', 'u', 's', 'ul', 'ol', 'li', 'a', 'blockquote', 'code', 'pre', 'hr', 'img', 'table', 'thead', 'tbody', 'tr', 'th', 'td'];

    public static function sanitize(?string $html): string
    {
        if (! $html) {
            return '';
        }

        $previous = libxml_use_internal_errors(true);
        $document = new DOMDocument('1.0', 'UTF-8');
        $document->loadHTML('<?xml encoding="UTF-8"><div id="rich-content-root">'.$html.'</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();
        libxml_use_internal_errors($previous);

        $root = (new \DOMXPath($document))->query('//*[@id="rich-content-root"]')->item(0);
        if (! $root) {
            return '';
        }

        self::cleanChildren($root);
        $result = '';
        foreach ($root->childNodes as $child) {
            $result .= $document->saveHTML($child);
        }

        return $result;
    }

    private static function cleanChildren(DOMNode $parent): void
    {
        foreach (iterator_to_array($parent->childNodes) as $child) {
            if (! $child instanceof DOMElement) {
                if ($child->nodeType === XML_COMMENT_NODE) {
                    $parent->removeChild($child);
                }
                continue;
            }

            $tag = strtolower($child->tagName);
            if (in_array($tag, ['script', 'style', 'iframe', 'object', 'embed', 'svg', 'math'], true)) {
                $parent->removeChild($child);
                continue;
            }

            self::cleanChildren($child);
            if (! in_array($tag, self::ALLOWED_TAGS, true)) {
                while ($child->firstChild) {
                    $parent->insertBefore($child->firstChild, $child);
                }
                $parent->removeChild($child);
                continue;
            }

            foreach (iterator_to_array($child->attributes) as $attribute) {
                $name = strtolower($attribute->name);
                $keep = ($tag === 'a' && in_array($name, ['href', 'title'], true))
                    || ($tag === 'img' && in_array($name, ['src', 'alt', 'title'], true))
                    || (in_array($tag, ['td', 'th'], true) && in_array($name, ['colspan', 'rowspan'], true) && preg_match('/^[1-9][0-9]?$/', $attribute->value));
                if ($tag === 'img' && $name === 'src') {
                    $keep = self::safeLink($attribute->value) && in_array(strtolower(parse_url($attribute->value, PHP_URL_SCHEME) ?? ''), ['http', 'https', ''], true);
                }
                if (in_array($tag, ['p', 'h2', 'h3', 'h4'], true) && $name === 'style') {
                    $keep = (bool) preg_match('/^text-align:\s*(left|right|center|justify);?$/i', trim($attribute->value));
                }
                if (! $keep || ($name === 'href' && ! self::safeLink($attribute->value))) {
                    $child->removeAttributeNode($attribute);
                }
            }
        }
    }

    private static function safeLink(string $url): bool
    {
        $url = trim($url);
        if ($url === '' || preg_match('/[\x00-\x20\\\\]/', $url)) {
            return false;
        }

        $scheme = parse_url($url, PHP_URL_SCHEME);
        if ($scheme === null) {
            return ! str_starts_with($url, '//');
        }

        return in_array(strtolower($scheme), ['http', 'https', 'mailto'], true);
    }
}

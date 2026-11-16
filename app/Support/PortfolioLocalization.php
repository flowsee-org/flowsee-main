<?php

namespace App\Support;

use Illuminate\Support\Facades\Lang;

class PortfolioLocalization
{
    private const TEXT_FIELDS = [
        'name', 'description', 'service', 'title', 'lead', 'eyebrow', 'client_name',
        'industry', 'services_provided', 'cover_caption', 'index_label', 'band_caption',
        'step_number', 'caption', 'alt',
    ];

    /** Localize presentation data only; preserve model values, media and collection order. */
    public static function localize(array $projects, string $locale): array
    {
        if ($locale !== 'en') {
            return $projects;
        }

        $catalog = Lang::get('portfolio', [], 'en');
        $catalog = is_array($catalog) ? $catalog : [];
        $translate = function (array $items) use (&$translate, $catalog): array {
            foreach ($items as $field => $value) {
                if (is_array($value)) {
                    $items[$field] = $translate($value);
                } elseif (is_string($value) && in_array($field, self::TEXT_FIELDS, true)) {
                    $translated = $catalog[$value] ?? __($value, [], 'en');
                    $text = is_string($translated) ? $translated : $value;
                    if (in_array($field, ['index_label', 'step_number'], true)) {
                        $text = strtr($text, array_combine(preg_split('//u', '۰۱۲۳۴۵۶۷۸۹٠١٢٣٤٥٦٧٨٩', -1, PREG_SPLIT_NO_EMPTY), str_split('01234567890123456789')));
                    }
                    $items[$field] = in_array($field, ['lead', 'description'], true)
                        ? RichTextContent::sanitize($text) : $text;
                }
            }

            return $items;
        };

        return $translate($projects);
    }
}

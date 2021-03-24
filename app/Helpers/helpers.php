<?php

use App\models\Currency;
use App\models\CompanySetting;
use App\models\CustomField;
use Illuminate\Support\Str;

function set_active($path, $active = 'active') {
    return call_user_func_array('Request::is', (array) $path) ? $active : '';
}

function is_url($path) {
    return call_user_func_array('Request::is', (array) $path);
}

function getCustomFieldValueKey(string $type) {
    switch ($type) {
        case 'Input':
            return 'string_answer';
        case 'TextArea':
            return 'string_answer';
        case 'Phone':
            return 'number_answer';
        case 'Url':
            return 'string_answer';
        case 'Number':
            return 'number_answer';
        case 'Dropdown':
            return 'string_answer';
        case 'Switch':
            return 'boolean_answer';
        case 'Date':
            return 'date_answer';
        case 'Time':
            return 'time_answer';
        case 'DateTime':
            return 'date_time_answer';
        default:
            return 'string_answer';
    }
}

function format_money_pdf($money, $currency = null) {
    $money = $money / 100;

    if(!$currency) {
        $currency = Currency::findOrFail(CompanySetting::getSetting('currency', 1));
    }

    $format_money = number_format(
        $money,
        $currency->precision,
        $currency->decimal_separator,
        $currency->thousand_separator
    );

    $currency_with_symbol = '';
    if($currency->swap_currency_symbol) {
        $currency_with_symbol = $format_money.'<span style="font-family: DejaVu Sans;">'.$currency->sysmbol.'</span>';
    } else {
        $currency_with_symbol = '<span style="font-family: DejaVu Sans;">'.$currency->symbol.'</span>'.$format_money;
    }

    return $currency_with_symbol;
}

function clean_slug($model, $title, $id = '') {
    $slug = Str::upper('CUSTOM_'.$model.'_'.Str::slug($title, '_'));

    $allSlugs = getRelatedSlugs($model, $slug, $id);

    if(!$allSlugs->contains('slug', $slug)) {
        return $slug;
    }

    for ($i = 1; $i <= 10; $i++) {
        $newSlug = $slug . '_' . $i;
        if(!$allSlugs->contains('slug', $newSlug)) {
            return $newSlug;
        }
    }

    \Log::info('Can not create a unique slug');
    throw new \Exception('Can not create a unique slug');
}

function getRelatedSlugs($type, $slug, $id = '') {
    return CustomField::select('slug')->where('slug', 'like', $slug . '%')
        ->where('model_type', $type)
        ->where('id', '<>', $id)
        ->get();
}

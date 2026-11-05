<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/guest.php';

Route::get('/share-target', function (Request $request) {
    $url = $request->query('url');

    if (blank($url)) {
        $text = $request->query('text', '');

        if (preg_match('/https?:\/\/[^\s<>"\']+/i', $text, $matches)) {
            $url = $matches[0];
        }
    }

    $url = trim((string) $url, " \t\n\r\0\x0B.,;!?)\]");

    $isValidUrl = filter_var($url, FILTER_VALIDATE_URL)
        && in_array(
            strtolower(parse_url($url, PHP_URL_SCHEME) ?? ''),
            ['http', 'https'],
            true
        );

    if (! $isValidUrl) {
        return redirect()
            ->route('guest.check-url.index')
            ->with('error', 'Tautan yang dibagikan tidak valid atau tidak ditemukan.');
    }

    return redirect()->route('guest.check-url.index', [
        'shared_url' => $url,
    ]);
})->name('guest.share-target');

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LocaleController extends Controller
{
    public function setLocale(Request $request, string $locale)
    {
        if (!in_array($locale, ['en', 'de'])) {
            $locale = 'en';
        }

        Session::put('locale', $locale);
        app()->setLocale($locale);

        return redirect()->back();
    }
}


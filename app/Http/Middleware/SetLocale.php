<?php

/**
 * @noinspection PhpUnused
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetLocale
{
    // 设置环境语言
    public function handle(Request $request, Closure $next): mixed
    {
        $locale = request()->header('X-Client-Language', 'en-US');

        if (str_starts_with($locale, 'zh-Hans')) $locale = 'zh-Hans-CN';
        elseif (str_starts_with($locale, 'zh-Hant')) $locale = 'zh-Hant-HK';
        elseif (str_starts_with($locale, 'es')) $locale = 'es';
        else $locale = 'en-US';

        App::setLocale($locale);

        return $next($request);
    }
}

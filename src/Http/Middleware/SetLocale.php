<?php

namespace MichaelNabil230\LaravelMultiLanguage\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use MichaelNabil230\LaravelMultiLanguage\Events\SetLocaleEvent;
use MichaelNabil230\LaravelMultiLanguage\Facades\LaravelMultiLanguage;
use MichaelNabil230\LaravelMultiLanguage\LanguageNegotiator;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): Response  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $fallback = LaravelMultiLanguage::getFallbackLocale();

        $firstUriSegment = $request->segment(1);

        if ($firstUriSegment === null) {
            return $this->redirectToFallback($request, $fallback);
        }

        $locale = $request->wantsJson()
            ? $this->getLocaleFromHeader($request)
            : $firstUriSegment ?? $fallback;

        if (! LaravelMultiLanguage::isSupportedLocale($locale) && ! $request->wantsJson()) {
            return $this->redirectToFallback($request, $fallback);
        }

        App::setLocale($locale);

        event(new SetLocaleEvent($locale));

        return $next($request);
    }

    /**
     * Redirect the request to a URL with the fallback locale prepended.
     */
    protected function redirectToFallback(Request $request, string $fallback): Response
    {
        $segments = $request->segments();

        array_unshift($segments, $fallback);

        return redirect()->to(implode('/', $segments));
    }

    /**
     * Get the locale using the LanguageNegotiator.
     */
    protected function getLocaleFromHeader(Request $request): ?string
    {
        return app(LanguageNegotiator::class)
            ->getPreferredLanguage($request->header('Accept-Language', ''));
    }
}

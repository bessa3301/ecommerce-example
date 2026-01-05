<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'app';

    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    public function share(Request $request): array
    {
        $cart = null;
        if ($request->user()) {
            $userCart = $request->user()->getOrCreateCart();
            $userCart->load(['items.product']);
            $cart = [
                'items_count' => $userCart->items->sum('quantity'),
                'total' => $userCart->total,
            ];
        }

        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user() ? [
                    'id' => $request->user()->id,
                    'name' => $request->user()->name,
                    'email' => $request->user()->email,
                    'is_admin' => $request->user()->isAdmin(),
                ] : null,
            ],
            'cart' => $cart,
            'locale' => app()->getLocale(),
            'translations' => [
                'common' => trans('common'),
            ],
        ];
    }
}

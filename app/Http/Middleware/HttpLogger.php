<?php

namespace App\Http\Middleware;

use App\Models\HttpHeader;
use Closure;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;

class HttpLogger
{

    /**
     * @param string $username
     * @return string
     * @todo Вынести в сервис
     */
    private function processPhone(string $username): string
    {
        $phone = preg_replace('/[^0-9]/', '', $username);
        if ($phone != null && $phone[0] == '8') {
            $phone[0] = '7';
        }
        return $phone;
    }

    protected function prepareForValidation(string $username): string
    {
        if (str_contains($username, '@') === false)
            return $this->processPhone($username);
        return $username;
    }


    public function handle(Request $request, Closure $next)
    {
        $user = null;
        $username = $this->prepareForValidation($request->get('username'));
        $password = $request->get('password');
        $remember = $request->has('remember');

        if (\Auth::attempt(['email' => $username, 'password' => $password], $remember) ||
            \Auth::attempt(['phone' => $username, 'password' => $password], $remember)) {
            $user = \Auth::user();
        }

        if ($user) {
            $log = new HttpHeader([
                'ip' => $request->ip(),
                'headers' => Crypt::encryptString(json_encode($request->header())),
                'user_id' => $user->id,
            ]);
            $log->save();
        }

        return $next($request);
    }

    public function terminate($request, $response)
    {
    }
}

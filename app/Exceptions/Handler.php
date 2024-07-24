<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Support\Facades\App;
use Illuminate\Session\TokenMismatchException;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        if ($request->is('admin/*')) {
            session(['url.intended' => $request->url()]);
            return redirect()->route('login');
        }
        if ($request->is('technician/*')) {
            session(['url.intended' => $request->url()]);
            return redirect()->route('technician.login.index');
        }
        if ($request->is('customer/*')) {
            session(['url.intended' => $request->url()]);
            return redirect()->route('customer.showlogin');
        }

        return redirect()->guest('/');
    }

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            if (app()->bound('sentry') && App::environment('production')) {
                app('sentry')->captureException($e);
            }
          });
    }

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof TokenMismatchException) {
            return redirect()->back()->withInput($request->except('_token'))->with('token_error', 'Sorry, your session seems to have expired. Please try again.');
        }

        return parent::render($request, $exception);
    }

}

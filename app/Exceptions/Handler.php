<?php

namespace App\Exceptions;

use Exception;
use App\Common\Enum\HttpCode;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof AuthenticationException) {
            if ($request->expectsJson()) return ajaxError('您未登录', HttpCode::UNAUTHORIZED);
            if ( in_array('admin', $exception->guards() ))
            {
                return redirect('/admin/login');
            }elseif( in_array('agent', $exception->guards()) ){
                return redirect('/agent/login');
            }elseif( in_array('user', $exception->guards()) ) {
                return redirect('/user/login');
            }

        }

        return parent::render($request, $exception);
    }
}

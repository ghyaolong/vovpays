<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Validation\ValidationException;

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

        // 登录验证
        if ($exception instanceof AuthenticationException) {
            // 判断是否返回json
            if ($request->expectsJson()) return ajaxError('您未登录');

            if ( in_array('admin', $exception->guards() ))
            {
                return redirect('/admin/login');
            }elseif( in_array('agent', $exception->guards()) ){
                return redirect('/agent/login');
            }elseif( in_array('user', $exception->guards()) ) {
                return redirect('/user/login');
            }
        }else if( $exception instanceof ValidationException) { // 表单验证错误
            if( $request->expectsJson() )
            {
                $error = array_flatten($exception->errors());
                return ajaxError(array_get($error,0));
            }

        }else if($exception instanceof TokenMismatchException) {
            if( $request->expectsJson() )
            {
                return ajaxError('非法操作');
            }
        }
        return parent::render($request, $exception);
    }
}

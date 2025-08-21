<?php

namespace App\Exceptions;
use App\Models\SystemErrorLogs;
use App\Mail\SuperAdminEmail\Error;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\ErrorHandler\ErrorRenderer\HtmlErrorRenderer;
use Symfony\Component\ErrorHandler\Exception\FlattenException;
use App\Exceptions\CustomException;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Mail;
use Throwable;
use Auth;


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
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
    public function report(Throwable $exception)
    {
             // emails.exception is the template of your email
             // it will have access to the $error that we are passing below

        if ($this->shouldReport($exception)) {
             $this->sendEmail($exception); // sends an email
        }

         return parent::report($exception);

    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        // Handle custom exceptions
        if ($exception instanceof CustomException) {
            return $this->handleCustomException($request, $exception);
        }

        // Handle validation exceptions
        if ($exception instanceof ValidationException) {
            return $this->handleValidationException($request, $exception);
        }

        // Handle model not found exceptions
        if ($exception instanceof ModelNotFoundException || $exception instanceof NotFoundHttpException) {
            return $this->handleNotFoundException($request, $exception);
        }

        // Handle 404 errors gracefully
        if ($this->isHttpException($exception) && $exception->getStatusCode() == 404) {
            return response()->view('error.error', ['message' => 'Page not found'], 404);
        }

        // Default handling for production vs development
        if (!env('APP_DEBUG', false)) {
            return response()->view('error.error', ['message' => 'Something went wrong'], 500);
        } else {
            return parent::render($request, $exception);
        }
    }

    /**
     * Handle custom exceptions
     */
    private function handleCustomException($request, CustomException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'error' => $exception->getErrorCode(),
                'message' => $exception->getMessage()
            ], $exception->getStatusCode());
        }

        // Handle specific exception types with custom views
        $errorCode = $exception->getErrorCode();
        if ($errorCode === 'SCHOOL_BLOCKED') {
            return response()->view('error.school_blocked', [], 403);
        }
        if ($errorCode === 'USER_BLOCKED') {
            return response()->view('error.user_blocked', [], 403);
        }

        return response()->view('error.error', [
            'message' => $exception->getMessage()
        ], $exception->getStatusCode());
    }

    /**
     * Handle validation exceptions
     */
    private function handleValidationException($request, ValidationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'error' => 'VALIDATION_FAILED',
                'message' => 'Validation failed',
                'errors' => $exception->errors()
            ], 422);
        }

        return parent::render($request, $exception);
    }

    /**
     * Handle not found exceptions
     */
    private function handleNotFoundException($request, $exception)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'error' => 'NOT_FOUND',
                'message' => 'Resource not found'
            ], 404);
        }

        return response()->view('error.error', [
            'message' => 'The requested resource was not found'
        ], 404);
    }

    public function sendEmail(Throwable $exception)
    {
       
       try {
            $e = FlattenException::create($exception);
            $handler = new HtmlErrorRenderer(true); // boolean, true raises debug flag...
            $css = $handler->getStylesheet();
            $content = $handler->getBody($e);
           
           if(Auth::user()){
            $errorData = SystemErrorLogs::updateOrCreate(
                [
                    'user_id' =>Auth::user()->id,
                    'line' =>  $e->getLine(),
                    'file' => $e->getFile(),
                    'error_status' =>$e->getstatusCode().' '.  $e->getstatusText(),
                    'url' => \Request::fullUrl(),
                    
                ],
                [
                    'user_id' =>Auth::user()->id,
                    'line' =>  $e->getLine(),
                    'file' => $e->getFile(),
                    'error_status' =>$e->getstatusCode().' '.  $e->getstatusText(),
                    'url' => \Request::fullUrl(),
                    'status' => 0,
                    'updated_at'=>time(),
                ]);
           }
        
            // $errorData = SystemErrorLogs::create(
            // [
            // 'user_id' =>Auth::user()->id,
            // 'line' =>  $e->getLine(),
            // 'file' => $e->getFile(),
            // 'status' =>$e->getstatusCode().' '.  $e->getstatusText(),
            // 'url' => \Request::fullUrl(),
            // ]);
           
            // \Mail::send('email.super-admin.error', compact('css','content'), function ($message) {
            //     $message->to(['m.tariq.sarfraz.007@gmail.com'])
            //     ->subject('Exception: ' . \Request::fullUrl());
            // });
            
           
        } catch (Throwable $exception) {
            if(strlen(\Request::fullUrl())>50){
                $url = substr(\Request::fullUrl(), 0, 150);
            }else{
                $url = \Request::fullUrl();
            }
            if(Auth::user()){
                $errorData = SystemErrorLogs::updateOrCreate(
                    [
                        'user_id' =>Auth::user()->id,
                        'file' => $exception,
                        'error_status' => '500 Possible Error Datatable Or uncaught Issue',
                        'url' => $url,
                        
                    ],
                    [
                        'user_id' =>Auth::user()->id,
                        'file' => $exception,
                        'error_status' => '500 Possible Error Datatable Or uncaught Issue',
                        'url' => $url,
                        'status' => 0,
                        'updated_at'=>time(),
                    ]);
            }
            
            // \Mail::send('email.super-admin.error', compact('css','content'), function ($message) {
            //     $message->to(['m.tariq.sarfraz.007@gmail.com'])
            //     ->subject('Exception: ' . \Request::fullUrl());
            // });
        }
    }




}

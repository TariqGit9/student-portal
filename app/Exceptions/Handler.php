<?php

namespace App\Exceptions;
use App\Models\SystemErrorLogs;
use App\Mail\SuperAdminEmail\Error;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\ErrorHandler\ErrorRenderer\HtmlErrorRenderer;
use Symfony\Component\ErrorHandler\Exception\FlattenException;

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
        
        if(! env('APP_DEBUG', false)){
            return parent::render($request, $exception);
        } else {
            return parent::render($request, $exception);
            return response()->view('error.error');
        }
            // return parent::render($request, $exception);
        
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

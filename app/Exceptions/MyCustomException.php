<?php

namespace App\Exceptions;

use Exception;

class MyCustomException extends Exception
{
    public function render($request)
    {
        $errorMessage = 'No data: 日付の指定を確認してください';
        return view('errors.custom-error', ['errorMessage' => $errorMessage]);

    }
}

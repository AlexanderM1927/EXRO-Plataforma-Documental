<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response as HttpResponse;

class CannotDeleteMyself extends Exception
{
    private $errorMsg = 'No te puedes eliminar a ti mismo';

    /**
     * Report the exception.
     *
     * @return void
     */
    public function report()
    {
        // Additional logic to report the exception, if needed
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @return \Illuminate\Http\Response
     */
    public function render()
    {
        return response()->json((['message' => $this->errorMsg]), HttpResponse::HTTP_BAD_REQUEST);
    }
}

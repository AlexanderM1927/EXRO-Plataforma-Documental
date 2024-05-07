<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response as HttpResponse;

class CannotUploadCompressedFile extends Exception
{
    private $errorMsg = 'Este archivo ha sido previamente compreso, por lo que necesitas abrirlo desde tu navegador web (Ej, Google Chrome), pulsar en el icono de imprimir y en destino guardarlo como pdf y subir el nuevo archivo.';

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

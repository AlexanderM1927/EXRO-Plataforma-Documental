<?php

namespace App\Services;

use App\Exceptions\CannotUploadCompressedFile;
use Illuminate\Http\File as HttpFile;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use setasign\Fpdi\Fpdi;
use setasign\Fpdi\PdfParser\CrossReference\CrossReferenceException;

class PdfProcessingService
{
    public function storeProcessedFile(UploadedFile $file, string $code): string
    {
        $path = '/'.Str::random(40).'.pdf';
        $temporaryDirectory = storage_path('app/tmp');
        $temporaryPath = $temporaryDirectory.$path;

        try {
            if (! File::exists($temporaryDirectory)) {
                File::makeDirectory($temporaryDirectory, 0755, true);
            }

            $pdf = new Fpdi();
            $pdf->AddPage();
            $pdf->setSourceFile($file->path());
            $tplId = $pdf->importPage(1);
            $pdf->useTemplate($tplId, 0, 0, null, null, true);
            $pdf->SetFont('Arial', '', '12');
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetXY(20, 20);
            $pdf->Write(0, $code);

            $pdf->Output($temporaryPath, 'F');
            Storage::putFileAs('files', new HttpFile($temporaryPath), $path);
            unlink($temporaryPath);
        } catch (CrossReferenceException $exception) {
            throw new CannotUploadCompressedFile();
        }

        return $path;
    }
}

<?php

namespace App\Repositories;

use App\Exceptions\CannotUploadCompressedFile;
use App\Exceptions\CannotUploadEncryptedFile;
use App\Models\Department;
use App\Models\File;
use Illuminate\Http\File as HttpFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use setasign\Fpdi\Fpdi;
use setasign\Fpdi\PdfParser\CrossReference\CrossReferenceException;

class FileRepository implements IFileRepository
{
    /**
     * {@inheritdoc}
     */
    public function create($data)
    {
        $customId = $this->getCustomId($data['department_id']);
        $department = Department::find($data['department_id']);
        $path = $this->storeFile($data, $department->code.'-'.$customId);

        $file = new File;
        $file->department_id = $data['department_id'];
        $file->name = $data['name'];
        $file->subject = $data['subject'] ? $data['subject'] : '';
        $file->recipient = $data['recipient'] ? $data['recipient'] : '';
        $file->path = $path;
        $file->custom_id = $customId;
        $file->save();

        return $file;
    }

    /**
     * {@inheritdoc}
     */
    public function update($fileId, $data)
    {
        $file = File::find($fileId);
        $file->name = $data['name'];
        $file->subject = $data['subject'] ? $data['subject'] : '';
        $file->recipient = $data['recipient'] ? $data['recipient'] : '';
        $file->update();

        return $file;
    }

    /**
     * {@inheritdoc}
     */
    public function storeFile($data, $code) {
        try {
            $pdf = new Fpdi;
            $pdf->AddPage();
            $pdf->setSourceFile($data['file']->path());
            $tplId = $pdf->importPage(1);
            $pdf->useTemplate($tplId);
            // now write some text above the imported page
            $pdf->SetFont('Arial', '', '12');
            $pdf->SetTextColor(0,0,0);
            //set position in pdf document
            $pdf->SetXY(20, 20);
            //first parameter defines the line height
            $pdf->Write(0, $code);

            $path = str_replace('/tmp', '', $data['file']->path().'.pdf');
            $publicPath = public_path('app').'/'.$path;
            $pdf->Output($publicPath,'F');
            Storage::putFileAs('files', new HttpFile($publicPath), $path);
            unlink($publicPath);
        } catch (CrossReferenceException $e) {
            if (str_contains($e->getMessage(), 'compression')) {
                throw new CannotUploadCompressedFile();
            } elseif (str_contains($e->getMessage(), 'encrypted')) {
                throw new CannotUploadEncryptedFile();
            }
        }

        return $path;
    }

    /**
     * {@inheritdoc}
     */
    public function getCustomId($departmentId) {
        $customId = Department::find($departmentId)->start_at;
        $currentMaxCustomId = File::where('department_id', $departmentId)->max('custom_id');
        if ($currentMaxCustomId > 0) {
            $customId = $currentMaxCustomId;
        }

        return $customId+1;
    }

    /**
     * {@inheritdoc}
     */
    public function delete($fileId)
    {
        $file = File::find($fileId);
        $file->delete();
    }
}

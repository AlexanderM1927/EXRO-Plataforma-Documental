<?php

namespace App\Repositories;

use App\Models\Department;
use App\Models\File;
use App\Services\PdfProcessingService;

class FileRepository implements IFileRepository
{
    public function __construct(
        protected PdfProcessingService $pdfProcessingService
    ) {}

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
        return $this->pdfProcessingService->storeProcessedFile($data['file'], $code);
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

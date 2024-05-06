<?php

namespace App\Repositories;

use Illuminate\Http\Request;

interface IFileRepository
{
    /**
     * Create a File
     *
     * @param \Illuminate\Http\Request $data
     * @return App\Models\File
     */
    public function create(Request $data);

    /**
     * Update a File
     *
     * @param int $fileId
     * @param \Illuminate\Http\Request $data
     * @return App\Models\File
     */
    public function update($fileId, Request $data);

    /**
     * Store file
     *
     * @param \Illuminate\Http\Request $data
     * @param string $code
     * @return string
     */
    public function storeFile($data, $code);

    /**
     * Get custom id for new file
     *
     * @param int $departmentId
     * @return int
     */
    public function getCustomId($departmentId);

    /**
     * Delete a File
     *
     * @param int $fileId
     * @return void
     */
    public function delete($fileId);
}

<?php

namespace App\Repositories;

interface IDepartmentRepository
{
    /**
     * Create a Department
     *
     * @param array $data
     * @return App\Models\Department
     */
    public function create(array  $data);

    /**
     * Create a Department
     *
     * @param int $departmentId
     * @param array $data
     * @return App\Models\Department
     */
    public function update($departmentId, array  $data);

    /**
     * Delete a Department
     *
     * @param int $departmentId
     * @return void
     */
    public function delete($departmentId);
}

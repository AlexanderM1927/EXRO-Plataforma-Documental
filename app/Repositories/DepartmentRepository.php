<?php

namespace App\Repositories;

use App\Models\Department;

class DepartmentRepository implements IDepartmentRepository
{
    /**
     * {@inheritdoc}
     */
    public function create(array $data)
    {
        $department = new Department;
        $department->name = $data['name'];
        $department->code = $data['code'];
        $department->start_at = $data['start_at'];
        $department->save();

        return $department;
    }

    /**
     * {@inheritdoc}
     */
    public function update($departmentId, array $data)
    {
        $department = Department::find($departmentId);
        $department->name = $data['name'];
        $department->start_at = $data['start_at'];
        $department->update();

        return $department;
    }

    /**
     * {@inheritdoc}
     */
    public function delete($departmentId)
    {
        $department = Department::find($departmentId);
        $department->delete();
    }
}

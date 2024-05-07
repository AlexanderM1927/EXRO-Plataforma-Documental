<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Repositories\IDepartmentRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Inertia\Inertia;
use Inertia\Response;

class DepartmentController extends Controller
{

    public function __construct(protected IDepartmentRepository $repository) {}



    /**
     * Show the departments.
     */
    public function index(Request $request): Response
    {
        return Inertia::render('Departments/Index', [
            'departments' => Department::paginate(20)
        ]);
    }

    /**
     * Show the create department form.
     */
    public function create(Request $request): Response
    {
        return Inertia::render('Departments/Create');
    }

    /**
     * Show the edit department form.
     */
    public function edit(Request $request, $id): Response
    {
        return Inertia::render('Departments/Edit', [
            'department' => Department::find($id)
        ]);
    }

    /**
     * Store a department element
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string',
            'code' => 'required|string',
            'start_at' => 'required|integer'
        ]);

        $department = $this->repository->create($request->all());

        if (!empty($department)) {
            return response()->json(
                [
                    'message' => 'Department created successfully',
                    'redirect' => route('departments')
                ],
                HttpResponse::HTTP_OK
            );
        } else {
            return response()->json(
                [
                    'message' => 'Error during create department',
                ],
                HttpResponse::HTTP_BAD_REQUEST
            );
        }
    }

    /**
     * Update a department
     */
    public function update(Request $request, $id): JsonResponse
    {
        $request->validate([
            'name' => 'required|string',
            'start_at' => 'required|integer'
        ]);

        $department = $this->repository->update($id, $request->all());

        if (!empty($department)) {
            return response()->json(
                [
                    'message' => 'Department updated successfully',
                    'redirect' => route('departments')
                ],
                HttpResponse::HTTP_OK
            );
        } else {
            return response()->json(
                [
                    'message' => 'Error during update department',
                ],
                HttpResponse::HTTP_BAD_REQUEST
            );
        }
    }

    /**
     * Delete a department
     */
    public function delete(Request $request, $id): JsonResponse
    {
        $this->repository->delete($id);

        return response()->json(
            [
                'message' => 'Department deleted successfully',
                'redirect' => route('departments')
            ],
            HttpResponse::HTTP_OK
        );
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use App\Repositories\IUserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    public function __construct(protected IUserRepository $repository) {}

    /**
     * Show the users.
     */
    public function index(Request $request): Response
    {
        return Inertia::render('Users/Index', [
            'users' => User::paginate(20)
        ]);
    }

    /**
     * Show the create user form.
     */
    public function create(Request $request): Response
    {
        return Inertia::render('Users/Create', [
            'departments' => Department::all()
        ]);
    }

    /**
     * Show the edit department form.
     */
    public function edit(Request $request, $id): Response
    {
        return Inertia::render('Users/Edit', [
            'user' => User::find($id),
            'departments' => Department::all()
        ]);
    }

    /**
     * Store a user
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string',
            'password' => 'required|string',
            'department_id' => 'required|int',
            'role' => 'required|string'
        ]);

        $department = $this->repository->create($request->all());

        if (!empty($department)) {
            return response()->json(
                [
                    'message' => 'User created successfully',
                    'redirect' => route('users')
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
     * Update a user
     */
    public function update(Request $request, $id): JsonResponse
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string',
            'department_id' => 'required|int'
        ]);

        $department = $this->repository->update($id, $request->all());

        if (!empty($department)) {
            return response()->json(
                [
                    'message' => 'User created successfully',
                    'redirect' => route('users')
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
     * Delete a user
     */
    public function delete(Request $request, $id): JsonResponse
    {
        $this->repository->delete($id);

        return response()->json(
            [
                'message' => 'User deleted successfully',
                'redirect' => route('users')
            ],
            HttpResponse::HTTP_OK
        );

    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\File;
use App\Models\User;
use App\Repositories\IFileRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class FileController extends Controller
{

    public function __construct(protected IFileRepository $repository) {}



    /**
     * Show the files.
     */
    public function index(): Response
    {
        return Inertia::render('Files/Index', [
            'files' => File::with('department')->orderBy('id', 'DESC')->paginate(20)
        ]);
    }

    /**
     * Show the files by name/identifier.
     */
    public function search(Request $request): Response
    {
        if ($request->query('search') === '') {
            return $this->index();
        }
        return Inertia::render('Files/Index', [
            'files' => File::with('department')
                ->orderBy('id', 'DESC')
                ->where('files.name', 'LIKE', '%'.$request->query('search').'%')
                ->orWhere('files.subject', 'LIKE', '%'.$request->query('search').'%')
                ->orWhere('files.recipient', 'LIKE', '%'.$request->query('search').'%')
                ->paginate(20),
            'currentSearch' => $request->query('search')
        ]);
    }

    /**
     * Show the create file form.
     */
    public function create(Request $request): Response
    {
        $user = User::find(Auth::user()->id);
        return Inertia::render('Files/Create', [
            'departments' => Department::all(),
            'user' => $user
        ]);
    }

    /**
     * Show the edit file form.
     */
    public function edit(Request $request, $id): Response
    {
        return Inertia::render('Files/Edit', [
            'file' => File::find($id),
            'departments' => Department::all()
        ]);
    }

    /**
     * Store a file element
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string',
            'department_id' => 'required|exists:departments,id',
            'file' => 'required|extensions:pdf|max:50000',
            'subject' => 'required',
            'recipient' => 'required'
        ]);

        $file = $this->repository->create($request);

        if (!empty($file)) {
            return response()->json(
                [
                    'message' => 'File created successfully',
                    'redirect' => route('files')
                ],
                HttpResponse::HTTP_OK
            );
        } else {
            return response()->json(
                [
                    'message' => 'Error during create file',
                ],
                HttpResponse::HTTP_BAD_REQUEST
            );
        }
    }

    /**
     * Update a file element
     */
    public function update(Request $request, $id): JsonResponse
    {
        $request->validate([
            'name' => 'required|string',
            'subject' => 'required',
            'recipient' => 'required'
        ]);

        $file = $this->repository->update($id, $request);

        if (!empty($file)) {
            return response()->json(
                [
                    'message' => 'File created successfully',
                    'redirect' => route('files')
                ],
                HttpResponse::HTTP_OK
            );
        } else {
            return response()->json(
                [
                    'message' => 'Error during update file',
                ],
                HttpResponse::HTTP_BAD_REQUEST
            );
        }
    }

    /**
     * Get file
     */
    public function download(Request $request, $id): BinaryFileResponse
    {
        $file = File::find($id);
        return response()->file(storage_path(). '/app/files' . $file->path);
    }

    /**
     * Delete a file
     */
    public function delete(Request $request, $id): JsonResponse
    {
        $this->repository->delete($id);

        return response()->json(
            [
                'message' => 'File deleted successfully',
                'redirect' => route('files')
            ],
            HttpResponse::HTTP_OK
        );
    }
}

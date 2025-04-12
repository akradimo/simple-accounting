<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::query()
            ->when(request('search'), function($q) {
                $q->where('name', 'like', '%' . request('search') . '%');
            })
            ->orderBy('id', 'desc')
            ->get();
        
        return response()->json($projects);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'اطلاعات نامعتبر است',
                'errors' => $validator->errors()
            ], 422);
        }

        $project = Project::create([
            'name' => $request->name,
            'description' => $request->description,
            'created_by' => Auth::id() ?? 1, // default to 1 if not authenticated
            'status' => 'active'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'پروژه با موفقیت ایجاد شد',
            'project' => $project
        ]);
    }

    public function update(Request $request, Project $project)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'اطلاعات نامعتبر است',
                'errors' => $validator->errors()
            ], 422);
        }

        $project->update([
            'name' => $request->name,
            'description' => $request->description,
            'updated_by' => Auth::id() ?? 1
        ]);

        return response()->json([
            'success' => true,
            'message' => 'پروژه با موفقیت بروزرسانی شد',
            'project' => $project
        ]);
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return response()->json([
            'success' => true,
            'message' => 'پروژه با موفقیت حذف شد'
        ]);
    }
}
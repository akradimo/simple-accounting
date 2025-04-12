<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::active()->get();
        return response()->json($projects);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        $project = Project::create($validated + [
            'created_by' => Auth::id(),
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
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        $project->update($validated + [
            'updated_by' => Auth::id()
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
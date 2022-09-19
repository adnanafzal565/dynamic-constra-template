<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;
use App\Models\Project;
use App\Models\ProjectImage;

class ProjectsController extends Controller
{
    public function fetchSingle()
    {
        $validator = Validator::make(request()->all(), [
            "id" => "required|exists:projects,id"
        ]);

        if ($validator->fails())
        {
            return response()->json([
                "status" => "error",
                "message" => $validator->errors()->all()[0]
            ]);
        }

        $project = Project::find(request()->id);
        $images = ProjectImage::where("project_id", "=", $project->id)->get();

        return response()->json([
            "status" => "success",
            "message" => "Data has been fetched.",
            "project" => $project,
            "images" => $images
        ]);
    }

    public function fetch()
    {
        $projects = Project::with("images")
            ->orderBy("id", "desc")->get();

        return response()->json([
            "status" => "success",
            "message" => "Data has been fetched.",
            "projects" => $projects
        ]);
    }

    public function create()
    {
        $validator = Validator::make(request()->all(), [
            "name" => "required",
            "description" => "required",
            "client" => "required",
            "architect" => "required",
            "location" => "required",
            "size" => "required",
            "year_completed" => "required",
            "categories" => "required",
            "file" => "required|file"
        ]);

        if ($validator->fails())
        {
            return response()->json([
                "status" => "error",
                "message" => $validator->errors()->all()[0]
            ]);
        }

        $file = request()->file;
        if (!$file->isValid())
        {
            return response()->json([
                "status" => "error",
                "message" => "Please select a valid file."
            ]);
        }

        $extension = $file->getClientOriginalExtension();
        $image_extensions = ["png", "jpeg", "jpg"];

        if (!in_array($extension, $image_extensions))
        {
            return response()->json([
                "status" => "error",
                "message" => "Please select a valid image file."
            ]);
        }

        $file_path = "project-images/" . time() . "-" . $file->getClientOriginalName();
        $file->storeAs("/public", $file_path);

        $project = new Project();
        $project->name = request()->name;
        $project->description = request()->description;
        $project->client = request()->client;
        $project->architect = request()->architect;
        $project->location = request()->location;
        $project->size = request()->size;
        $project->year_completed = request()->year_completed;
        $project->categories = request()->categories;
        $project->save();

        $project_image = new ProjectImage();
        $project_image->file_path = $file_path;
        $project_image->project_id = $project->id;
        $project_image->save();

        return response()->json([
            "status" => "success",
            "message" => "Project has been created."
        ]);
    }
}

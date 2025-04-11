<?php
namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseQuizMaterial;
use App\Models\Quiz;
use App\Models\QuizAttachment;
use App\Models\QuizEmailContent;
use Illuminate\Http\Request;
use App\Models\Material;
use App\Models\MaterialAttachment;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Option;
use App\Models\CourseMaterial;

class CourseController extends Controller
{
    public function createCourse(Request $request)
    {
        $request->validate([
            'courseName'        => 'required|unique:courses,name',
            'courseDescription' => 'required',
            'contents'          => 'required',
        ]);

        if ($request->contents == null) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Content is required',
            ], 400);
        }

        foreach ($request->contents as $key => $value) {
            if ($value['type'] == 'material') {
                if ($value['name'] == null) {
                    return response()->json([
                        'status'  => 'error',
                        'message' => "Material name is required on content number {$value['order']}.",
                    ], 400);
                }
                if ($value['title'] == null) {
                    return response()->json([
                        'status'  => 'error',
                        'message' => "Material title is required on content number {$value['order']}.",
                    ], 400);
                }
                if ($value['content'] == null) {
                    return response()->json([
                        'status'  => 'error',
                        'message' => "Material content is required on content number {$value['order']}.",
                    ], 400);
                }
            } else if ($value['type'] == 'quiz') {

                if ($value['name'] == null) {
                    return response()->json([
                        'status'  => 'error',
                        'message' => "Quiz name is required on content number {$value['order']}.",
                    ], 400);
                }
                if ($value['title'] == null) {
                    return response()->json([
                        'status'  => 'error',
                        'message' => "Quiz title is required on content number {$value['order']}.",
                    ], 400);
                }
                if ($value['content'] == null) {
                    return response()->json([
                        'status'  => 'error',
                        'message' => "Quiz content is required on content number {$value['order']}.",
                    ], 400);
                }
                if($value['option'] == null) {
                    return response()->json([
                        'status'  => 'error',
                        'message' => "Quiz option is required on content number {$value['order']}.",
                    ], 400);
                }
            }
        }
        $course              = new Course();
        $course->name        = $request->input('courseName');
        $course->description = $request->input('courseDescription');
        $course->save();
        $contents = $request->contents;
        $quizzes  = array_filter($contents, fn($value) => $value['type'] === 'quiz');

        foreach ($quizzes as $quiz) {
            $quizName           = $quiz['name'];
            $quizTitle          = $quiz['title'];
            $quizContent        = $quiz['content'];
            $quizAttachment     = $quiz['attachment'] ?? null;
            $quizEmailContentId = $quiz['emailContent'] ?? null;
            $quizOption = $quiz['option'];

            $newQuiz          = new Quiz();
            $newQuiz->name    = $quizName;
            $newQuiz->title   = $quizTitle;
            $newQuiz->content = $quizContent;
            if ($quizAttachment != null) {
                $newQuizAttachment = new QuizAttachment();
                $path = $quizAttachment->store('course/quiz', 'public');
                $newQuizAttachment->name = $quizAttachment->getClientOriginalName();
                $newQuizAttachment->path = $path;
                $newQuizAttachment->save();
                $newQuiz->quiz_attachment_id = $newQuizAttachment->id;
            }
            if($quizEmailContentId != null && $quizEmailContentId != '') {
                $newQuizEmailContent = new QuizEmailContent();
                $newQuizEmailContent->content = $quizEmailContentId;
                $newQuizEmailContent->save();
                $newQuiz->quiz_email_content_id = $newQuizEmailContent->id;
            }

            $newQuiz->option = $quizOption;
            $group = Option::where('id', $quizOption)->first();
            $newQuiz->group = $group->group;
            $newQuiz->save();

          $courseQuiz = new CourseQuizMaterial();
            $courseQuiz->course_id = $course->id;
            $courseQuiz->model_id  = $newQuiz->id;
            $courseQuiz->model_type = 'quiz';
            $courseQuiz->order     = $quiz['order'];
            $courseQuiz->save();
        }

        $materials = array_filter($contents, fn($value) => $value['type'] === 'material');
        foreach ($materials as $material) {
            $materialName    = $material['name'];
            $materialTitle   = $material['title'];
            $materialContent = $material['content'];
            $materialAttachment = $material['attachment'] ?? null;

            $newMaterial          = new Material();
            $newMaterial->name    = $materialName;
            $newMaterial->title   = $materialTitle;
            $newMaterial->content = $materialContent;
            if ($materialAttachment != null) {
                $newMaterialAttachment = new MaterialAttachment();
                $path = $materialAttachment->store('course/material', 'public');
                $newMaterialAttachment->name = $materialAttachment->getClientOriginalName();
                $newMaterialAttachment->path = $path;
                $newMaterialAttachment->save();
            }
            $newMaterial->material_attachment_id = $newMaterialAttachment->id;
            $newMaterial->save();

          $courseQuiz = new CourseQuizMaterial();
            $courseQuiz->course_id = $course->id;
            $courseQuiz->model_id  = $newMaterial->id;
            $courseQuiz->model_type = 'material';
            $courseQuiz->order     = $material['order'];
            $courseQuiz->save();
        }
        return response()->json([
            'status'  => 'success',
            'message' => 'Course created successfully',
            'course'  => $course,
        ], 201);

    }
}

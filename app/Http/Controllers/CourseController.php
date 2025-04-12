<?php
namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseQuizMaterial;
use App\Models\Material;
use App\Models\MaterialAttachment;
use App\Models\Option;
use App\Models\Quiz;
use App\Models\QuizAttachment;
use App\Models\QuizEmailContent;
use Illuminate\Http\Request;

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
                if ($value['option'] == null) {
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
            $quizOption         = $quiz['option'];

            $newQuiz          = new Quiz();
            $newQuiz->name    = $quizName;
            $newQuiz->title   = $quizTitle;
            $newQuiz->content = $quizContent;
            if ($quizAttachment != null) {
                $newQuizAttachment       = new QuizAttachment();
                $path                    = $quizAttachment->store('course/quiz', 'public');
                $newQuizAttachment->name = $quizAttachment->getClientOriginalName();
                $newQuizAttachment->path = $path;
                $newQuizAttachment->save();
                $newQuiz->quiz_attachment_id = $newQuizAttachment->id;
            }
            if ($quizEmailContentId != null && $quizEmailContentId != '') {
                $newQuizEmailContent          = new QuizEmailContent();
                $newQuizEmailContent->content = $quizEmailContentId;
                $newQuizEmailContent->save();
                $newQuiz->quiz_email_content_id = $newQuizEmailContent->id;
            }

            $newQuiz->option_id = $quizOption;
            $group              = Option::where('id', $quizOption)->first();
            $newQuiz->group     = $group->group;
            $newQuiz->save();

            $courseQuiz             = new CourseQuizMaterial();
            $courseQuiz->course_id  = $course->id;
            $courseQuiz->model_id   = $newQuiz->id;
            $courseQuiz->model_type = 'quiz';
            $courseQuiz->order      = $quiz['order'];
            $courseQuiz->save();
        }

        $materials = array_filter($contents, fn($value) => $value['type'] === 'material');
        foreach ($materials as $material) {
            $materialName       = $material['name'];
            $materialTitle      = $material['title'];
            $materialContent    = $material['content'];
            $materialAttachment = $material['attachment'] ?? null;

            $newMaterial          = new Material();
            $newMaterial->name    = $materialName;
            $newMaterial->title   = $materialTitle;
            $newMaterial->content = $materialContent;
            if ($materialAttachment != null) {
                $newMaterialAttachment       = new MaterialAttachment();
                $path                        = $materialAttachment->store('course/material', 'public');
                $newMaterialAttachment->name = $materialAttachment->getClientOriginalName();
                $newMaterialAttachment->path = $path;
                $newMaterialAttachment->save();
            }
            $newMaterial->material_attachment_id = $newMaterialAttachment->id;
            $newMaterial->save();

            $courseQuiz             = new CourseQuizMaterial();
            $courseQuiz->course_id  = $course->id;
            $courseQuiz->model_id   = $newMaterial->id;
            $courseQuiz->model_type = 'material';
            $courseQuiz->order      = $material['order'];
            $courseQuiz->save();
        }
        return response()->json([
            'status'  => 'success',
            'message' => 'Course created successfully',
            'course'  => $course,
        ], 201);
    }

    public function getCourse(Request $request)
    {

        $courses = Course::with(['courseQuizMaterial' => function ($query) {
            $query->with('quiz', 'material');
        }]);
        if ($request->has('search')) {
            $courses = $courses->where('name', 'like', '%' . $request->input('search') . '%');
        }
        if ($request->has('show')) {
            $courses = $courses->paginate($request->input('show'));
        }
        $totalCourse = $courses->count();

        return response()->json([
            'courses'        => $courses->items(),
            'courseTotal'    => $totalCourse,
            'currentPage'    => $courses->currentPage(),
            'firstPageTotal' => count($courses->items()),
            'pageCount'      => $courses->lastPage(),

        ], 200);
    }

    public function deleteCourse(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:courses,id',
        ]);
        $course = Course::find($request->id);
        if ($course) {
            $course->delete();
            return response()->json([
                'status'  => 'success',
                'message' => 'Course deleted successfully',
            ], 200);
        } else {
            return response()->json([
                'status'  => 'error',
                'message' => 'Course not found',
            ], 404);
        }
    }

    public function getCourseDetails(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:courses,id',
        ]);
        $course = Course::with('courseQuizMaterial.model')->find($request->id);
        foreach ($course->courseQuizMaterial as $cqm) {
            if ($cqm->model_type === 'material') {
                $cqm->model->load('attachment');
                $cqm->model->attachment_url = asset('storage/' . $cqm->model->attachment->path);
            }

            if ($cqm->model_type === 'quiz') {
                $cqm->model->load(['attachment', 'emailContent', 'option']);
                $cqm->model->attachment_url = asset('storage/' . $cqm->model->attachment->path);
            }
        }
        $course->courseQuizMaterial = $course->courseQuizMaterial->sortBy('order')->values();

        

        if ($course) {
            return response()->json([
                'status' => 'success',
                'course' => $course,
            ], 200);
        } else {
            return response()->json([
                'status'  => 'error',
                'message' => 'Course not found',
            ], 404);
        }
    }

    public function updateCourse(Request $request){
        $request->validate([
            'courseId' => 'required|exists:courses,id',
        ]);
        $course = Course::find($request->courseId);
        if ($course) {
            $course->name        = $request->input('courseName');
            $course->description = $request->input('courseDescription');
            // $course->save();
        }

        $contents = json_decode($request->contents, true);
        $quizzes  = array_filter($contents, fn($value) => $value['type'] === 'quiz');
        $materials = array_filter($contents, fn($value) => $value['type'] === 'material'); 
        $quizIds = [];
        $materialIds = [];
        foreach($quizzes as $quiz){
            if(isset($quiz['id'])){
                $quizIds[] = $quiz['id'];
            }
        }
        foreach($materials as $material){
            if(isset($material['id'])){
                $materialIds[] = $material['id'];
            }
        }
        $courseQuizMaterials = CourseQuizMaterial::where('course_id', $course->id)->get();
        foreach($courseQuizMaterials as $courseQuizMaterial){
            if($courseQuizMaterial->model_type == 'quiz'){
                if(!in_array($courseQuizMaterial->model_id, $quizIds)){
                    // $courseQuizMaterial->delete();
                }
            }else if($courseQuizMaterial->model_type == 'material'){
                if(!in_array($courseQuizMaterial->model_id, $materialIds)){
                    // $courseQuizMaterial->delete();
                }
            }
        }
        foreach($quizzes as $quiz){
            if(isset($quiz['id'])){
                $quizModel = Quiz::find($quiz['id']);
                if($quizModel){
                    $quizModel->name    = $quiz['name'];
                    $quizModel->title   = $quiz['title'];
                    $quizModel->content = $quiz['content'];
                    if (isset($quiz['attachment'])) {
                        $path                    = $quiz['attachment']->store('course/quiz', 'public');
                        $quizModel->attachment->path   = $path;
                        $quizModel->attachment->name   = $quiz['attachment']->getClientOriginalName();
                        $quizModel->attachment->save();
                        $quizModel->quiz_attachment_id = $quizModel->attachment->id;
                    }
                    if (isset($quiz['emailContent'])) {
                        $quizModel->emailContent->delete();
                        $quizModel->emailContent          = new QuizEmailContent();
                        $quizModel->emailContent->content = $quiz['emailContent'];
                        $quizModel->emailContent->save();
                        $quizModel->quiz_email_content_id = $quizModel->emailContent->id;
                    }
                    if (isset($quiz['option'])) {
                        $quizModel->option_id    = $quiz['option'];
                        $group                  = Option::where('id', $quiz['option'])->first();
                        $quizModel->group       = $group->group;
                    }
                    $quizModel->save();
                }
            }
        }
    }
}

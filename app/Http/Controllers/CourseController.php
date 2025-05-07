<?php
namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseQuizMaterial;
use App\Models\CourseThumbnail;
use App\Models\Material;
use App\Models\MaterialAttachment;
use App\Models\Option;
use App\Models\Quiz;
use App\Models\QuizAttachment;
use App\Models\QuizEmailContent;
use App\Models\Target;
use App\Models\TargetCourseScore;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function createCourse(Request $request)
    {
        $request->validate([
            'courseName'        => 'required|unique:courses,name',
            'courseDescription' => 'required',
            'contents'          => 'required',
            'courseThumbnail'   => 'required',
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
                if ($value['option'] == null || $value['option'] == 0) {
                    return response()->json([
                        'status'  => 'error',
                        'message' => "Quiz option is required on content number {$value['order']}.",
                    ], 400);
                }
            }
        }
        $thumbnail             = $request->courseThumbnail;
        $course                = new Course();
        $course->name          = $request->input('courseName');
        $course->description   = $request->input('courseDescription');
        $courseThumbnail       = new CourseThumbnail();
        $courseThumbnail->path = $thumbnail->store('course/thumbnail', 'public');
        $courseThumbnail->name = $thumbnail->getClientOriginalName();
        $courseThumbnail->save();
        $course->course_thumbnail_id = $courseThumbnail->id;
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
        }, 'thumbnail']);

        if ($request->has('search')) {
            $courses = $courses->where('name', 'like', '%' . $request->input('search') . '%');
        }
        if ($request->has('show')) {
            $courses = $courses->paginate($request->input('show'));
        }

        foreach ($courses as $course) {
            if (isset($course->thumbnail)) {
                $course->thumbnail_url = asset('storage/' . $course->thumbnail->path);
            } else {
                $course->thumbnail_url = asset('storage/app/public/thumbnail/thumbnail.jpg');
            }
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
        $course = Course::with('courseQuizMaterial.model', 'thumbnail')->find($request->id);
        if (isset($course->thumbnail)) {
            $course->thumbnail_url = asset('storage/' . $course->thumbnail->path);
        } else {
            $course->thumbnail_url = asset('storage/app/public/thumbnail/thumbnail.jpg');
        }
        foreach ($course->courseQuizMaterial as $cqm) {
            if ($cqm->model_type === 'material') {
                $cqm->model->load('attachment');
                if ($cqm->model->material_attachment_id != null) {
                    $cqm->model->attachment_url = asset('storage/' . $cqm->model->attachment->path);
                }
            }

            if ($cqm->model_type === 'quiz') {
                $cqm->model->load(['attachment', 'emailContent', 'option']);

                if ($cqm->model->quiz_attachment_id != null) {
                    $cqm->model->attachment_url = asset('storage/' . $cqm->model->attachment->path);
                }
            }
        }
        $course->courseQuizMaterial = $course->courseQuizMaterial->sortBy('order')->values();

        if ($course) {
            return response()->json([
                'status' => 'success',
                'course' => $course,
                'option' => Option::all(),
            ], 200);
        } else {
            return response()->json([
                'status'  => 'error',
                'message' => 'Course not found',
            ], 404);
        }
    }

    public function updateCourse(Request $request)
    {
        $request->validate([
            'courseId'          => 'required|exists:courses,id',
            'courseName'        => 'required|unique:courses,name,' . $request->courseId,
            'courseDescription' => 'required',
        ]);

        $course = Course::find($request->courseId);
        if ($course) {
            $course->name        = $request->input('courseName');
            $course->description = $request->input('courseDescription');
            if (isset($request->courseThumbnail)) {
                $thumbnail = $request->courseThumbnail;
                if ($thumbnail != 'undefined' || $thumbnail != null) {
                    $courseThumbnail       = new CourseThumbnail();
                    $courseThumbnail->path = $thumbnail->store('course/thumbnail', 'public');
                    $courseThumbnail->name = $thumbnail->getClientOriginalName();
                    $courseThumbnail->save();
                    $course->course_thumbnail_id = $courseThumbnail->id;
                }
            }

            $course->save();
        }
        $contents    = $request->contents;
        $quizzes     = array_filter($contents, fn($value) => $value['type'] === 'quiz');
        $materials   = array_filter($contents, fn($value) => $value['type'] === 'material');
        $quizIds     = [];
        $materialIds = [];
        foreach ($quizzes as $quiz) {
            if ($quiz['name'] == null) {
                return response()->json([
                    'status'  => 'error',
                    'message' => "Quiz name is required on content number {$quiz['order']}.",
                ], 400);
            }
            if ($quiz['title'] == null) {
                return response()->json([
                    'status'  => 'error',
                    'message' => "Quiz title is required on content number {$quiz['order']}.",
                ], 400);
            }
            if ($quiz['content'] == null) {
                return response()->json([
                    'status'  => 'error',
                    'message' => "Quiz content is required on content number {$quiz['order']}.",
                ], 400);
            }
            if (! isset($quiz['option']) || $quiz['option'] == null || $quiz['option'] == 0) {
                return response()->json([
                    'status'  => 'error',
                    'message' => "Quiz option is required on content number {$quiz['order']}.",
                ], 400);
            }
        }
        foreach ($materials as $material) {
            if ($material['name'] == null) {
                return response()->json([
                    'status'  => 'error',
                    'message' => "Material name is required on content number {$material['order']}.",
                ], 400);
            }
            if ($material['title'] == null) {
                return response()->json([
                    'status'  => 'error',
                    'message' => "Material title is required on content number {$material['order']}.",
                ], 400);
            }
            if ($material['content'] == null) {
                return response()->json([
                    'status'  => 'error',
                    'message' => "Material content is required on content number {$material['order']}.",
                ], 400);
            }
        }
        foreach ($quizzes as $quiz) {
            if (isset($quiz['id'])) {
                $quizIds[] = $quiz['id'];
            }
        }
        foreach ($materials as $material) {
            if (isset($material['id'])) {
                $materialIds[] = $material['id'];
            }
        }
        $courseQuizMaterials = CourseQuizMaterial::where('course_id', $course->id)->get();
        foreach ($courseQuizMaterials as $courseQuizMaterial) {
            if ($courseQuizMaterial->model_type == 'quiz') {
                if (! in_array($courseQuizMaterial->model_id, $quizIds)) {
                    $courseQuizMaterial->delete();
                }
            } else if ($courseQuizMaterial->model_type == 'material') {
                if (! in_array($courseQuizMaterial->model_id, $materialIds)) {
                    $courseQuizMaterial->delete();
                }
            }
        }
        foreach ($quizzes as $quiz) {
            if (isset($quiz['id'])) {
                $quizModel = Quiz::find($quiz['id']);
                if ($quizModel) {
                    $quizModel->name    = $quiz['name'];
                    $quizModel->title   = $quiz['title'];
                    $quizModel->content = $quiz['content'];
                    if (isset($quiz['attachment']) && ! empty($quiz['attachment'])) {
                        $path = $quiz['attachment']->store('course/quiz', 'public');
                        // $quizModel->attachment       =
                        // $quizModel->attachment->path = $path;
                        // $quizModel->attachment->name = $quiz['attachment']->getClientOriginalName();
                        // $quizModel->attachment->save();
                        // $quizModel->quiz_attachment_id = $quizModel->attachment->id;
                        if ($quizModel->attachment) {
                            $quizModel->attachment->path = $path;
                            $quizModel->attachment->name = $quiz['attachment']->getClientOriginalName();
                            $quizModel->attachment->save();
                        } else {
                            $newQuizAttachment       = new QuizAttachment();
                            $newQuizAttachment->name = $quiz['attachment']->getClientOriginalName();
                            $newQuizAttachment->path = $path;
                            $newQuizAttachment->save();
                            $quizModel->quiz_attachment_id = $newQuizAttachment->id;
                        }
                    }
                    if (isset($quiz['emailContent']) && $quiz['emailContent'] != null && $quiz['emailContent'] != '') {

                        $quizModel->emailContent->content = $quiz['emailContent'];
                        $quizModel->emailContent->save();
                        $quizModel->quiz_email_content_id = $quizModel->emailContent->id;
                    }
                    if (isset($quiz['option'])) {
                        $quizModel->option_id = $quiz['option'];
                        $group                = Option::where('id', $quiz['option'])->first();
                        $quizModel->group     = $group->group;
                    }
                    $quizModel->save();

                    $courseQuiz        = CourseQuizMaterial::where('course_id', $course->id)->where('model_id', $quizModel->id)->where('model_type', 'quiz')->first();
                    $courseQuiz->order = $quiz['order'];
                    $courseQuiz->save();
                }

            } else {

                $newQuiz          = new Quiz();
                $newQuiz->name    = $quiz['name'];
                $newQuiz->title   = $quiz['title'];
                $newQuiz->content = $quiz['content'];
                if (isset($quiz['attachment']) && ! empty($quiz['attachment'])) {
                    $newQuizAttachment       = new QuizAttachment();
                    $path                    = $quiz['attachment']->store('course/quiz', 'public');
                    $newQuizAttachment->name = $quiz['attachment']->getClientOriginalName();
                    $newQuizAttachment->path = $path;
                    $newQuizAttachment->save();
                    $newQuiz->quiz_attachment_id = $newQuizAttachment->id;
                }
                if (isset($quiz['emailContent']) && $quiz['emailContent'] != null && $quiz['emailContent'] != '') {
                    $newQuizEmailContent          = new QuizEmailContent();
                    $newQuizEmailContent->content = $quiz['emailContent'];
                    $newQuizEmailContent->save();
                    $newQuiz->quiz_email_content_id = $newQuizEmailContent->id;
                }
                if (isset($quiz['option'])) {
                    $newQuiz->option_id = $quiz['option'];
                    $group              = Option::where('id', $quiz['option'])->first();
                    $newQuiz->group     = $group->group;
                }
                $newQuiz->save();
                $courseQuiz             = new CourseQuizMaterial();
                $courseQuiz->course_id  = $course->id;
                $courseQuiz->model_id   = $newQuiz->id;
                $courseQuiz->model_type = 'quiz';
                $courseQuiz->order      = $quiz['order'];
                $courseQuiz->save();
            }
        }
        foreach ($materials as $material) {
            if (isset($material['id'])) {
                $materialModel = Material::find($material['id']);
                if ($materialModel) {
                    $materialModel->name    = $material['name'];
                    $materialModel->title   = $material['title'];
                    $materialModel->content = $material['content'];
                    if (isset($material['attachment']) && ! empty($material['attachment'])) {
                        $path                            = $material['attachment']->store('course/material', 'public');
                        $materialModel->attachment->path = $path;
                        $materialModel->attachment->name = $material['attachment']->getClientOriginalName();
                        $materialModel->attachment->save();
                        $materialModel->material_attachment_id = $materialModel->attachment->id;
                    }
                    $materialModel->save();
                    $courseQuiz        = CourseQuizMaterial::where('course_id', $course->id)->where('model_type', 'material')->where('model_id', $materialModel->id)->first();
                    $courseQuiz->order = $material['order'];
                    $courseQuiz->save();
                }

            } else {
                $newMaterial          = new Material();
                $newMaterial->name    = $material['name'];
                $newMaterial->title   = $material['title'];
                $newMaterial->content = $material['content'];
                if (isset($material['attachment']) && ! empty($material['attachment'])) {
                    $newMaterialAttachment       = new MaterialAttachment();
                    $path                        = $material['attachment']->store('course/material', 'public');
                    $newMaterialAttachment->name = $material['attachment']->getClientOriginalName();
                    $newMaterialAttachment->path = $path;
                    $newMaterialAttachment->save();
                    $newMaterial->material_attachment_id = $newMaterialAttachment->id;
                }
                $newMaterial->save();
                $courseQuiz             = new CourseQuizMaterial();
                $courseQuiz->course_id  = $course->id;
                $courseQuiz->model_id   = $newMaterial->id;
                $courseQuiz->model_type = 'material';
                $courseQuiz->order      = $material['order'];
                $courseQuiz->save();
            }
        }
        return response()->json([
            'status'  => 'success',
            'message' => 'Course updated successfully',
            'course'  => $course,
        ], 200);

    }

    public function submitCourse(Request $request)
    {
        $request->validate([
            'id'             => 'required|exists:courses,id',
            'total_correct'  => 'required|numeric',
            'total_wrong'    => 'required|numeric',
            'total_question' => 'required|numeric',
        ]);

        $true     = $request->total_correct;
        $false    = $request->total_wrong;
        $question = $request->total_question;

        $score = ($question > 0) ? ($true / $question * 100) : 0;

        $target = Target::where('email', auth()->user()->email)->first();

        if (! $target) {
            return response()->json([
                'success' => false,
                'message' => 'Target not found for the user.',
            ], 404);
        }
        $oldData = TargetCourseScore::where('user_id', auth()->user()->id)->where('course_id', $request->id)->first();
        if ($oldData) {
            $oldData->score = $score;
            $oldData->save();
            return response()->json([
                'success' => true,
                'message' => 'Score updated successfully.',
            ]);
        }
        $newData            = new TargetCourseScore();
        $newData->user_id   = auth()->user()->id;
        $newData->target_id = $target->id;
        $newData->course_id = $request->id;
        $newData->score     = $score;
        $newData->save();

        return response()->json([
            'success' => true,
            'message' => 'Score submitted successfully.',
        ]);
    }

    public function getCourseEmployee(Request $request)
    {
        $coursesQuery = Course::with([
            'courseQuizMaterial' => function ($query) {
                $query->with('quiz', 'material');
            },
            'thumbnail',
        ]);

        if ($request->has('search')) {
            $coursesQuery = $coursesQuery->where('name', 'like', '%' . $request->input('search') . '%');
        }

        $courses = $request->has('show')
        ? $coursesQuery->paginate($request->input('show'))
        : $coursesQuery->get();

        foreach ($courses as $course) {
            if (isset($course->thumbnail)) {
                $course->thumbnail_url = asset('storage/' . $course->thumbnail->path);
            } else {
                $course->thumbnail_url = asset('storage/app/public/thumbnail/thumbnail.jpg');
            }
        }

        $userScores = TargetCourseScore::where('user_id', auth()->user()->id)->get();

        $courses = $courses->map(function ($course) use ($userScores) {
            $userScore = $userScores->firstWhere('course_id', $course->id);
            if ($userScore) {
                $course->is_enrolled = true;
                $course->score       = $userScore->score;
                $course->can_retake  = $userScore->score < 60;
            } else {
                $course->is_enrolled = false;
                $course->score       = null;
                $course->can_retake  = false;
            }
            return $course;
        });

        if ($request->has('courseStatus')) {
            $status  = $request->courseStatus;
            $courses = $courses->filter(function ($course) use ($status) {
                if ($status === 'completed') {
                    return $course->is_enrolled && $course->score >= 60;
                } elseif ($status === 'incomplete') {
                    return ! $course->is_enrolled;
                } elseif ($status === 'retake') {
                    return $course->is_enrolled && $course->score < 60;
                }
                return true;
            })->values();
        }

        $isPaginated = $courses instanceof \Illuminate\Pagination\LengthAwarePaginator;

        return response()->json([
            'courses'        => $isPaginated ? $courses->items() : $courses,
            'courseTotal'    => $isPaginated ? $courses->total() : count($courses),
            'currentPage'    => $isPaginated ? $courses->currentPage() : 1,
            'firstPageTotal' => $isPaginated ? count($courses->items()) : count($courses),
            'pageCount'      => $isPaginated ? $courses->lastPage() : 1,
        ]);
    }

}

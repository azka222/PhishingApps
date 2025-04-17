@extends('layouts.employee-master')
@section('content')
    <input type="hidden" id="course-id" value="{{ $id }}">
    <div id="term-condition"
        class="p-4 w-full flex flex-col h-full min-h-screen items-center justify-center  bg-gray-50 dark:bg-gray-800 dark:text-white text-gray-900">
        <div class="flex flex-col r mt-8 w-1/2 dark:bg-gray-700 bg-gray-200 p-8 rounded-xl">
            <h1 class="text-3xl font-semibold" id="course-name">Nama Course Nanti Disini</h1>
            <div class="py-4" id="course-thumbnail">
                
            </div>
            <div  class="mt-8   rounded-xl min-h-64">
                <h2>
                    Description :
                </h2>
                <h2 id="course-description" class="mt-2">
                    Nanti Description Disini
                </h2>
            </div>
            <div class="max-w-full mt-8">
                <h2 class="text-2xl font-semibold mb-4">📜 Terms and Conditions</h2>
                <ul class="list-disc list-inside  mb-4">
                    <li class="mt-2"><strong>Single Attempt Only:</strong> You are allowed to start the quiz only once.
                        Once started, it
                        cannot be restarted.</li>
                    <li class="mt-2"><strong>Time Limit:</strong> The total time allocated for the quiz is <strong>60
                            minutes</strong>.
                    </li>
                    <li class="mt-2"><strong>No Page Refreshing:</strong> Do <strong>not</strong> refresh or reload the
                        page during the
                        quiz. Doing so will result in the <strong>loss of all your answers</strong>.</li>
                </ul>
                <hr class="border-t-2 border-gray-300 my-8">
                <div class="flex flex-row items-center justify-between">
                    <div class="flex items-center mb-4">
                        <input id="agreeCheckbox" type="checkbox" value=""
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-lg focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                        <label for="default-checkbox" class="ms-2 text-md font-medium text-gray-900 dark:text-gray-300">
                            I have read and agree to the Terms and Conditions</label>
                    </div>

                    <button id="startButton" onclick="checkAgreement()"
                        class="px-4 py-2 text-md md:text-sm font-medium text-white rounded-xl 
                           bg-green-600 dark:bg-green-500 
                           hover:bg-green-700 dark:hover:bg-green-600 
                           disabled:bg-gray-400 hover:cursor-not-allowed 
                           disabled:text-gray-200 transition-colors duration-200">
                        <span class="hidden md:inline">Start</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div id="course"
        class="p-4 w-full flex flex-col h-full min-h-screen items-center justify-center  bg-gray-50 dark:bg-gray-800 dark:text-white text-gray-900"">

    </div>

    <script>
        $(document).ready(function() {
            $("#course").hide();
            getCourse();
        })

        function checkAgreement() {
            if ($("#agreeCheckbox").is(':checked')) {
                startQuiz();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'You must agree to the terms and conditions before starting the quiz.',
                    confirmButtonText: 'OK',
                    customClass: {
                        confirmButton: 'bg-blue-500 text-white rounded-lg px-4 py-2'
                    }
                });
            }
        }

        function startQuiz() {
            $("#term-condition").hide();
            $("#course").show();

        }

        function getCourse() {
            $.ajax({
                url: "{{ route('getCourseDetailsEmployee') }}",
                type: "GET",
                data: {
                    id: $("#course-id").val(),
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    console.log(response);
                    $("#course-thumbnail").append(`<img src="${response.course.thumbnail_url}" alt="Thumbnail"
                        class=" w-full h-32 object-cover rounded-md">`)
                        $("#course-name").text(response.course.name)
                        $("#course-description").text(response.course.description)
                },
            })
        }
    </script>
@endsection

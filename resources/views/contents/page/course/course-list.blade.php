@extends('layouts.employee-master')
@section('content')
    @include('contents.modal.course.course-desc')
    <div class="p-4 w-full flex flex-col h-full min-h-screen  bg-gray-50 dark:bg-gray-800 dark:text-white text-gray-900">
        <div class="">
            <div class="flex p-4 items-center justify-between">
                <h1 class="text-3xl font-semibold">Course Lists</h1>

            </div>
            <div class="flex flex-col gap-4 p-4">
                <div class="max-w-full md:max-w-xs">
                    <div>
                        <label for="course_status" class="mb-1 block text-xs md:text-sm font-medium">Status</label>
                        <select id="course_status" name="course_status" onchange="getCourse()"
                            class="bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="all">All</option>
                            <option value="completed">Completed</option>
                            <option value="incomplete">No Progress</option>
                            <option value="retake">Retake</option>

                        </select>
                    </div>

                </div>
                <div class="flex md:flex-row flex-col justify-between items-start md:items-center mt-8">
                    <div class="flex md:fs-center mb-4 md:mb-0">
                        <label for="show"
                            class="mr-2 text-xs md:text-lex-row flex-col items-start md:item-sm font-medium mb-2 md:mb-0">Show</label>
                        <select id="show" name="show" onchange="getCourse()"
                            class="bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="30">30</option>
                        </select>
                    </div>
                    <div class="flex items-center">
                        <input type="text" id="search" name="search" onchange="getCourse()"
                            class="bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 w-64 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Search...">
                    </div>
                </div>
                <div class=" min-w-38 overflow-x-auto md:min-w-full">
                    <div id="course-list" class="grid lg:grid-cols-3  grid-cols-1 gap-4">


                    </div>
                </div>

                <nav class="flex items-center flex-column flex-col md:flex-row justify-between p-4"
                    aria-label="Table navigation">
                    <span
                        class="mb-4 md:mb-0 text-xs md:text-sm font-normal text-gray-500 dark:text-gray-400 block w-full md:inline md:w-auto">Showing
                        <span class="font-semibold text-gray-900 dark:text-white"> <span id="numberFirstItem">0</span> -
                            <span id="numberLastItem">0</span></span> of
                        <span id="totalCourseCount" class="font-semibold text-gray-900 dark:text-white">0</span>
                    </span>
                    <ul id="pagination-page-button"
                        class="inline-flex space-x-2 rtl:space-x-reverse text-xs md:text-sm h-8">

                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            getCourse()
        })

        function showDescription(name, desc) {
            showModal('course-desc');
            $("#title-course-desc").text(name)
            $("#course-desc-details").text(desc)
        }

        function getCourse(page = 1) {
            let show = $('#show').val();
            let search = $('#search').val();
            let courseStatus = $('#course_status').val();
            $.ajax({
                url: "{{ route('getCourseEmployee') }}",
                type: "GET",
                data: {
                    page: page,
                    show: show,
                    search: search,
                    courseStatus: courseStatus
                },
                success: function(response) {
                    // console.log(response)
                    let data = response;
                    let courses = data.courses;
                    $("#course-list").empty();
                    // console.log(courses);
                    courses.forEach(course => {
                        let totalQuiz = 0;
                        let totalMaterial = 0;
                        // console.log(course);
                        course.course_quiz_material.forEach(quizMaterial => {

                            if (quizMaterial.model_type == 'quiz') {
                                totalQuiz++;
                            } else if (quizMaterial.model_type == 'material') {
                                totalMaterial++;
                            }
                        });
                        let additionalData = '';
                        let buttonStart =
                            `   <button onclick="startCourse(${course.id})"
                                        class="px-4 py-2 text-xs md:text-sm font-medium text-white bg-green-600 rounded-xl hover:bg-green-700 dark:bg-green-500 dark:hover:bg-green-600 flex items-center">Start</button>`;

                        if (course.can_retake == false && course.score == null) {
                            colorStatus =
                                `bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300`;
                            status = `Not Started`;
                        } else if (course.can_retake == false) {
                            colorStatus =
                                `bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300`;
                            status = `Completed`;
                            buttonStart = ``;
                        } else if (course.can_retake == true) {
                            colorStatus =
                                `bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300`;
                            status = `Retake`;
                        }
                        if (course.score == null) {
                            colorScore =
                                `bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300`;
                            score = `-`;
                        }
                        if (course.score != null) {
                            if (course.score > 60) {
                                colorScore =
                                    `bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300`;
                                score = `${course.score} %`;
                            } else {
                                colorScore =
                                    `bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300`;
                                score = `${course.score} %`;
                            }

                        }
                        let tr = `<div class="col-span-1">
                            <div class="bg-white dark:bg-gray-700 shadow-md rounded-xl p-4">
                               <div class="flex md:flex-row flex-col items-start md:justify-between">
                                    <h1 class="md:text-2xl txt-sm mb-2 md:mb-0  font-semibold text-gray-900 dark:text-white">${course.name}</h1>
                                    <div class="flex items-center justify-end">
                                        <div class="text-xs md:text-sm ${colorStatus}  font-medium me-2 px-2.5 py-0.5 rounded inline-block">
                                            ${status}
                                        </div>
                                        <div class="text-xs md:text-sm bg-blue-100 text-blue-800 ${colorScore} dark:bg-blue-900 dark:text-blue-300  font-medium me-2 px-2.5 py-0.5 rounded inline-block">
                                            ${score}
                                        </div>
                                        </div> 
                                </div>
                                    <div class="py-4">
                                    <img src="${course.thumbnail_url}" alt="Thumbnail"
                                        class=" w-full  object-cover rounded-md">
                                </div>
                                    <table class="text-sm text-gray-400 w-full">
                                        <tr>
                                            <td class="py-1 pr-2">Total Material</td>
                                            <td class="py-1">: ${totalMaterial}</td>
                                        </tr>
                                        <tr>
                                            <td class="py-1 pr-2">Total Quiz</td>
                                            <td class="py-1">: ${totalQuiz}</td>
                                        </tr>
                                    </table>

                                <div class="flex justify-end pt-4 gap-2">
                                    <button onclick="showDescription('${course.name}', '${course.description}')"
                                        class="px-4 py-2 text-xs md:text-sm font-medium text-white bg-blue-600 rounded-xl hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 flex items-center">Description</button>

                                    ${buttonStart}

                                </div>
                            </div>
                        </div>`;
                        $("#course-list").append(tr)

                    });

                    $("#numberFirstItem").text(
                        response.courses != 0 ? (page - 1) * $("#show").val() + 1 : 0
                    );
                    $("#numberLastItem").text(
                        (page - 1) * $("#show").val() + response.courses.length
                    );
                    $("#totalCourseCount").text(response.courseTotal);
                    paginationAdminCourse("#pagination-page-button", response.pageCount, response
                        .currentPage);

                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }

        function startCourse(id) {
            let url = "{{ route('startCourseView', ['id' => '__ID__']) }}";
            window.location.href = url.replace('__ID__', id);
        }
    </script>
@endsection

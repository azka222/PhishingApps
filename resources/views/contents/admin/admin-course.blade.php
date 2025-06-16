@extends('layouts.master')
@section('title', 'Fischsim - Admin Courses')
@section('content')
    <div class=" p-4 w-full flex flex-col h-full min-h-screen  bg-gray-50 dark:bg-gray-800 dark:text-white text-gray-900">
        <div class="">
            <div class="flex p-4 items-center justify-between">
                <h1 class="text-3xl font-semibold">Course Lists</h1>
                <div>
                    <button onclick="createCoursePage()"
                        class="px-4 py-2 text-xs md:text-sm font-medium text-white bg-blue-600 rounded-xl hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="size-4 md:hidden">
                            <path fill-rule="evenodd"
                                d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 9a.75.75 0 0 0-1.5 0v2.25H9a.75.75 0 0 0 0 1.5h2.25V15a.75.75 0 0 0 1.5 0v-2.25H15a.75.75 0 0 0 0-1.5h-2.25V9Z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="hidden md:inline">Create Course</span>
                    </button>
                </div>
            </div>
            <div class="flex flex-col gap-4 p-4">
                <div class="max-w-full md:max-w-xs">
                </div>
            </div>
            <div class="flex md:flex-row flex-col justify-between items-start md:items-center mt-8">
                <div class="flex md:flex-row flex-col items-start md:items-center mb-4 md:mb-0">
                    <label for="show" class="mr-2 text-xs md:text-sm font-medium mb-2 md:mb-0">Show</label>
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
            <div class="min-w-32 overflow-x-auto md:min-w-full">
                <table class="min-w-32 md:min-w-full divide-y divide-gray-200 dark:divide-gray-700 mt-4">
                    <thead class="bg-gray-300 dark:bg-gray-700">
                        <tr
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                            <th scope="col" class="p-4">Course name</th>
                            <th scope="col" class="p-4">Total Material</th>
                            <th scope="col" class="p-4">Total Quiz</th>
                            <th scope="col" class="p-4">Action</th>
                        </tr>
                    </thead>
                    <tbody id="list-admin-course-tbody"
                        class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">

                    </tbody>
                </table>
            </div>
            <nav class="flex items-center flex-column flex-col md:flex-row justify-between p-4"
                aria-label="Table navigation">
                <span
                    class="mb-4 md:mb-0 text-xs md:text-sm font-normal text-gray-500 dark:text-gray-400 block w-full md:inline md:w-auto">Showing
                    <span class="font-semibold text-gray-900 dark:text-white"> <span id="numberFirstItem">0</span> -
                        <span id="numberLastItem">0</span></span> of
                    <span id="totalCourseCount" class="font-semibold text-gray-900 dark:text-white">0</span>
                </span>
                <ul id="page-button-admin-course" class="inline-flex space-x-2 rtl:space-x-reverse text-xs md:text-sm h-8">

                </ul>
            </nav>
        </div>
    </div>
    </div>

    <script>
        $(document).ready(function() {
            getCourse();
        });

        function createCoursePage() {
            window.location.href = "{{ route('createCourseView') }}";
        }

        function getCourse(page = 1) {
            let show = $('#show').val();
            let search = $('#search').val();
            $.ajax({
                url: "{{ route('getCourse') }}",
                type: "GET",
                data: {
                    page: page,
                    show: show,
                    search: search
                },
                success: function(response) {
                    let data = response;
                    let courses = data.courses;
                    $('#list-admin-course-tbody').empty();
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
                        let tr = `<tr class="text-xs md:text-sm font-light text-gray-600 dark:text-gray-400 bg-white dark:bg-gray-800">
                                <td class="p-4">${course.name}</td>
                                <td class="p-4">${totalMaterial}</td>
                                <td class="p-4">${totalQuiz}</td>
                                <td class="p-4 flex gap-2">
                                    <button onclick="editCoursePage(${course.id})"
                                    class="px-4 py-2 text-xs md:text-sm font-medium text-white bg-blue-600 rounded-xl hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600">Update</button>
                                      <button onclick="deleteCourse(${course.id})"
                                    class="px-4 py-2 text-xs md:text-sm font-medium text-white bg-red-600 rounded-xl hover:bg-red-700 dark:bg-red-500 dark:hover:bg-red-600">Remove</button>
                                </td>
                            </tr>`;
                        $('#list-admin-course-tbody').append(tr);
                    });

                    $("#numberFirstItem").text(
                        response.courses != 0 ? (page - 1) * $("#show").val() + 1 : 0
                    );
                    $("#numberLastItem").text(
                        (page - 1) * $("#show").val() + response.courses.length
                    );
                    $("#totalCourseCount").text(response.courseTotal);
                    paginationAdminCourse("#page-button-admin-course", response.pageCount, response
                        .currentPage);

                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }

        function deleteCourse(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                reverseButtons: true,
                confirmButtonText: 'Yes, remove it!',
                cancelButtonText: 'No, cancel!',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 ml-2',
                    cancelButton: 'bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('deleteCourse') }}",
                        type: "POST",
                        data: {
                            id: id,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            getCourse();
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: 'Your course has been deleted.',
                                showConfirmButton: true,
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'OK',
                                customClass: {
                                    confirmButton: 'bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700',

                                },

                            })
                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                        }
                    });
                }
            })
        }

        function editCoursePage(id) {
            let url = "{{ route('editCourseView', ['id' => '__ID__']) }}";
            window.location.href = url.replace('__ID__', id);
        }
    </script>




@endsection

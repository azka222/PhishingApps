@extends('layouts.master')
@section('title', 'Fischsim - Create Course')
@section('content')
    <input type="hidden" id="options" value="{{ json_encode($options) }}">
    <div class=" p-4 w-full flex flex-col h-full min-h-screen  bg-gray-50 dark:bg-gray-800 dark:text-white text-gray-900">
        <div class="flex p-4 items-center justify-between">
            <h1 class="text-3xl font-semibold">Create Course</h1>
            <div class="flex flex-row items-center gap-2">
                <button onclick="uploadThumbnail()">
                    <div>
                        <label for="uploadThumbnail"
                            class="cursor-pointer px-4 py-2 text-xs md:text-sm font-medium text-white bg-green-600 rounded-xl hover:bg-green-700 dark:bg-green-500 dark:hover:bg-green-600 flex items-center">
                            <span class="hidden md:inline">Upload Thumbnail</span>
                        </label>
                        <input type="file" id="uploadThumbnail" class="hidden" accept="image/*">
                    </div>
                </button>
                <button onclick="saveCourse()"
                    class="px-4 py-2 text-xs md:text-sm font-medium text-white bg-blue-600 rounded-xl hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                        class="size-4 md:hidden">
                        <path fill-rule="evenodd"
                            d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 9a.75.75 0 0 0-1.5 0v2.25H9a.75.75 0 0 0 0 1.5h2.25V15a.75.75 0 0 0 1.5 0v-2.25H15a.75.75 0 0 0 0-1.5h-2.25V9Z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="hidden md:inline">Save</span>
                </button>

            </div>
        </div>
        <div>
            <div class="mb-6 flex flex-col justify-center items-center">
                <label for="large-input" class="block mb-2 text-xl font-medium text-gray-900 dark:text-white">Course
                    Name</label>
                <input type="text" placeholder="Enter course name here..." id="large-input"
                    class="block w-1/2 p-4 my-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-base focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <div class="w-1/2 mt-8">
                    <div id="image-course" class="mb-6 min-w-full max-w-full rounded-full">
                    </div>
                </div>
                <label for="quiz-description" class="block mb-2 mt-6 text-sm sm:text-base font-medium">Description
                </label>
                <textarea id="quiz-description" rows="6"
                    class=" bg-gray-50 border border-gray-300 dark:border-gray-600 dark:text-white dark:bg-gray-700 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/2 p-2.5"
                    placeholder="Enter description here..." required></textarea>
            </div>

            <div class="content flex flex-col items-center justify-center">
                {{-- content here --}}


            </div>
            <div class="flex flex-row items-center justify-center">
                <button type="button" onclick="addMaterialContent()"
                    class="text-white w-56 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                    + Material</button>
                <button type="button" onclick="addQuizContent()"
                    class="text-white w-56 bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 focus:outline-none dark:focus:ring-green-800">+
                    Quiz</button>

            </div>
        </div>
    </div>

    <script>
        function uploadThumbnail() {
            $('#uploadThumbnail').on('change', function(e) {
                const file = e.target.files[0];
                if (!file) return;
                if (!file.type.startsWith('image/')) {
                    alert('File harus berupa gambar!');
                    return;
                }
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = $('<img>', {
                        src: e.target.result,
                        alt: 'Preview',
                        class: 'w-full h-auto rounded-xl shadow'
                    });

                    $('#image-course').html(img);
                };

                reader.readAsDataURL(file);
            });
        }

        function uploadContent(idButton, idTarget) {
            $('#' + idButton).on('change', function(e) {
                const file = e.target.files[0];
                if (!file) return;
                if (!file.type.startsWith('image/')) {
                    alert('File harus berupa gambar!');
                    return;
                }
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = $('<img>', {
                        src: e.target.result,
                        alt: 'Preview',
                        class: 'w-full h-auto rounded-xl shadow'
                    });

                    $('#' + idTarget).html(img);
                };

                reader.readAsDataURL(file);
            });
        }

        function getOptions(index) {
            let selectedOption = $('#options-' + index).val();
            console.log(selectedOption)
        }

        function deleteContentQuiz() {
            $(event.target).closest('.content-quiz').remove();
        }

        function deleteContentMaterial() {
            $(event.target).closest('.content-material').remove();
        }

        function checkTotalContent(type) {
            let count = 1
            if (type === 'material') {
                count = count + $(".content-material").length;
            } else if (type === 'quiz') {
                count = count + $(".content-quiz").length
            }
            return count;
        }

        function checkIndex(type) {
            let maxIndex = 0;
            let index = 0
            if (type === 'material') {
                if ($(".content-material").length > 0) {

                    $(".content-material").each(function() {
                        index = parseInt($(this).data("index"));
                        if (index > maxIndex) {
                            maxIndex = index;
                        }
                    });
                } else {
                    maxIndex = 0
                }
            } else if (type === 'quiz') {
                if ($(".content-quiz").length > 0) {
                    $(".content-quiz").each(function() {
                        index = parseInt($(this).data("index"));
                        if (index > maxIndex) {
                            maxIndex = index;
                        }
                    });
                } else {
                    maxIndex = 0;
                }
            }
            return maxIndex + 1;
        }

        function enableEmailField(index) {
            if ($('#checkbox-quiz-' + index).is(':checked')) {
                $("#quiz-email-content-" + index).val('');
                $("#email-content-box-" + index).show();
            } else {
                $("#quiz-email-content-" + index).val('');
                $("#email-content-box-" + index).hide();
            }
        }

        function checkDataOrder() {
            let order = 0;

            $(".content-material, .content-quiz").each(function() {
                let currentOrder = parseInt($(this).data("order"));
                if (currentOrder > order) {
                    order = currentOrder;
                }
            });

            return order + 1;
        }

        function addMaterialContent() {
            let index = checkIndex('material');
            let order = checkDataOrder();
            let content = `<div id="content-material-${index}" class="content-material w-1/2 h-auto m-8" data-index="${index}" data-order="${order}">
                    <div class="flex justify-end">
                        <button onclick="deleteContentMaterial()"
                            class="px-4 py-2 text-xs md:text-sm font-medium mb-4 text-white bg-red-600 rounded-xl hover:bg-red-700 dark:bg-red-500 dark:hover:bg-red-600 flex items-center">
                            <span class="hidden md:inline">Delete</span>
                    </div>
                    </button>
                    <div class=" border-2 dark:border-gray-500 border-gray-800 rounded-xl p-8">
                        <div class="flex  items-center justify-between mb-4">
                            <h1 class="text-3xl font-semibold">Material Content</h1>
                          <button onclick="uploadContent('uploadMaterialContent-${index}', 'image-material-${index}')">
                              <div>
                                <label for="uploadMaterialContent-${index}"
                                    class="cursor-pointer px-4 py-2 text-xs md:text-sm font-medium text-white bg-blue-600 rounded-xl hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 flex items-center">
                                    <span class="hidden md:inline">Upload File</span>
                                </label>
                                <input type="file" id="uploadMaterialContent-${index}" class="hidden" accept="image/*">
                            </div>
                            </button>
                        </div>
                        <div class="mb-6">
                            <label for="course-name-${index}"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Course Name</label>
                            <input type="text" id="course-name-${index}" placeholder="Enter course name here..."
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        </div>
                        <div class="mb-6">
                            <label for="course-title-index"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Course Title</label>
                            <input type="text" id="course-title-${index}" placeholder="Enter title here..."
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        </div>
                        <div id="image-material-${index}" class="mb-6 min-w-full max-w-full rounded-full">
                        </div>
                        <div class="mb-6">
                            <label for="material-overview" class="block mb-2 text-sm sm:text-base font-medium">Material
                            </label>
                            <textarea id="material-overview-${index}" rows="10"
                                class="bg-gray-50 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                placeholder="Enter material here..." required></textarea>
                        </div>
                        
                    </div>
                </div>`;

            $(".content").append(content);
        }

        function addQuizContent() {
            let index = checkIndex('quiz')
            let order = checkDataOrder();
            let content = `<div id="content-quiz-${index}" class="content-quiz w-1/2 h-auto   m-8" data-index="${index}" data-order="${order}">
                    <div class="flex justify-end">
                        <button onclick="deleteContentQuiz()"
                            class="px-4 py-2 text-xs md:text-sm font-medium mb-4 text-white bg-red-600 rounded-xl hover:bg-red-700 dark:bg-red-500 dark:hover:bg-red-600 flex items-center">
                            <span class="hidden md:inline">Delete</span>
                    </div>
                    </button>
                    <div class=" border-2 dark:border-gray-500 border-gray-800 rounded-xl p-8">
                        <div class="flex  items-center justify-between mb-4">
                            <h1 class="text-3xl font-semibold">Quiz Content</h1>
                            <button onclick="uploadContent('uploadQuizContent-${index}', 'image-quiz-${index}')">
                              <div>
                                <label for="uploadQuizContent-${index}"
                                    class="cursor-pointer px-4 py-2 text-xs md:text-sm font-medium text-white bg-blue-600 rounded-xl hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 flex items-center">
                                    <span class="hidden md:inline">Upload File</span>
                                </label>
                                <input type="file" id="uploadQuizContent-${index}" class="hidden" accept="image/*">
                            </div>
                            </button>
                        </div>
                        <div class="mb-6">
                            <label for="default-input"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Quiz Name</label>
                            <input type="text" id="quiz-name-${index}" placeholder="Enter quiz name here..."
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        </div>
                        <div class="mb-6">
                            <label for="default-input"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Quiz Title</label>
                            <input type="text" id="quiz-title-${index}" placeholder="Enter title here..."
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        </div>
                        <div id="image-quiz-${index}" class="mb-6 min-w-full max-w-full rounded-full">
                        </div>
                        <div class="flex items-center mb-4">
                            <input id="checkbox-quiz-${index}" type="checkbox" onchange=enableEmailField(${index}) class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="default-checkbox" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Use email content?</label>
                        </div>
                         <div id="email-content-box-${index}" class="mb-6" hidden>
                            <label for="quiz-email-content-${index}" class="block mb-2 text-sm sm:text-base font-medium">Email Content
                            </label>
                            <textarea id="quiz-email-content-${index}" rows="10"
                                class="bg-gray-50 border border-gray-300 dark:border-gray-600 dark:text-white dark:bg-gray-700 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                placeholder="Enter email content here..." required></textarea>
                        </div>
                        <div class="mb-6">
                            <label for="quiz-overview" class="block mb-2 text-sm sm:text-base font-medium">Quiz
                            </label>
                            <textarea id="quiz-overview-${index}" rows="10"
                                class="bg-gray-50 border border-gray-300 dark:border-gray-600 dark:text-white dark:bg-gray-700 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                placeholder="Enter quiz here..." required></textarea>
                        </div>
                        <div>
                            <label for="options" class="block mb-2 text-sm sm:text-base font-medium">Options
                            </label>
                         <select id="options-${index}" onchange="getOptions(${index})"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option selected disabled value="0">Choose an option</option>
                            @foreach ($options as $optionGroup)
                                <optgroup label="{{ $optionGroup['group'] }}">
                                    @foreach ($optionGroup['options'] as $option)
                                        <option value="{{ $option['id'] }}">{{ $option['name'] }}</option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                    </div>
                </div>`

            $(".content").append(content)
        }

        function saveCourse() {
            let courseName = $('#large-input').val();
            let courseThumbnail = document.getElementById('uploadThumbnail').files[0];
            let courseDescription = $('#quiz-description').val();
            let contents = [];
            let order = 1;
            $(".content-material, .content-quiz").sort(function(a, b) {
                return $(a).data("order") - $(b).data("order");
            }).each(function() {
                let index = $(this).data("index");
                let type = $(this).hasClass("content-material") ? "material" : "quiz";
                let attachmentId = type === "material" ? 'uploadMaterialContent-' + index : 'uploadQuizContent-' +
                    index;
                let attachment = document.getElementById(attachmentId)?.files[0] ?? null;
                let content = {
                    type: type,
                    name: $('#' + (type === 'material' ? 'course-name-' : 'quiz-name-') + index).val(),
                    attachment: attachment,
                    title: $('#' + (type === 'material' ? 'course-title-' : 'quiz-title-') + index).val(),
                    content: $('#' + (type === 'material' ? 'material-overview-' : 'quiz-overview-') + index)
                        .val(),
                    order: order,
                };
                if (type === 'quiz') {
                    content.emailContent = $('#quiz-email-content-' + index).val();
                    content.option = $('#options-' + index).val();
                }

                contents.push(content);
                order++;
            });
            let formData = new FormData();
            formData.append('courseName', courseName);
            formData.append('courseDescription', courseDescription);
            if (courseThumbnail != undefined) {
                formData.append('courseThumbnail', courseThumbnail);
            }

            contents.forEach((item, idx) => {
                formData.append(`contents[${idx}][type]`, item.type);
                formData.append(`contents[${idx}][name]`, item.name);
                formData.append(`contents[${idx}][title]`, item.title);
                formData.append(`contents[${idx}][content]`, item.content);
                formData.append(`contents[${idx}][order]`, item.order);

                if (item.attachment) {
                    formData.append(`contents[${idx}][attachment]`, item.attachment);
                }

                if (item.type === 'quiz' && item.emailContent) {
                    formData.append(`contents[${idx}][emailContent]`, item.emailContent);
                }
                if (item.type === 'quiz' && item.option) {
                    formData.append(`contents[${idx}][option]`, item.option);
                }
            });
            formData.append('_token', '{{ csrf_token() }}');
            $.ajax({
                url: '{{ route('createCourse') }}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    // alert('Course created successfully!');
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                        showConfirmButton: true,
                        showCancelButton: false,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK',
                        customClass: {
                            confirmButton: 'bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700',

                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "{{ route('adminCourseView') }}";
                        }
                    });

                },
                error: function(xhr, status, error) {
                    // alert('Error creating course: ' + xhr.responseText);
                    let errorMessage = JSON.parse(xhr.responseText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: errorMessage.message,
                        showConfirmButton: true,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK',
                        customClass: {
                            confirmButton: 'bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700',

                        }
                    });
                }
            });
        }
    </script>
@endsection

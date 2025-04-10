@extends('layouts.master')
@section('title', 'Fischsim - Create Course')
@section('content')
    <div class=" p-4 w-full flex flex-col h-full min-h-screen  bg-gray-50 dark:bg-gray-800 dark:text-white text-gray-900">
        <div class="flex p-4 items-center justify-between">
            <h1 class="text-3xl font-semibold">Create Course</h1>
            <div>
                <button onclick="saveCourse()"
                    class="px-4 py-2 text-xs md:text-sm font-medium text-white bg-blue-600 rounded-xl hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4 md:hidden">
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
                    class="block w-1/2 p-4 mt-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-base focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
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

        function enableEmailField(index){
            if($('#checkbox-quiz-'+index).is(':checked')){
                $("#email-content-box-"+index).show();  
            }
            else{
                $("#email-content-box-"+index).hide();  
            }
        }

        function addMaterialContent() {
            let index = checkIndex('material');
            let content = `<div id="content-material-${index}" class="content-material w-1/2 h-auto m-8" data-index="${index}">
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
            let content = `<div id="content-quiz-${index}" class="content-quiz w-1/2 h-auto   m-8" data-index="${index}">
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
                    </div>
                </div>`

            $(".content").append(content)
        }

        function saveCourse(){
            let courseName = $('#large-input').val();
            let courseDescription = $('#quiz-description').val();
            let contents = [];
            $(".content-material").each(function() {
                let index = $(this).data("index");
                let attachment = document.getElementById('uploadMaterialContent-' + index)?.files[0] ?? null;
                let content = {
                    type: 'material',
                    name: $('#course-name-' + index).val(),
                    attachment: attachment,
                    title: $('#course-title-' + index).val(),
                    content: $('#material-overview-' + index).val(),
                }
                contents.push(content);
            });
            $(".content-quiz").each(function() {
                let index = $(this).data("index");
                let attachment = document.getElementById('uploadQuizContent-' + index)?.files[0] ?? null;
                let content = {
                    type: 'quiz',
                    name: $('#quiz-name-' + index).val(),
                    attachment: attachment,
                    title: $('#quiz-title-' + index).val(),
                    content: $('#quiz-overview-' +index).val(),
                    emailContent: $('#quiz-email-content-' + index).val()
                }
                contents.push(content);
            });
            console.log(courseName, courseDescription, contents);
        }
    </script>
@endsection

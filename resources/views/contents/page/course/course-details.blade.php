@extends('layouts.employee-master')
@section('content')
    <input type="hidden" id="course-id" value="{{ $id }}">
    <div id="term-condition"
        class="p-4 w-full flex flex-col h-full min-h-screen md:items-center items-start justify-center  bg-gray-50 dark:bg-gray-800 dark:text-white text-gray-900">
        <div class="flex flex-col mt-8 lg:w-1/2 md:w-full w-full dark:bg-gray-700 bg-gray-200 p-8 rounded-xl">
            <h1 class="md:text-3xl text-xl mb-4 font-semibold" id="course-name">Nama Course Nanti Disini</h1>
            <div class="py-4" id="course-thumbnail">

            </div>
            <div class="mt-8 rounded-xl min-h-[5rem]">
                <h2>
                    Description :
                </h2>
                <h2 id="course-description" class="mt-2 text-xs md:text-sm">
                    Nanti Description Disini
                </h2>
            </div>
            <div class="max-w-full mt-8">
                <h2 class="md:text-2xl text-xl font-semibold mb-4">📜 Terms and Conditions</h2>
                <ul class="list-disc list-inside mb-4">
                    <li class="mt-2 text-xs md:text-sm"><strong>Single Attempt Only:</strong> You are allowed to start the
                        quiz only once.
                        Once started, it
                        cannot be restarted.</li>
                    <li class="mt-2 text-xs md:text-sm"><strong>Time Limit:</strong> The total time allocated for the quiz
                        is <strong>60
                            minutes</strong>.
                    </li>
                    <li class="mt-2 text-xs md:text-sm"><strong>No Page Refreshing:</strong> Do <strong>not</strong> refresh
                        or reload the
                        page during the
                        quiz. Doing so will result in the <strong>loss of all your answers</strong>.</li>
                </ul>
                <hr class="border-t-2 border-gray-300 my-8">
                <div class="flex md:flex-row flex-col items-center justify-between">
                    <div class="flex items-center mb-4">
                        <input id="agreeCheckbox" type="checkbox" value=""
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-lg focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                        <label for="default-checkbox"
                            class="ms-2 text-xs md:text-sm font-medium text-gray-900 dark:text-gray-300">
                            I have read and agree to the Terms and Conditions</label>
                    </div>

                    <button id="startButton" onclick="checkAgreement()"
                        class="px-4 py-2 text-sm md:text-xs font-medium text-white rounded-xl 
                           bg-green-600 dark:bg-green-500 w-full md:w-32
                           hover:bg-green-700 dark:hover:bg-green-600 
                           disabled:bg-gray-400 
                           disabled:text-gray-200 transition-colors duration-200">
                        <span class="">Start</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div id="course"
        class="p-4 w-full flex xl:flex-row flex-col h-full min-h-screen bg-gray-50 dark:bg-gray-800 dark:text-white text-gray-900">
        <div class="xl:hidden flex w-full p-4 justify-end">
            <div class="">
                <button id="submitButton" onclick="checkAllQuizAnswered()"
                    class="px-4 py-2 text-md md:text-sm font-medium text-white rounded-xl 
                       bg-green-600 dark:bg-green-500 
                       hover:bg-green-700 dark:hover:bg-green-600 
                    ">
                    <span class="text-xs md:text-sm">Submit</span>
                </button>
            </div>
        </div>
        <div class="w-full lg:w-1/4 dark:bg-gray-800 bg-gray-200 p-4 items-start rounded-xl hidden xl:flex">

            <div id="number-section" class="grid grid-cols-4 gap-4">


            </div>
        </div>
        <div class="w-full xl:w-1/2 p-4" id="content-section">

        </div>

        <div class="w-1/4 p-4 hidden xl:flex justify-end">
            <div class="">
                <button id="submitButton" onclick="checkAllQuizAnswered()"
                    class="px-4 py-2 text-md md:text-sm font-medium text-white rounded-xl 
                       bg-green-600 dark:bg-green-500 
                       hover:bg-green-700 dark:hover:bg-green-600 
                    ">
                    <span class="text-xs md:text-sm">Submit</span>
                </button>
            </div>
        </div>


    </div>

    <script>
        let totalQuestions = [];
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

        function checkAllQuizAnswered() {
            let allAnswered = true;
            let notAnswered = [];
            totalQuestions.forEach(function(order) {
                let selectedOption = $(`#option-section-${order} input[type="radio"]:checked`);
                if (selectedOption.length === 0) {
                    notAnswered.push(order);
                    allAnswered = false;
                }
            });
            if (!allAnswered) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: `You have not answered the following Quizzes: ${notAnswered.join(', ')}`,
                    confirmButtonText: 'OK',
                    customClass: {
                        confirmButton: 'bg-blue-500 text-white rounded-lg px-4 py-2'
                    }
                });
            }
            if (allAnswered) {
                let totalCorrect = 0;
                let totalWrong = 0;
                totalQuestions.forEach(function(order) {
                    let selectedOption = $(`#option-section-${order} input[type="radio"]:checked`);
                    let correctAnswer = selectedOption.data("correct");
                    if (correctAnswer) {
                        totalCorrect += 1;
                    } else {
                        totalWrong += 1;
                    }
                });
                $.ajax({
                    url: "{{ route('submitQuizEmployee') }}",
                    type: "POST",
                    data: {
                        id: $("#course-id").val(),
                        total_correct: totalCorrect,
                        total_wrong: totalWrong,
                        total_question: totalQuestions.length,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        console.log(response);
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: `You have completed the quiz!`,
                            confirmButtonText: 'OK',
                            allowOutsideClick: false,
                            customClass: {
                                confirmButton: 'bg-blue-500 text-white rounded-lg px-4 py-2'
                            }
                        }).then(() => {
                            window.location.href = "{{ route('courseLists') }}";
                        });
                    },
                })
            }
        }

        function startQuiz() {
            $("#term-condition").hide();
            $("#course").show();
            firstRender();

        }

        function shuffleArray(array) {
            for (let i = array.length - 1; i > 0; i--) {
                const j = Math.floor(Math.random() * (i + 1));
                [array[i], array[j]] = [array[j], array[i]];
            }
            return array;
        }

        function firstRender() {
            $(".need-to-hide").hide();
            $("#content-1").show();
            goToNumber(1);
        }

        function nextRender(order) {
            $(".need-to-hide").hide();
            order += 1;
            $("#content-" + order).show();
            goToNumber(order);
        }

        function previousRender(order) {
            $(".need-to-hide").hide();
            order -= 1;
            $("#content-" + order).show();
            goToNumber(order);
        }

        function goToNumber(order) {
            $(".need-to-hide").hide();
            $("#content-" + order).show();
            let buttonNumber = document.getElementById("button-number-" + order);
            $(".number-section").removeClass("bg-green-600").addClass("bg-gray-700");
            buttonNumber.classList.add("bg-green-600");
            buttonNumber.classList.remove("bg-gray-700");
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
                    $("#content-section").empty();
                    $("#number-section").empty();
                    $("#course-thumbnail").append(`<img src="${response.course.thumbnail_url}" alt="Thumbnail"
                        class=" w-full  object-cover rounded-md">`)
                    $("#course-name").text(response.course.name)
                    $("#course-description").text(response.course.description)
                    let courses = response.course.courseQuizMaterial;
                    let lastOrder = Math.max(...courses.map(course => course.order));
                    courses.forEach(function(course, index) {
                        let firsOrder = 1;
                        let order = course.order;
                        let button = '';
                        if (order == firsOrder) {
                            button = ` <button id="" onclick="nextRender(${order})"
                                            class="px-4 py-2 text-md md:text-sm font-medium text-white rounded-xl 
                                        bg-green-600 dark:bg-green-500 
                                        hover:bg-green-700 dark:hover:bg-green-600 
                                        disabled:bg-gray-400 
                                        disabled:text-gray-200 transition-colors duration-200">
                                            <span class="text-xs md:text-sm">Next</span>
                                        </button>`;
                        } else if (order == lastOrder) {
                            button = `<button id="" onclick="previousRender(${order})"
                                            class="px-4 py-2 text-md md:text-sm font-medium text-white rounded-xl 
                                    bg-blue-600 dark:bg-blue-500 
                                    hover:bg-blue-700 dark:hover:bg-blue-600 
                                    disabled:bg-gray-400 
                                    disabled:text-gray-200 transition-colors duration-200">
                                            <span class="text-xs md:text-sm">Previous</span>
                                        </button>`;
                        } else {
                            button = `
                                        <button id="" onclick="previousRender(${order})"
                                            class="px-4 py-2 text-md md:text-sm font-medium text-white rounded-xl 
                                    bg-blue-600 dark:bg-blue-500 
                                    hover:bg-blue-700 dark:hover:bg-blue-600 
                                    disabled:bg-gray-400 
                                    disabled:text-gray-200 transition-colors duration-200">
                                            <span class="text-xs md:text-sm">Previous</span>
                                        </button>
                                         <button id="" onclick="nextRender(${order})"
                                            class="px-4 py-2 text-md md:text-sm font-medium text-white rounded-xl 
                                        bg-green-600 dark:bg-green-500 
                                        hover:bg-green-700 dark:hover:bg-green-600 
                                        disabled:bg-gray-400 
                                        disabled:text-gray-200 transition-colors duration-200">
                                            <span class="text-xs md:text-sm">Next</span>
                                        </button>`;
                        }


                        if (course.model_type === 'material') {
                            let materialImage = course.model.attachment != null ? `<img src=${course.model.attachment_url}
                            class="w-full h-auto rounded-xl shadow">` : '';
                            let material = `<div id="content-${order}"
                                    class="need-to-hide w-full md:p-8 p-4 dark:bg-gray-700 border-2 dark:border-gray-500 border-gray-800 rounded-xl">
                                    <div class="flex items-center justify-center mb-4">
                                        <h1 class="md:text-3xl text-xl font-semibold">${course.model.title}</h1>
                                    </div>
                                    <div id="image-quiz" class="mb-6 rounded-full">
                                        ${materialImage}
                                    </div>
                                    <div id="desc-box" class="mt-8">
                                        <h2 class="md:text-lg text-xs">
                                           ${course.model.content}
                                        </h2>
                                    </div>
                                    
                                    <div class="flex items-center justify-end mt-8 gap-2">
                                        ${button}
                                      
                                    </div>
                                </div>`;

                            let buttonNumber = `<button onclick="goToNumber(${order})" class="4xl:col-span-1 col-span-2">
                                    <div id="button-number-${order}" class="number-section text-xs md:text-sm bg-gray-700 p-4 rounded-lg dark:hover:bg-green-600">
                                        Material ${order}
                                    </div>
                                </button>`
                            $("#content-section").append(material);
                            $("#number-section").append(buttonNumber)
                        } else if (course.model_type === 'quiz') {
                            totalQuestions.push(order);
                            let quizImage = course.model.attachment != null ? `<img src=${course.model.attachment_url}
                            class="w-full h-auto rounded-xl shadow">` : '';
                            let options = response.option.filter(opt => opt.group == course.model.option
                                .group);
                            options = shuffleArray(options);
                            let quiz = ` <div id="content-${order}"
                                            class="need-to-hide w-full md:p-8 p-2 dark:bg-gray-700   border-2 dark:border-gray-500 border-gray-800 rounded-xl">
                                            <div class="flex  items-center justify-center mb-4">
                                                <h1 class="md:text-3xl text-xl font-semibold" id="">${course.model.title}</h1>
                                            </div>
                                            <div id="image-quiz-${order}" class="mb-6  rounded-full">
                                                ${quizImage}
                                            </div>
                                            <div id="desc-box" class="mt-8">
                                                <h2 id="quiz-material-${order}" class="text-xs md:text-lg">
                                                    ${course.model.content}
                                                </h2>
                                            </div>
                                            <div id="option-section-${order}" class="flex flex-row items-center justify-center gap-4 mt-8">
                                            
                                            </div>
                                            <div class="flex items-center justify-end mt-8 gap-2">
                                               ${button}
                                            </div>
                                        </div>`;

                            let buttonNumber = `<button onclick="goToNumber(${order})" class="4xl:col-span-1 col-span-2">
                                    <div id="button-number-${order}" class="number-section text-xs md:text-sm  bg-gray-700 p-4 rounded-lg dark:hover:bg-green-600">
                                        Quiz ${order}
                                    </div>
                                </button>`
                            $("#content-section").append(quiz)
                            $("#number-section").append(buttonNumber);
                            options.forEach(function(option, index) {
                                let correct = false;
                                if (course.model.option_id == option.id) {
                                    correct = true
                                }
                                let optionQuiz = `<div class="border-2 dark:border-gray-500 md:p-4 p-2 rounded-xl 2xl:min-w-[20rem] min-w-[5rem]">
                                                    <div class="flex items-center">
                                                        <input id="option-${index}-${order}" type="radio" value="${option.id}" name="default-radio-${order}" data-correct="${correct}"
                                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600  focus:ring-2 ">
                                                        <label for="option-${index}-${order}"
                                                            class="ms-2 text-xs md:text-sm font-medium text-gray-900 dark:text-gray-300">${option.name}</label>
                                                    </div>
                                                </div>`;
                                $("#option-section-" + order).append(optionQuiz);
                            });


                        }


                    });

                },
            })
        }
    </script>
@endsection

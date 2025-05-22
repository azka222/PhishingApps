@extends('layouts.master')
@section('title', 'Fischsim - Dashboard')
@section('content')
    @include('contents.modal.dashboard.showAllEmployee')
    <div class="p-8 w-full flex flex-col h-full min-h-screen  bg-gray-50 dark:bg-gray-800 dark:text-white text-gray-900">
        <div class="judul-1">
            <div class="flex py-4 items-center justify-between">
                <h1 class="text-3xl font-semibold">Dashboard</h1>
            </div>
        </div>

        <div class="flex flex-col gap-4 md:gap-8">
            <div class="bg-white dark:bg-gray-900 shadow-md rounded-lg p-4">
                <h2 class="md:text-xl text-sm font-semibold">Welcome to Fischsim</h2>
                <p class="text-gray-600 text-xs md:text-sm dark:text-gray-400">This is your dashboard where you can manage
                    your phishing
                    simulations.</p>
            </div>

            {{-- <div class="bg-white dark:bg-gray-900 shadow-md rounded-lg p-4">
                <h2 class="text-xl font-semibold">Recent Activity</h2>
                <ul class="list-disc pl-5">
                    <li>New phishing simulation created.</li>
                    <li>User registered for a new simulation.</li>
                    <li>Simulation report generated.</li>
                </ul>
            </div> --}}

            @IsAdmin()
            <div class="max-w-full md:max-w-xs">
                <div>
                    <label for="companyCheckAdmin"
                        class="mb-1  block text-xs md:text-sm font-medium text-gray-700 dark:text-gray-300">Company</label>
                    <select id="companyCheckAdmin" name="companyCheckAdmin" onchange="getDashboardValue()"
                        class="bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="">All</option>
                        @foreach ($companies as $company)
                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            @endIsAdmin()

            <div class="grid grid-cols-4 gap-4 md:gap-8  dark:text-white  w-full">
                <div class="col-span-4 md:col-span-2 bg-white dark:bg-gray-700 rounded-lg p-4">
                    <div class="relative">
                        <h2 class="text-xs md:text-sm font-semibold text-center">5 Recent Human Risks</h2>

                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full divide-y text-sm divide-gray-200 dark:divide-gray-700 mt-4">
                            <thead class="bg-gray-50 dark:bg-gray-700 text-xs md:text-sm">
                                <tr class="border-b">
                                    <th class="p-4 text-left">Target Name</th>
                                    <th class="p-4 text-left">Phishing Score</th>
                                    <th class="p-4 text-left">Course Score</th>
                                    <th class="p-4 text-left">Risk to Company</th>
                                </tr>
                            </thead>
                            <tbody id="list-human-risk-tbody" class="">
                            </tbody>
                        </table>
                    </div>
                    <div class="flex items-center justify-end mt-4">
                        <button id="showAllEmployee" type="button"
                            class="text-xs md:text-sm font-medium text-white bg-blue-600 rounded-xl hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 px-4 py-2">
                            View All
                        </button>

                    </div>

                </div>
                <div class="col-span-4 md:col-span-2 bg-white dark:bg-gray-700 rounded-lg p-4">
                    <div class="relative">
                        <h2 class="text-xs md:text-sm font-semibold text-center">5 Recent Campaigns</h2>

                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full divide-y text-sm divide-gray-200 dark:divide-gray-700 mt-4">
                            <thead class="bg-gray-50 dark:bg-gray-700 text-xs md:text-sm">
                                <tr class="border-b">
                                    <th scope="col" class="p-4 text-left">Name</th>
                                    <th scope="col" class="p-4 text-left">Status</th>
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="list-campaign-tbody" class="">
                            </tbody>
                        </table>
                    </div>
                    <div class="flex items-center justify-end mt-4">
                        <button onclick="showCampaignPage()"
                            class="text-xs md:text-sm font-medium text-white bg-blue-600 rounded-xl hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 px-4 py-2">
                            View All
                        </button>
                    </div>

                </div>
                <div class="col-span-4 md:col-span-2 bg-white dark:bg-gray-700 rounded-lg">
                    <label for="column-risk-score"
                        class="text-xs md:text-sm font-semibold mb-4 flex items-center justify-center m-4">Human
                        Risks</label>
                    <div id="column-risk-score">

                    </div>
                </div>
                <div class="col-span-4 md:col-span-2 bg-white dark:bg-gray-700 rounded-lg">
                    <label for="column-risk-score"
                        class="text-xs md:text-sm font-semibold mb-4 flex items-center justify-center m-4">User Risk
                        Distribution by Age Group</label>
                    <div id="area-chart-age-group"></div>
                </div>
                <div class="col-span-4">
                    <div class="bg-white dark:bg-gray-700 dark:text-white rounded-lg p-4">
                        <div class="">
                            <label for="column-risk-score"
                                class="text-xs md:text-sm font-semibold flex items-center justify-center">Phishing
                                Simulation Engagement Summary</label>
                        </div>
                        <div class="grid grid-cols-4 gap-4 p-4">
                            <div class="col-span-4 lg:col-span-1 md:col-span-2  flex flex-col items-center justify-center">
                                <p class="text-xs md:text-sm font-semibold mb-4">Emails Sent</p>
                                <div id="donut-email-sent"></div>
                            </div>
                            <div class="col-span-4 lg:col-span-1 md:col-span-2 flex flex-col items-center justify-center">
                                <p class="text-xs md:text-sm font-semibold mb-4">Emails Opened</p>
                                <div id="donut-email-opened"></div>
                            </div>
                            <div class="col-span-4 lg:col-span-1 md:col-span-2 flex flex-col items-center justify-center">
                                <p class="text-xs md:text-sm font-semibold mb-4">Links Clicked</p>
                                <div id="donut-link-clicked"></div>
                            </div>
                            <div class="col-span-4 lg:col-span-1 md:col-span-2  flex flex-col items-center justify-center">
                                <p class="text-xs md:text-sm font-semibold mb-4">Submitted Data</p>
                                <div id="donut-submitted-data"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>




    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        let humanRisks = [];
        let campaigns = [];
        let dashboardRequest = null;
        $(document).ready(function() {
            getDashboardValue();

            $("#showAllEmployee").on('click', function() {
                showAllEmployeeRisks(humanRisks);
            });



        });

        function getDashboardValue() {
            Swal.fire({
                title: 'Loading...',
                allowOutsideClick: false,
                text: 'Please wait while we load the data',
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            let companyId = $('#companyCheckAdmin').val();
            let status = 2;
            let show = 5;
            if (dashboardRequest) {
                dashboardRequest.abort();
            } else {
                dashboardRequest = $.ajax({
                    url: "{{ route('getDashboardData') }}",
                    type: "GET",
                    data: {
                        show: show,
                        status: status,
                        companyId: companyId
                    },
                    success: function(response) {
                        dashboardRequest = null;
                        campaigns = response.campaigns;
                        humanRisks = response.human_risk;
                        $("#list-campaign-tbody").empty();


                        getCampaignTable(campaigns);
                        getHumanRiskTable(humanRisks);

                        let dataEmailSent = calculateEmailSent(campaigns);
                        let dataEmailOpened = calculateEmailOpened(campaigns);
                        let dataLinkClicked = calculateLinkClicked(campaigns);
                        let dataSubmittedData = calculateSubmittedData(campaigns);

                        getEmailSentChart(dataEmailSent.emailSent, dataEmailSent.emailNotSent, dataEmailSent
                            .totalEmail);
                        getEmailOpenedChart(dataEmailOpened.emailOpened, dataEmailOpened.emailNotOpen,
                            dataEmailOpened.totalEmail);

                        getLinkClickedChart(dataLinkClicked.linkClicked, dataLinkClicked.linkNotClicked,
                            dataLinkClicked.totalEmail);

                        getSubmittedData(dataSubmittedData.linkSubmitted, dataSubmittedData.linkNotSubmitted,
                            dataSubmittedData.totalEmail);

                        getRiskScoreData(response.parameters.high, response.parameters.medium,
                            response.parameters.low);

                        getRiskScoreByAgeGroup(response.age_groups);

                        Swal.close();

                    }
                });
            }
        }

        function getHumanRiskTable(humanRisks) {
            $("#list-human-risk-tbody").empty();
            // console.log(humanRisks);
            if (humanRisks.length == 0) {
                $("#list-human-risk-tbody").append(`
                        <tr class="text-xs md:text-sm font-normal text-gray-900 dark:text-gray-400 bg-white dark:bg-gray-700">
                            <td class="p-4" colspan="4">
                                No data available
                            </td>
                        </tr>
                    `);
            } else {
                humanRisksSliced = humanRisks.slice(0, 5);
                humanRisksSliced.forEach((humanRisk, index) => {
                    let date = new Date(humanRisk.created_date);
                    let formattedDate =
                        `${date.toLocaleDateString('id-ID', {
                            day: '2-digit',
                            month: 'long',
                            year: 'numeric'
                        })} ${String(date.getUTCHours()).padStart(2, '0')}:${String(date.getUTCMinutes()).padStart(2, '0')}`;
                    if (humanRisk.adjusted_risk >= 70) {
                        humanRisk.adjusted_risk =
                            `<span class="text-red-500 font-semibold">${humanRisk.adjusted_risk}</span>`;
                    } else if (humanRisk.adjusted_risk >= 40) {
                        humanRisk.adjusted_risk =
                            `<span class="text-yellow-500 font-semibold">${humanRisk.adjusted_risk}</span>`;
                    } else {
                        humanRisk.adjusted_risk =
                            `<span class="text-green-500 font-semibold">${humanRisk.adjusted_risk}</span>`;
                    }
                    if (humanRisk.average_score < 60) {
                        if (humanRisk.average_score == null) {
                            humanRisk.average_score = '0 (Not started)';
                        }
                        humanRisk.average_score =
                            `<span class="text-red-500 font-semibold">${humanRisk.average_score}</span>`;
                    } else {

                        humanRisk.average_score =
                            `<span class="text-green-500 font-semibold">${humanRisk.average_score}</span>`;
                    }
                    $("#list-human-risk-tbody").append(`
                            <tr class="border-b text-xs md:text-sm">
                                <td class="p-4">${humanRisk.email}</td>
                                <td class="p-4">${humanRisk.final_score}</td>
                                <td class="p-4">${humanRisk.average_score}</td>
                                <td class="p-4">${humanRisk.adjusted_risk}</td>
                                

                            </tr>
                        `);

                });
            }
        }

        function getCampaignTable(campaigns) {
            $("#list-campaign-tbody").empty();
            if (campaigns.length == 0) {
                $("#list-campaign-tbody").append(`
                        <tr class="text-xs md:text-sm font-normal text-gray-900 dark:text-gray-400 bg-white dark:bg-gray-700">
                            <td class="p-4" colspan="4">
                                No data available
                            </td>
                        </tr>
                    `);
            } else {
                const total = campaigns.length;
                const start = Math.max(total - 5, 0);
                const end = total;
                campaigns.slice(start, end).reverse().forEach((campaign, index) => {
                    let date = new Date(campaign.created_date);
                    let formattedDate =
                        `${date.toLocaleDateString('id-ID', {
                            day: '2-digit',
                            month: 'long',
                            year: 'numeric'
                        })} ${String(date.getUTCHours()).padStart(2, '0')}:${String(date.getUTCMinutes()).padStart(2, '0')}`;
                    let target = campaign.results && campaign.results.length > 0 ? campaign
                        .results.length : 'Not Set';

                    $("#list-campaign-tbody").append(`
                            <tr class="border-b text-xs md:text-sm">
                                <td class="p-4">${campaign.name}</td>
                                <td class="p-4">${campaign.status}</td>
                               
                                <button onclick="showDetailCampaign(${campaign.id})"
                                    class="text-xs font-medium text-white  rounded-xl"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                    <path fill-rule="evenodd" d="M13.28 11.47a.75.75 0 0 1 0 1.06l-7.5 7.5a.75.75 0 0 1-1.06-1.06L11.69 12 4.72 5.03a.75.75 0 0 1 1.06-1.06l7.5 7.5Z" clip-rule="evenodd" />
                                    <path fill-rule="evenodd" d="M19.28 11.47a.75.75 0 0 1 0 1.06l-7.5 7.5a.75.75 0 1 1-1.06-1.06L17.69 12l-6.97-6.97a.75.75 0 0 1 1.06-1.06l7.5 7.5Z" clip-rule="evenodd" />
                                    </svg>
                                    </button>
                                </td>

                            </tr>
                        `);
                });

            }
        }

        function showDetailCampaign(id) {
            window.location.href = "{{ route('campaignDetailsView', '') }}/" + id;
        }

        function showCampaignPage() {
            window.location.href = "{{ route('campaignView') }}";
        }

        function calculateEmailSent(campaigns) {
            // console.log(campaigns);
            let tempTotal = 0;
            let tempSent = 0;
            let tempNotSent = 0;
            campaigns.forEach(function(campaign) {
                campaign.results.forEach(function(result) {
                    tempTotal++;
                    if (result.status != "Scheduled") {
                        tempSent++;
                    }
                    if (result.status == "Error" || campaign.status == "Queued") {
                        tempSent--;
                    }
                });
            });
            tempNotSent = tempTotal - tempSent;
            return {
                emailSent: tempSent,
                emailNotSent: tempNotSent,
                totalEmail: tempTotal
            }
        }

        function calculateEmailOpened(campaigns) {
            let tempTotal = 0;
            let tempOpened = 0;
            let tempNotOpen = 0;
            campaigns.forEach(function(campaign) {
                campaign.results.forEach(function(result) {
                    // console.log(result.status);
                    tempTotal++;
                    if (result.status != "Scheduled" && result.status != "Email Sent") {
                        tempOpened++;
                    }
                    if (result.status == "Error" || result.status == "Queued") {
                        tempOpened--;
                    }
                });
            });
            tempNotOpen = tempTotal - tempOpened;
            return {
                emailOpened: tempOpened,
                emailNotOpen: tempNotOpen,
                totalEmail: tempTotal
            }
        }

        function calculateLinkClicked(campaigns) {
            let tempTotal = 0;
            let tempClicked = 0;
            let tempNotClicked = 0;
            campaigns.forEach(function(campaign) {
                campaign.results.forEach(function(result) {
                    tempTotal++;
                    if (result.status === "Clicked Link" || result.status === "Submitted Data") {
                        tempClicked++;
                    }
                });
            });
            tempNotClicked = tempTotal - tempClicked;
            return {
                linkClicked: tempClicked,
                linkNotClicked: tempNotClicked,
                totalEmail: tempTotal
            }
        }

        function calculateSubmittedData(campaigns) {
            let tempTotal = 0;
            let tempSubmitted = 0;
            let tempNotSubmitted = 0;
            campaigns.forEach(function(campaign) {
                campaign.results.forEach(function(result) {
                    tempTotal++;
                    if (result.status === "Submitted Data") {
                        tempSubmitted++;
                    }
                });
            });
            tempNotSubmitted = tempTotal - tempSubmitted;
            return {
                linkSubmitted: tempSubmitted,
                linkNotSubmitted: tempNotSubmitted,
                totalEmail: tempTotal
            }
        }

        function calculateEmailReported(campaigns) {
            let tempTotal = campaigns.length;
            let tempReported = 0;
            let tempNotReported = 0;
            campaigns.forEach(function(campaign) {
                if (campaign.reported === true) {
                    tempReported++;
                }
            });
            tempNotReported = tempTotal - tempReported;
            return {
                emailReported: tempReported,
                emailNotReported: tempNotReported,
                totalEmail: tempTotal
            }
        }

        function getEmailSentChart(emailSent = 0, emailNotSent = 0, totalEmail = 0) {
            if (window.emailSentChart) {
                window.emailSentChart.destroy();
            }
            var options = {
                chart: {
                    type: 'donut',
                    height: 250,
                    width: 250,
                },
                series: [emailSent, emailNotSent],
                labels: ['Email Sent', 'Email Not Sent'],
                plotOptions: {
                    pie: {
                        donut: {
                            labels: {
                                show: true,
                                total: {
                                    show: true,
                                    label: 'Total',
                                    formatter: function(w) {
                                        return totalEmail;
                                    }
                                }
                            }
                        }
                    }
                },
                legend: {
                    show: true,
                    position: 'bottom',

                }

            }
            window.emailSentChart = new ApexCharts(document.querySelector("#donut-email-sent"), options);
            window.emailSentChart.render();
        }

        function getEmailOpenedChart(emailOpened = 0, emailNotOpen = 0, totalEmail = 0) {
            if (window.emailOpenedChart) {
                window.emailOpenedChart.destroy();
            }
            var options = {
                chart: {
                    type: 'donut',
                    height: 250,
                    width: 250,
                },
                series: [emailOpened, emailNotOpen],
                labels: ['Email Opened', 'Email Not Opened'],
                plotOptions: {
                    pie: {
                        donut: {
                            labels: {
                                show: true,
                                total: {
                                    show: true,
                                    label: 'Total',
                                    formatter: function(w) {
                                        return totalEmail;
                                    }
                                }
                            }
                        }
                    }
                },
                legend: {
                    show: true,
                    position: 'bottom',

                }

            }
            window.emailOpenedChart = new ApexCharts(document.querySelector("#donut-email-opened"), options);
            window.emailOpenedChart.render();
        }

        function getLinkClickedChart(linkClicked = 0, linkNotClicked = 0, totalEmail = 0) {
            if (window.linkClickedChart) {
                window.linkClickedChart.destroy();
            }
            var options = {
                chart: {
                    type: 'donut',
                    height: 250,
                    width: 250,
                },
                series: [linkClicked, linkNotClicked],
                labels: ['Link Clicked', 'Link Not Clicked'],
                plotOptions: {
                    pie: {
                        donut: {
                            labels: {
                                show: true,
                                total: {
                                    show: true,
                                    label: 'Total',
                                    formatter: function(w) {
                                        return totalEmail;
                                    }
                                }
                            }
                        }
                    }
                },
                legend: {
                    show: true,
                    position: 'bottom',

                }

            }
            window.linkClickedChart = new ApexCharts(document.querySelector("#donut-link-clicked"), options);
            window.linkClickedChart.render();
        }

        function getSubmittedData(linkSubmitted = 0, linkNotSubmitted = 0, totalEmail = 0) {
            if (window.submittedDataChart) {
                window.submittedDataChart.destroy();
            }
            var options = {
                chart: {
                    type: 'donut',
                    height: 250,
                    width: 250,
                },
                series: [linkSubmitted, linkNotSubmitted],
                labels: ['Submitted', 'Not Submitted'],
                plotOptions: {
                    pie: {
                        donut: {
                            labels: {
                                show: true,
                                total: {
                                    show: true,
                                    label: 'Total',
                                    formatter: function(w) {
                                        return totalEmail;
                                    }
                                }
                            }
                        }
                    }
                },
                legend: {
                    show: true,
                    position: 'bottom',

                }

            }
            window.submittedDataChart = new ApexCharts(document.querySelector("#donut-submitted-data"), options);
            window.submittedDataChart.render();
        }

        function getTimelineData(data) {

            let timelineData = [];
            timelineData.push({
                message: "Campaign Created",
                date: new Date(data.created_date)
            });
            timelineData.push({
                message: "Campaign Launched",
                date: new Date(data.launch_date)
            });

            let campaignTimeLine = data.timeline;
            campaignTimeLine.forEach(function(timeline) {
                if (timeline.message == "Campaign Created") {
                    return;
                }
                if (timeline.email) {
                    timelineData.push({
                        message: `${timeline.email} - ${timeline.message}`,
                        date: new Date(timeline.time)
                    });
                } else {
                    timelineData.push({
                        message: timeline.message,
                        date: new Date(timeline.time)
                    });
                }
            });
            campaignTimeLine.sort((a, b) => new Date(a.time) - new Date(b.time));
            // console.log(timelineData);
            return timelineData;
        }

        function getTimelineCampaignChart(timeline) {
            const data = timeline.map(item => ({
                x: new Date(item.date).getTime(),
                y: 1,
                message: item.message,
            }));
            const minDate = new Date(Math.min(...timeline.map(item => new Date(item.date)))).getTime();
            const maxDate = new Date(Math.max(...timeline.map(item => new Date(item.date)))).getTime();

            const options = {
                chart: {
                    height: 280,
                    type: "line",
                    toolbar: {
                        show: false,
                    },
                    zoom: {
                        enabled: true,
                    },
                    pan: {
                        enabled: false,
                    },
                },
                dataLabels: {
                    enabled: false,
                },
                series: [{
                    name: "Timeline",
                    data: data.map(item => ({
                        x: item.x,
                        y: item.y
                    })),
                }],
                stroke: {
                    curve: "straight",
                },
                markers: {
                    size: 5,
                    shape: "circle",
                    hover: {
                        size: 7,
                    },
                },
                grid: {
                    show: false,
                },
                xaxis: {
                    type: "datetime",
                    labels: {
                        format: "dd MMM yyyy HH:mm",
                        style: {
                            colors: '#9ca3af'
                        },
                        formatter: function(value) {
                            return new Date(value).toLocaleString('en-US', {
                                timeZone: 'Asia/Jakarta',
                                day: '2-digit',
                                month: 'short',
                                year: 'numeric',
                                hour: '2-digit',
                                minute: '2-digit',
                                hour12: false,
                            });
                        },
                    },
                    lines: {
                        show: false,
                        colors: 'transparent',
                    },
                    tickAmount: data.length,
                    min: minDate,
                    max: maxDate,

                },

                yaxis: {
                    show: false,
                    labels: {
                        style: {
                            colors: function({
                                w
                            }) {
                                return w.globals.theme === 'dark' ? '#ffffff' : '#000000';
                            }
                        }
                    },
                    lines: {
                        show: false,
                        colors: 'transparent',
                    },
                },
                tooltip: {
                    x: {
                        format: "dd MMM yyyy HH:mm",
                    },
                    custom: function({
                        series,
                        seriesIndex,
                        dataPointIndex,
                        w
                    }) {
                        return `<div style="padding: 5px; font-size: 12px;">
                    <strong>${new Date(w.globals.seriesX[seriesIndex][dataPointIndex]).toLocaleDateString('En-US')} ${new Date(w.globals.seriesX[seriesIndex][dataPointIndex]).toLocaleTimeString('En-US')}</strong><br>
                    ${data[dataPointIndex].message}
                </div>`;
                    },
                },
            };
            const chart = new ApexCharts(document.querySelector("#timeline-campaign"), options);
            chart.render();
        }

        function getRiskScoreByAgeGroup(ageGroupData) {
            const categories = ['18-25', '26-35', '36-45', '46-55', '55+'];
            const lowSeries = categories.map(age => ageGroupData[age].low);
            const mediumSeries = categories.map(age => ageGroupData[age].medium);
            const highSeries = categories.map(age => ageGroupData[age].high);

            if (window.ageGroupChart) {
                window.ageGroupChart.destroy();
            }

            var options = {
                chart: {
                    type: 'area',
                    height: 300,
                    stacked: false,
                },
                series: [{
                        name: 'Low Risk',
                        data: lowSeries
                    },
                    {
                        name: 'Medium Risk',
                        data: mediumSeries
                    },
                    {
                        name: 'High Risk',
                        data: highSeries
                    },
                ],
                xaxis: {
                    categories: categories,
                    labels: {
                        style: {
                            colors: (Array(categories.length).fill(
                                window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches
                                    ? '#fff'
                                    : '#000'
                            )),
                        }
                    },
                },
                
                colors: ['#4ade80', '#facc15', '#f87171'],
                dataLabels: {
                    enabled: true,
                },
                legend: {
                    show: true,
                    position: 'bottom',
                },

            };

            window.ageGroupChart = new ApexCharts(document.querySelector("#area-chart-age-group"), options);
            window.ageGroupChart.render();
        }

        function getRiskScoreData(high = 0, medium = 0, low = 0) {
            if (window.riskScoreChart) {
                window.riskScoreChart.destroy();
            }

            var options = {
                chart: {
                    type: 'bar',
                    height: 250,
                },
                series: [{
                    name: 'Risk Levels',
                    data: [high, medium, low]
                }],
                xaxis: {
                    categories: ['High Risk', 'Medium Risk', 'Low Risk'],
                    labels: {
                        style: {
                            colors: ['#f87171', '#facc15', '#4ade80'],
                            fontSize: '12px'
                        }
                    }
                },
                colors: ['#f87171', '#facc15', '#4ade80'],
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '50%',
                        endingShape: 'rounded',
                        distributed: true
                    }
                },
                dataLabels: {
                    enabled: true,
                },
                legend: {
                    show: true,
                    position: 'bottom',
                },
                tooltip: {
                    custom: function({
                        series,
                        seriesIndex,
                        dataPointIndex,
                        w
                    }) {
                        const categories = w.globals.labels;
                        const category = categories[dataPointIndex];
                        const value = series[seriesIndex][dataPointIndex];

                        return `
                            <div style="padding:8px;">
                            <strong>Risk Levels</strong><br/>
                            <span>${category} : ${value}</span>
                            </div>
                        `;
                    }
                }
            };
            window.riskScoreChart = new ApexCharts(document.querySelector("#column-risk-score"), options);
            window.riskScoreChart.render();
        }

        async function showAllEmployeeRisks(humanRisks) {
            $("#all-human-risk-body").empty();

            if (humanRisks.length == 0) {
                $("#all-human-risk-body").append(`
                        <tr class="text-xs md:text-sm font-normal text-gray-900 dark:text-gray-400 bg-white dark:bg-gray-700">
                            <td class="p-4" colspan="4">
                                No data available
                            </td>
                        </tr>
                    `);
            } else {
                await humanRisks.forEach((humanRisk, index) => {
                    let date = new Date(humanRisk.created_date);
                    let formattedDate =
                        `${date.toLocaleDateString('id-ID', {
                            day: '2-digit',
                            month: 'long',
                            year: 'numeric'
                        })} ${String(date.getUTCHours()).padStart(2, '0')}:${String(date.getUTCMinutes()).padStart(2, '0')}`;
                    if (humanRisk.adjusted_risk >= 70) {
                        humanRisk.adjusted_risk =
                            `<span class="text-red-500 font-semibold">${humanRisk.adjusted_risk}</span>`;
                    } else if (humanRisk.adjusted_risk >= 40) {
                        humanRisk.adjusted_risk =
                            `<span class="text-yellow-500 font-semibold">${humanRisk.adjusted_risk}</span>`;
                    } else {
                        humanRisk.adjusted_risk =
                            `<span class="text-green-500 font-semibold">${humanRisk.adjusted_risk}</span>`;
                    }
                    if (humanRisk.average_score < 60) {
                        if (humanRisk.average_score == null) {
                            humanRisk.average_score = '0 (Not started)';
                        }
                        humanRisk.average_score =
                            `<span class="text-red-500 font-semibold">${humanRisk.average_score}</span>`;
                    } else {

                        humanRisk.average_score =
                            `<span class="text-green-500 font-semibold">${humanRisk.average_score}</span>`;
                    }
                    $("#all-human-risk-body").append(`
                            <tr class="border-b text-xs md:text-sm">
                                <td class="p-4">${humanRisk.email}</td>
                                <td class="p-4">${humanRisk.final_score}</td>
                                <td class="p-4">${humanRisk.average_score}</td>
                                <td class="p-4">${humanRisk.adjusted_risk}</td>
                                

                            </tr>
                        `);
                });
            }
            await showModal('show-all-employee-modal');




        }
    </script>




@endsection

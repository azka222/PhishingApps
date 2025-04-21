@extends('layouts.master')
@section('title', 'Fischsim - Dashboard')
@section('content')
<div class=" p-4 w-full flex flex-col h-full min-h-screen  bg-gray-50 dark:bg-gray-800 dark:text-white text-gray-900">
    <div class="judul-1">
        <div class="flex p-4 items-center justify-between">
            <h1 class="text-3xl font-semibold">Dashboard</h1>
        </div>
    </div>

    <div class="flex flex-col gap-4">
        <div class="bg-white dark:bg-gray-900 shadow-md rounded-lg p-4">
            <h2 class="text-xl font-semibold">Welcome to Fischsim</h2>
            <p class="text-gray-600 dark:text-gray-400">This is your dashboard where you can manage your phishing simulations.</p>
        </div>

        <div class="bg-white dark:bg-gray-900 shadow-md rounded-lg p-4">
            <h2 class="text-xl font-semibold">Recent Activity</h2>
            <ul class="list-disc pl-5">
                <li>New phishing simulation created.</li>
                <li>User registered for a new simulation.</li>
                <li>Simulation report generated.</li>
            </ul>
        </div>

        @IsAdmin()
        <div class="max-w-full md:max-w-xs">
            <div>
                <label for="companyCheckAdmin"
                    class="mb-1 mt-4 block text-xs md:text-sm font-medium text-gray-700 dark:text-gray-300">Company</label>
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

        <div class="p-4">
            <div class="bg-white dark:bg-gray-700 dark:text-white rounded-lg p-4 flex flex-col items-center w-full">
                <p class="text-xs md:text-sm font-semibold mb-4">Campaign Timeline</p>
                <div id="timeline-campaign" class="w-full"></div>
            </div>
        </div>

        <div class="p-4">
            <div class="bg-white dark:bg-gray-700 dark:text-white rounded-lg p-4">
                <div class="grid grid-cols-4 gap-4">
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

        <div class="judul-2">
            <div class="flex p-4 items-center justify-between">
                <h1 class="text-3xl font-semibold">Recent Campaigns</h1>
            </div>
        </div>

        <div class="flex p-4 justify-start md:justify-end items-start md:items-center">
            <div class="flex">
                <input type="text" id="search" name="search" onchange="getDashboardValue()"
                    class="bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 w-64 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Search by name only..">
            </div>
        </div>
        <div class="p-4 min-w-32 overflow-x-auto md:min-w-full">
            <table class="min-w-32 md:min-w-full divide-y divide-gray-200 dark:divide-gray-700 mt-4">
            <thead class="bg-gray-300 dark:bg-gray-700">
            <tr class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
            <th scope="col" class="p-4">Name</th>
            <th scope="col" class="p-4">Created Date</th>
            <th scope="col" class="p-4">Total Target</th>
            <th scope="col" class="p-4">Status</th>
            <th scope="col" class="p-4 ">
                <button onclick="showCampaignPage()"
                class="px-4 py-2 text-xs md:text-sm font-medium text-white bg-blue-600 rounded-xl hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600">
                View All
                </button>
            </th>
            </tr>
            </thead>
            <tbody id="list-campaign-tbody"
            class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
            </tbody>
            </table>
        </div>
        <nav class="flex items-center flex-column flex-col md:flex-row justify-between p-4"
            aria-label="Table navigation">
            {{-- <span
                class="mb-4 md:mb-0 text-xs md:text-sm font-normal text-gray-500 dark:text-gray-400 block w-full md:inline md:w-auto">Showing
                <span class="font-semibold text-gray-900 dark:text-white"> <span id="numberFirstItem">0</span> -
                    <span id="numberLastItem">0</span></span> of
                <span id="totalTemplatesCount" class="font-semibold text-gray-900 dark:text-white">0</span>
            </span>
            <ul id="page-button-dashboard"
                class="inline-flex space-x-2 rtl:space-x-reverse text-xs md:text-sm h-8">
            </ul> --}}
        </nav>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    $(document).ready(function() {
        getDashboardValue();
    });

    function getDashboardValue(page = 1) {
        let companyId = $('#companyCheckAdmin').val();
        let search = $('#search').val();
        let status = 2;
        let show = 100;
        $.ajax({
            url: "{{ route('getCampaigns') }}?page=" + page,
                type: "GET",
                data: {
                    show: show,
                    search: search,
                    status: status,
                    page: page,
                    companyId: companyId
            },
            success: function(response) {
                campaigns = [];
                campaigns = response.data;
                $("#list-campaign-tbody").empty();
                if (campaigns.length == 0) {
                    $("#list-campaign-tbody").append(`
                        <tr class="text-xs md:text-sm font-normal text-gray-900 dark:text-gray-400 bg-white dark:bg-gray-800">
                            <td class="p-4" colspan="4">
                                No data available
                            </td>
                        </tr>
                    `);
                } else {
                    $("#list-campaign-tbody").empty();
                    // console.log(campaigns.length);
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
                        let target = campaign.results && campaign.results.length > 0 ? campaign.results.length : 'Not Set';

                        $("#list-campaign-tbody").append(`
                            <tr class="text-xs md:text-sm font-normal text-gray-900 dark:text-gray-400 bg-white dark:bg-gray-800">
                                <td class="p-4">${campaign.name}</td>
                                <td class="p-4">${formattedDate}</td>
                                <td class="p-4">${target}</td>
                                <td class="p-4">${campaign.status}</td>
                                <td class="p-4 flex gap-2">
                                <button onclick="showDetailCampaign(${campaign.id})"
                                    class="px-4 py-2 text-xs md:text-sm font-medium text-white bg-green-600 rounded-xl hover:bg-green-700 dark:bg-green-500 dark:hover:bg-green-600">Detail</button>
                                @CanDeleteCampaign()
                                    <button onclick="deleteCampaign(${campaign.id})"
                                    class="px-4 py-2 text-xs md:text-sm font-medium text-white bg-red-600 rounded-xl hover:bg-red-700 dark:bg-red-500 dark:hover:bg-red-600">Delete</button>
                                @endCanDeleteCampaign()
                                </td>

                            </tr>
                        `);
                    });

                    let dataEmailSent = calculateEmailSent(campaigns);
                    getEmailSentChart(dataEmailSent.emailSent, dataEmailSent.emailNotSent, dataEmailSent.totalEmail);

                    let dataEmailOpened = calculateEmailOpened(campaigns);
                    getEmailOpenedChart(dataEmailOpened.emailOpened, dataEmailOpened.emailNotOpen, dataEmailOpened.totalEmail);

                    let dataLinkClicked = calculateLinkClicked(campaigns);
                    getLinkClickedChart(dataLinkClicked.linkClicked, dataLinkClicked.linkNotClicked, dataLinkClicked.totalEmail);

                    let dataSubmittedData = calculateSubmittedData(campaigns);
                    getSubmittedData(dataSubmittedData.linkSubmitted, dataSubmittedData.linkNotSubmitted,dataSubmittedData.totalEmail);

                    let combinedTimeline = [];
                    campaigns.forEach(campaign => {
                        let dataTimeline = getTimelineData(campaign);
                        combinedTimeline = combinedTimeline.concat(dataTimeline);
                    });
                    combinedTimeline.sort((a, b) => new Date(a.date) - new Date(b.date));
                    getTimelineCampaignChart(combinedTimeline);

                }
                // $("#numberFirstItem").text(
                //     response.campaignTotal != 0 ? (page - 1) * show + 1 : 0
                // );
                // $("#numberLastItem").text(
                //     (page - 1) * show + response.data.length
                // );
                // $("#totalTemplatesCount").text(response.campaignTotal);
                // paginationDashboard("#page-button-dashboard", response.pageCount, response.currentPage);
            }
        });
    }

    function deleteCampaign(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#d97706',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('deleteCampaign') }}",
                        type: "POST",
                        data: {
                            id: id,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            Swal.fire({
                                title: 'Success',
                                text: 'Campaign deleted successfully.',
                                icon: 'success',
                                confirmButtonColor: '#10b981',
                                confirmButtonText: 'OK'
                            });
                            getCampaigns();
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                icon: "error",
                                title: "Error",
                                text: xhr.responseJSON.message,
                                confirmButtonColor: '#10b981',
                                confirmButtonText: 'Close'
                            });
                        }
                    })
                }
            })
        }

        function showDetailCampaign(id) {
            window.location.href = "{{ route('campaignDetailsView', '') }}/" + id;
        }

        function showCampaignPage(){
            window.location.href = "{{ route('campaignView') }}";
        }


        function calculateEmailSent(campaigns) {
            let tempTotal = 0;
            let tempSent = 0;
            let tempNotSent = 0;
            campaigns.forEach(function(campaign) {
                campaign.results.forEach(function(result) {
                    tempTotal++;
                    if (result.status != "Scheduled") {
                        tempSent++;
                    }
                    if(result.status == "Error" || campaign.status == "Queued"){
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
                    tempTotal++;
                    if (campaign.status != "Scheduled" && campaign.status != "Email Sent") {
                        tempOpened++;
                    }
                    if(campaign.results[0].status == "Error" || campaign.status == "Queued"){
                        tempOpened = 0;
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
                    if (campaign.status === "Clicked Link" || campaign.status === "Submitted Data") {
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
                    if (campaign.status === "Submitted Data") {
                        tempClicked++;
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
            var chart = new ApexCharts(document.querySelector("#donut-email-sent"), options);
            chart.render();
        }

        function getEmailOpenedChart(emailOpened = 0, emailNotOpen = 0, totalEmail = 0) {
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
            var chart = new ApexCharts(document.querySelector("#donut-email-opened"), options);
            chart.render();
        }

        function getLinkClickedChart(linkClicked = 0, linkNotClicked = 0, totalEmail = 0) {
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
            var chart = new ApexCharts(document.querySelector("#donut-link-clicked"), options);
            chart.render();
        }

        function getSubmittedData(linkSubmitted = 0, linkNotSubmitted = 0, totalEmail = 0) {
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
            var chart = new ApexCharts(document.querySelector("#donut-submitted-data"), options);
            chart.render();
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


</script>




@endsection

@extends('layouts.master')
@section('title', 'Fischsim - Campaign Details')
@section('content')
    <div class=" p-4 w-full flex flex-col h-full min-h-screen  bg-gray-50 dark:bg-gray-800 dark:text-white text-gray-900">
        <div class="">
            <div class="flex p-4 items-center justify-between">
                <h1 class="text-3xl font-semibold">Campaign Details</h1>
            </div>

            <div class="p-4">
                <div class="bg-white dark:bg-gray-700 dark:text-white rounded-lg p-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="col-span-4 md:col-span-1">
                            <p class="text-xs md:text-sm font-semibold">Campaign Name</p>
                            <p class="text-xs md:text-sm font-light" id="campaign-name">Not Set</p>
                        </div>
                        <div class="col-span-4 md:col-span-1">
                            <p class="text-xs md:text-sm font-semibold">Email Profile</p>
                            <p class="text-xs md:text-sm font-light" id="email-profile-name">Not Set</p>
                        </div>
                        <div class="col-span-4 md:col-span-1">
                            <p class="text-xs md:text-sm font-semibold">Campaign Launch Date</p>
                            <p class="text-xs md:text-sm font-light" id="campaign-launch-date">Not Set</p>
                        </div>
                        <div class="col-span-4 md:col-span-1">
                            <p class="text-xs md:text-sm font-semibold">Email Template</p>
                            <p class="text-xs md:text-sm font-light" id="email-template-name">Not Set</p>
                        </div>
                        <div class="col-span-4 md:col-span-1">
                            <p class="text-xs md:text-sm font-semibold">Total Target</p>
                            <p class="text-xs md:text-sm font-light" id="campaign-total-target">Not Set</p>
                        </div>
                        <div class="col-span-4 md:col-span-1">
                            <p class="text-xs md:text-sm font-semibold">Status</p>
                            <p class="text-xs md:text-sm font-light" id="campaign-status">Not Set</p>
                        </div>

                    </div>
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
                            <p class="text-xs md:text-sm font-semibold mb-4">Emails Reported</p>
                            <div id="donut-email-reported"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-4">
                <div class="bg-white dark:bg-gray-700 dark:text-white rounded-lg p-4 flex flex-col items-center w-full">
                    <p class="text-xs md:text-sm font-semibold mb-4">Campaign Timeline</p>
                    <div id="timeline-campaign" class="w-full"></div>
                </div>
            </div>

            <div class="flex p-4 justify-start md:justify-end items-start md:items-center mt-8">
                <div class="flex">
                    <input type="text" id="search" name="search" onchange="getCampaignDetails()"
                        class="bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 w-64 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Search by email only..">
                </div>
            </div>
            <div class="p-4 min-w-32 overflow-x-auto md:min-w-full">
                <table class="min-w-32 md:min-w-full divide-y divide-gray-200 dark:divide-gray-700 mt-4">
                    <thead class="bg-gray-300 dark:bg-gray-700">
                        <tr
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                            <th scope="col" class="p-4">First Name</th>
                            <th scope="col" class="p-4">Last Name</th>
                            <th scope="col" class="p-4">Position</th>
                            <th scope="col" class="p-4">Email</th>
                            <th scope="col" class="p-4">IP Address</th>
                            <th scope="col" class="p-4">Status</th>
                        </tr>
                    </thead>
                    <tbody id="list-campaign-tbody"
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
                    <span id="totalTemplatesCount" class="font-semibold text-gray-900 dark:text-white">0</span>
                </span>
                <ul id="page-button-campaign-details"
                    class="inline-flex space-x-2 rtl:space-x-reverse text-xs md:text-sm h-8">

                </ul>
            </nav>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        let emailsSent = 0;
        let clickedLink = 0;
        let totalTarget = 0;
        let id = {{ $id }};
        $(document).ready(function() {
            getCampaignDetails();
        });

        function getCampaignDetails(page = 1) {
            $.ajax({
                url: "{{ route('getCampaignData') }}?page=" + page,
                type: "GET",
                data: {
                    id: id,
                    search: $("#search").val()
                },
                success: function(response) {
                    console.log(response);
                    let date = new Date(response.launch_date);
                    let formattedDate =
                        `${date.toLocaleDateString('id-ID', {
                        day: '2-digit',
                        month: 'long',
                        year: 'numeric'
                    })} ${String(date.getUTCHours()).padStart(2, '0')}:${String(date.getUTCMinutes()).padStart(2, '0')}`;
                    $("#donut-email-sent").empty();
                    $("#donut-email-opened").empty();
                    $("#donut-link-clicked").empty();
                    $("#donut-email-reported").empty();
                    $('#campaign-name').text(response.name);
                    $('#email-profile-name').text(response.smtp.name);
                    $('#campaign-launch-date').text(formattedDate);
                    $('#email-template-name').text(response.template.name);
                    $('#campaign-total-target').text(response.results ? response.results.length : 'Not Set');
                    $('#campaign-status').text(response.status);

                    let dataEmailSent = calculateEmailSent(response.results);
                    getEmailSentChart(dataEmailSent.emailSent, dataEmailSent.emailNotSent, dataEmailSent
                        .totalEmail);

                    let dataEmailOpened = calculateEmailOpened(response.results);
                    getEmailOpenedChart(dataEmailOpened.emailOpened, dataEmailOpened.emailNotOpen,
                        dataEmailOpened.totalEmail);

                    let dataLinkClicked = calculateLinkClicked(response.results);
                    getLinkClickedChart(dataLinkClicked.linkClicked, dataLinkClicked.linkNotClicked,
                        dataLinkClicked.totalEmail);

                    let dataEmailReported = calculateEmailReported(response.results);
                    getEmailReportedChart(dataEmailReported.emailReported, dataEmailReported.emailNotReported,
                        dataEmailReported.totalEmail);

                    $('#list-campaign-tbody').empty();
                    let targetUsers = response.paginated_results;

                    Object.values(targetUsers).forEach(function(result) {
                        let status = result.status;
                        let reported = result.reported;
                        let statusColor = '';
                        if (status === 'Scheduled') {
                            statusColor = 'bg-yellow-200 dark:bg-yellow-500';
                        } else if (status === 'Email Sent') {
                            statusColor = 'bg-blue-200 dark:bg-blue-500';
                        } else if (status === 'Email Opened') {
                            statusColor = 'bg-green-200 dark:bg-green-500';
                        } else if (status === 'Clicked Link') {
                            statusColor = 'bg-purple-200 dark:bg-purple-500';
                        } else if (status === 'Reported') {
                            statusColor = 'bg-red-200 dark:bg-red-500';
                        }
                        let reportedColor = reported ? 'bg-red-200 dark:bg-red-500' : '';
                        let reportedText = reported ? 'Reported' : 'Not Reported';
                        let html = `<tr class="text-xs md:text-sm font-light text-gray-600 dark:text-gray-400 bg-white dark:bg-gray-800">
                            <td class="p-4">
                                ${result.first_name}
                            </td>
                            <td class="p-4">
                                ${result.last_name}
                            </td>
                            <td class="p-4">
                                ${result.position}
                            </td>
                            <td class="p-4">
                                ${result.email}
                            </td>
                            <td class="p-4">
                                ${result.ip ? result.ip : '-'}
                            </td>
                            <td class="p-4 min-w-32">
                                <span class="px-2 inline-flex text-xs dark:text-white leading-5 font-semibold rounded-full ${statusColor}">
                                    ${status}
                                </span>
                                <span class="px-2 inline-flex text-xs leading-5 dark:text-white font-semibold rounded-full ${reportedColor}">
                                    ${reportedText}
                                </span>
                            </td>
                        </tr>`;
                        $('#list-campaign-tbody').append(html);
                    });
                    paginationCampaignDetails('#page-button-campaign-details', response.pagination.total_pages,
                        response
                        .pagination.current_page);

                    $("#numberFirstItem").text(
                        (page - 1) * 5 + 1
                    );
                    $("#numberLastItem").text(
                        (page - 1) * 5 + Object.values(targetUsers).length
                    );
                    $("#totalTemplatesCount").text(Object.values(targetUsers).length);
                    let timelineData = getTimelineData(response);
                    getTimelineCampaignChart(timelineData)
                }

            })
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
            console.log(timelineData);
            return timelineData;
        }

        function calculateEmailSent(results) {
            let tempTotal = results.length;
            let tempSent = 0;
            let tempNotSent = 0;
            results.forEach(function(result) {
                if (result.status != "Scheduled") {
                    tempSent++;
                }
                if(result.status == "Error" || campaign.status == "Queued"){
                    tempSent = 0;
                }
            });
            tempNotSent = tempTotal - tempSent;
            return {
                emailSent: tempSent,
                emailNotSent: tempNotSent,
                totalEmail: tempTotal
            }
        }

        function calculateEmailOpened(results) {
            let tempTotal = results.length;
            let tempOpened = 0;
            let tempNotOpen = 0;
            results.forEach(function(result) {
                if (result.status != "Scheduled" && result.status != "Email Sent") {
                    tempOpened++;
                }
                if(result.status == "Error" || campaign.status == "Queued"){
                    tempOpened = 0;
                }
            });
            tempNotOpen = tempTotal - tempOpened;
            return {
                emailOpened: tempOpened,
                emailNotOpen: tempNotOpen,
                totalEmail: tempTotal
            }
        }

        function calculateLinkClicked(results) {
            let tempTotal = results.length;
            let tempClicked = 0;
            let tempNotClicked = 0;
            results.forEach(function(result) {
                if (result.status === "Clicked Link") {
                    tempClicked++;
                }
            });
            tempNotClicked = tempTotal - tempClicked;
            return {
                linkClicked: tempClicked,
                linkNotClicked: tempNotClicked,
                totalEmail: tempTotal
            }
        }

        function calculateEmailReported(results) {
            let tempTotal = results.length;
            let tempReported = 0;
            let tempNotReported = 0;
            results.forEach(function(result) {
                if (result.reported === true) {
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
    </script>

    <script>
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

        function getEmailReportedChart(emailReported = 0, emailNotReported = 0, totalEmail = 0) {
            var options = {
                chart: {
                    type: 'donut',
                    height: 250,
                    width: 250,
                },
                series: [emailReported, emailNotReported],
                labels: ['Reported', 'Not Reported'],
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
                                    },

                                },
                                style: {
                                    fontSize: '6px',
                                    fontWeight: 'bold',
                                    color: '#333'
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
            var chart = new ApexCharts(document.querySelector("#donut-email-reported"), options);
            chart.render();
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






@endSection

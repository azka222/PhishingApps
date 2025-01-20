function showModal(id) {
    const options = {
        placement: "bottom-right",
        backdrop: "dynamic",
        closable: true,
    };
    const instanceOptions = {
        id: "modalEl",
        override: true,
    };
    let modal = new Modal(
        document.getElementById(id),
        options,
        instanceOptions
    );
    modal.show();
}

function showStaticModal(id) {
    const options = {
        placement: "bottom-right",
        backdrop: "static",
        closable: false,
    };
    const instanceOptions = {
        id: "modalEl",
        override: true,
    };
    let modal = new Modal(
        document.getElementById(id),
        options,
        instanceOptions
    );
    modal.show();
}

function hideModal(id) {
    const options = {
        placement: "bottom-right",
        backdrop: "dynamic",
        closable: true,
    };
    const instanceOptions = {
        id: "modalEl",
        override: true,
    };
    let modal = new Modal(
        document.getElementById(id),
        options,
        instanceOptions
    );
    modal.hide();
    $(".alert-danger").hide();
}

function paginationTargetCompany(selector, numberOfPage, currentPage) {
    $(selector).empty();
    let currentPageButton = `<li>
        <button aria-current="page"
        onclick="getTargets({{page}})"
            class="flex items-center justify-center mx-1 cursor-pointer rounded-lg px-3 h-8 text-blue-600 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white">{{page}}</button>

        </li>`;
    // Other Page
    let otherPage = `<li>
        <a onclick="getTargets({{page}})"
            class="flex items-center justify-center me-1 px-3 h-8 leading-tight text-gray-500 bg-white hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 cursor-pointer rounded-lg dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">{{page}}</a>
        </li>`;
    let button = `<li>
        <button type="button" onclick="getTargets({{page}})"
            class="flex items-center justify-center cursor-pointer px-3 h-8 leading-tight text-gray-500 bg-white rounded-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">{{button-text}}</button>
        </li>`;
    let dots = `<li class="page-item disabled" aria-disabled="true"><span class="page-link">...</span></li>`;
    let previousButton = button.replace("{{button-text}}", "<");
    if (currentPage != 1) {
        previousButton = previousButton.replace("{{page}}", currentPage - 1);
    }
    let buildedPage = previousButton;
    const TOTAL_SIDE_BUTTON = 1;

    let startingMiddlePage = currentPage - TOTAL_SIDE_BUTTON;
    if (startingMiddlePage < 1 || startingMiddlePage == 2) {
        startingMiddlePage = 1;
    }

    let endMiddlePage = currentPage + TOTAL_SIDE_BUTTON;
    if (endMiddlePage > numberOfPage || endMiddlePage == numberOfPage - 1) {
        endMiddlePage = numberOfPage;
    }

    for (let i = startingMiddlePage; i <= endMiddlePage; i++) {
        if (i === currentPage) {
            buildedPage += currentPageButton.replaceAll("{{page}}", i);
        } else {
            buildedPage += otherPage.replaceAll("{{page}}", i);
        }
    }

    let nextButton = button.replaceAll("{{button-text}}", ">");
    if (currentPage != numberOfPage) {
        nextButton = nextButton.replace("{{page}}", currentPage + 1);
    }
    buildedPage += nextButton;
    $(selector).append(buildedPage);
}

function paginationGroupCompany(selector, numberOfPage, currentPage) {
    $(selector).empty();
    let currentPageButton = `<li>
        <button aria-current="page"
        onclick="getGroups({{page}})"
            class="flex items-center justify-center mx-1 cursor-pointer rounded-lg px-3 h-8 text-blue-600 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white">{{page}}</button>

        </li>`;
    // Other Page
    let otherPage = `<li>
        <a onclick="getGroups({{page}})"
            class="flex items-center justify-center me-1 px-3 h-8 leading-tight text-gray-500 bg-white hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 cursor-pointer rounded-lg dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">{{page}}</a>
        </li>`;
    let button = `<li>
        <button type="button" onclick="getGroups({{page}})"
            class="flex items-center justify-center cursor-pointer px-3 h-8 leading-tight text-gray-500 bg-white rounded-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">{{button-text}}</button>
        </li>`;
    let dots = `<li class="page-item disabled" aria-disabled="true"><span class="page-link">...</span></li>`;
    let previousButton = button.replace("{{button-text}}", "<");
    if (currentPage != 1) {
        previousButton = previousButton.replace("{{page}}", currentPage - 1);
    }
    let buildedPage = previousButton;
    const TOTAL_SIDE_BUTTON = 1;

    let startingMiddlePage = currentPage - TOTAL_SIDE_BUTTON;
    if (startingMiddlePage < 1 || startingMiddlePage == 2) {
        startingMiddlePage = 1;
    }

    let endMiddlePage = currentPage + TOTAL_SIDE_BUTTON;
    if (endMiddlePage > numberOfPage || endMiddlePage == numberOfPage - 1) {
        endMiddlePage = numberOfPage;
    }

    for (let i = startingMiddlePage; i <= endMiddlePage; i++) {
        if (i === currentPage) {
            buildedPage += currentPageButton.replaceAll("{{page}}", i);
        } else {
            buildedPage += otherPage.replaceAll("{{page}}", i);
        }
    }

    let nextButton = button.replaceAll("{{button-text}}", ">");
    if (currentPage != numberOfPage) {
        nextButton = nextButton.replace("{{page}}", currentPage + 1);
    }
    buildedPage += nextButton;
    $(selector).append(buildedPage);
}

function paginationLandingPage(selector, numberOfPage, currentPage) {
    $(selector).empty();
    let currentPageButton = `<li>
        <button aria-current="page"
        onclick="getLandingPage({{page}})"
            class="flex items-center justify-center mx-1 cursor-pointer rounded-lg px-3 h-8 text-blue-600 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white">{{page}}</button>

        </li>`;
    // Other Page
    let otherPage = `<li>
        <a onclick="getLandingPage({{page}})"
            class="flex items-center justify-center me-1 px-3 h-8 leading-tight text-gray-500 bg-white hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 cursor-pointer rounded-lg dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">{{page}}</a>
        </li>`;
    let button = `<li>
        <button type="button" onclick="getLandingPage({{page}})"
            class="flex items-center justify-center cursor-pointer px-3 h-8 leading-tight text-gray-500 bg-white rounded-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">{{button-text}}</button>
        </li>`;
    let dots = `<li class="page-item disabled" aria-disabled="true"><span class="page-link">...</span></li>`;
    let previousButton = button.replace("{{button-text}}", "<");
    if (currentPage != 1) {
        previousButton = previousButton.replace("{{page}}", currentPage - 1);
    }
    let buildedPage = previousButton;
    const TOTAL_SIDE_BUTTON = 1;

    let startingMiddlePage = currentPage - TOTAL_SIDE_BUTTON;
    if (startingMiddlePage < 1 || startingMiddlePage == 2) {
        startingMiddlePage = 1;
    }

    let endMiddlePage = currentPage + TOTAL_SIDE_BUTTON;
    if (endMiddlePage > numberOfPage || endMiddlePage == numberOfPage - 1) {
        endMiddlePage = numberOfPage;
    }

    for (let i = startingMiddlePage; i <= endMiddlePage; i++) {
        if (i === currentPage) {
            buildedPage += currentPageButton.replaceAll("{{page}}", i);
        } else {
            buildedPage += otherPage.replaceAll("{{page}}", i);
        }
    }

    let nextButton = button.replaceAll("{{button-text}}", ">");
    if (currentPage != numberOfPage) {
        nextButton = nextButton.replace("{{page}}", currentPage + 1);
    }
    buildedPage += nextButton;
    $(selector).append(buildedPage);
}

function paginationTemplateCompany(selector, numberOfPage, currentPage) {
    $(selector).empty();
    let currentPageButton = `<li>
        <button aria-current="page"
        onclick="getEmailTemplates({{page}})"
            class="flex items-center justify-center mx-1 cursor-pointer rounded-lg px-3 h-8 text-blue-600 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white">{{page}}</button>

        </li>`;
    // Other Page
    let otherPage = `<li>
        <a onclick="getEmailTemplates({{page}})"
            class="flex items-center justify-center me-1 px-3 h-8 leading-tight text-gray-500 bg-white hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 cursor-pointer rounded-lg dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">{{page}}</a>
        </li>`;
    let button = `<li>
        <button type="button" onclick="getEmailTemplates({{page}})"
            class="flex items-center justify-center cursor-pointer px-3 h-8 leading-tight text-gray-500 bg-white rounded-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">{{button-text}}</button>
        </li>`;
    let dots = `<li class="page-item disabled" aria-disabled="true"><span class="page-link">...</span></li>`;
    let previousButton = button.replace("{{button-text}}", "<");
    if (currentPage != 1) {
        previousButton = previousButton.replace("{{page}}", currentPage - 1);
    }
    let buildedPage = previousButton;
    const TOTAL_SIDE_BUTTON = 1;

    let startingMiddlePage = currentPage - TOTAL_SIDE_BUTTON;
    if (startingMiddlePage < 1 || startingMiddlePage == 2) {
        startingMiddlePage = 1;
    }

    let endMiddlePage = currentPage + TOTAL_SIDE_BUTTON;
    if (endMiddlePage > numberOfPage || endMiddlePage == numberOfPage - 1) {
        endMiddlePage = numberOfPage;
    }

    for (let i = startingMiddlePage; i <= endMiddlePage; i++) {
        if (i === currentPage) {
            buildedPage += currentPageButton.replaceAll("{{page}}", i);
        } else {
            buildedPage += otherPage.replaceAll("{{page}}", i);
        }
    }

    let nextButton = button.replaceAll("{{button-text}}", ">");
    if (currentPage != numberOfPage) {
        nextButton = nextButton.replace("{{page}}", currentPage + 1);
    }
    buildedPage += nextButton;
    $(selector).append(buildedPage);
}

function paginationSendingProfile(selector, numberOfPage, currentPage) {
    $(selector).empty();
    let currentPageButton = `<li>
        <button aria-current="page"
        onclick="getSendingProfile({{page}})"
            class="flex items-center justify-center mx-1 cursor-pointer rounded-lg px-3 h-8 text-blue-600 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white">{{page}}</button>

        </li>`;
    // Other Page
    let otherPage = `<li>
        <a onclick="getSendingProfile({{page}})"
            class="flex items-center justify-center me-1 px-3 h-8 leading-tight text-gray-500 bg-white hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 cursor-pointer rounded-lg dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">{{page}}</a>
        </li>`;
    let button = `<li>
        <button type="button" onclick="getSendingProfile({{page}})"
            class="flex items-center justify-center cursor-pointer px-3 h-8 leading-tight text-gray-500 bg-white rounded-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">{{button-text}}</button>
        </li>`;
    let dots = `<li class="page-item disabled" aria-disabled="true"><span class="page-link">...</span></li>`;
    let previousButton = button.replace("{{button-text}}", "<");
    if (currentPage != 1) {
        previousButton = previousButton.replace("{{page}}", currentPage - 1);
    }
    let buildedPage = previousButton;
    const TOTAL_SIDE_BUTTON = 1;

    let startingMiddlePage = currentPage - TOTAL_SIDE_BUTTON;
    if (startingMiddlePage < 1 || startingMiddlePage == 2) {
        startingMiddlePage = 1;
    }

    let endMiddlePage = currentPage + TOTAL_SIDE_BUTTON;
    if (endMiddlePage > numberOfPage || endMiddlePage == numberOfPage - 1) {
        endMiddlePage = numberOfPage;
    }

    for (let i = startingMiddlePage; i <= endMiddlePage; i++) {
        if (i === currentPage) {
            buildedPage += currentPageButton.replaceAll("{{page}}", i);
        } else {
            buildedPage += otherPage.replaceAll("{{page}}", i);
        }
    }

    let nextButton = button.replaceAll("{{button-text}}", ">");
    if (currentPage != numberOfPage) {
        nextButton = nextButton.replace("{{page}}", currentPage + 1);
    }
    buildedPage += nextButton;
    $(selector).append(buildedPage);
}

function paginationCampaign(selector, numberOfPage, currentPage) {
    $(selector).empty();
    let currentPageButton = `<li>
        <button aria-current="page"
        onclick="getCampaigns({{page}})"
            class="flex items-center justify-center mx-1 cursor-pointer rounded-lg px-3 h-8 text-blue-600 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white">{{page}}</button>

        </li>`;
    // Other Page
    let otherPage = `<li>
        <a onclick="getCampaigns({{page}})"
            class="flex items-center justify-center me-1 px-3 h-8 leading-tight text-gray-500 bg-white hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 cursor-pointer rounded-lg dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">{{page}}</a>
        </li>`;
    let button = `<li>
        <button type="button" onclick="getCampaigns({{page}})"
            class="flex items-center justify-center cursor-pointer px-3 h-8 leading-tight text-gray-500 bg-white rounded-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">{{button-text}}</button>
        </li>`;
    let dots = `<li class="page-item disabled" aria-disabled="true"><span class="page-link">...</span></li>`;
    let previousButton = button.replace("{{button-text}}", "<");
    if (currentPage != 1) {
        previousButton = previousButton.replace("{{page}}", currentPage - 1);
    }
    let buildedPage = previousButton;
    const TOTAL_SIDE_BUTTON = 1;

    let startingMiddlePage = currentPage - TOTAL_SIDE_BUTTON;
    if (startingMiddlePage < 1 || startingMiddlePage == 2) {
        startingMiddlePage = 1;
    }

    let endMiddlePage = currentPage + TOTAL_SIDE_BUTTON;
    if (endMiddlePage > numberOfPage || endMiddlePage == numberOfPage - 1) {
        endMiddlePage = numberOfPage;
    }

    for (let i = startingMiddlePage; i <= endMiddlePage; i++) {
        if (i === currentPage) {
            buildedPage += currentPageButton.replaceAll("{{page}}", i);
        } else {
            buildedPage += otherPage.replaceAll("{{page}}", i);
        }
    }

    let nextButton = button.replaceAll("{{button-text}}", ">");
    if (currentPage != numberOfPage) {
        nextButton = nextButton.replace("{{page}}", currentPage + 1);
    }
    buildedPage += nextButton;
    $(selector).append(buildedPage);
}

function paginationCampaignDetails(selector, numberOfPage, currentPage) {
    $(selector).empty();
    let currentPageButton = `<li>
        <button aria-current="page"
        onclick="getCampaignDetails({{page}})"
            class="flex items-center justify-center mx-1 cursor-pointer rounded-lg px-3 h-8 text-blue-600 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white">{{page}}</button>

        </li>`;
    // Other Page
    let otherPage = `<li>
        <a onclick="getCampaignDetails({{page}})"
            class="flex items-center justify-center me-1 px-3 h-8 leading-tight text-gray-500 bg-white hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 cursor-pointer rounded-lg dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">{{page}}</a>
        </li>`;
    let button = `<li>
        <button type="button" onclick="getCampaignDetails({{page}})"
            class="flex items-center justify-center cursor-pointer px-3 h-8 leading-tight text-gray-500 bg-white rounded-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">{{button-text}}</button>
        </li>`;
    let dots = `<li class="page-item disabled" aria-disabled="true"><span class="page-link">...</span></li>`;
    let previousButton = button.replace("{{button-text}}", "<");
    if (currentPage != 1) {
        previousButton = previousButton.replace("{{page}}", currentPage - 1);
    }
    let buildedPage = previousButton;
    const TOTAL_SIDE_BUTTON = 1;

    let startingMiddlePage = currentPage - TOTAL_SIDE_BUTTON;
    if (startingMiddlePage < 1 || startingMiddlePage == 2) {
        startingMiddlePage = 1;
    }

    let endMiddlePage = currentPage + TOTAL_SIDE_BUTTON;
    if (endMiddlePage > numberOfPage || endMiddlePage == numberOfPage - 1) {
        endMiddlePage = numberOfPage;
    }

    for (let i = startingMiddlePage; i <= endMiddlePage; i++) {
        if (i == currentPage) {
            buildedPage += currentPageButton.replaceAll("{{page}}", i);
        } else {
            buildedPage += otherPage.replaceAll("{{page}}", i);
        }
    }

    let nextButton = button.replaceAll("{{button-text}}", ">");
    if (currentPage != numberOfPage) {
        nextButton = nextButton.replace("{{page}}", currentPage + 1);
    }
    buildedPage += nextButton;
    $(selector).append(buildedPage);
}

function paginationUserAdminList(selector, numberOfPage, currentPage) {
    $(selector).empty();
    let currentPageButton = `<li>
        <button aria-current="page"
        onclick="getCampaigns({{page}})"
            class="flex items-center justify-center mx-1 cursor-pointer rounded-lg px-3 h-8 text-blue-600 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white">{{page}}</button>

        </li>`;
    // Other Page
    let otherPage = `<li>
        <a onclick="getCampaigns({{page}})"
            class="flex items-center justify-center me-1 px-3 h-8 leading-tight text-gray-500 bg-white hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 cursor-pointer rounded-lg dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">{{page}}</a>
        </li>`;
    let button = `<li>
        <button type="button" onclick="getCampaigns({{page}})"
            class="flex items-center justify-center cursor-pointer px-3 h-8 leading-tight text-gray-500 bg-white rounded-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">{{button-text}}</button>
        </li>`;
    let dots = `<li class="page-item disabled" aria-disabled="true"><span class="page-link">...</span></li>`;
    let previousButton = button.replace("{{button-text}}", "<");
    if (currentPage != 1) {
        previousButton = previousButton.replace("{{page}}", currentPage - 1);
    }
    let buildedPage = previousButton;
    const TOTAL_SIDE_BUTTON = 1;

    let startingMiddlePage = currentPage - TOTAL_SIDE_BUTTON;
    if (startingMiddlePage < 1 || startingMiddlePage == 2) {
        startingMiddlePage = 1;
    }

    let endMiddlePage = currentPage + TOTAL_SIDE_BUTTON;
    if (endMiddlePage > numberOfPage || endMiddlePage == numberOfPage - 1) {
        endMiddlePage = numberOfPage;
    }

    for (let i = startingMiddlePage; i <= endMiddlePage; i++) {
        if (i === currentPage) {
            buildedPage += currentPageButton.replaceAll("{{page}}", i);
        } else {
            buildedPage += otherPage.replaceAll("{{page}}", i);
        }
    }

    let nextButton = button.replaceAll("{{button-text}}", ">");
    if (currentPage != numberOfPage) {
        nextButton = nextButton.replace("{{page}}", currentPage + 1);
    }
    buildedPage += nextButton;
    $(selector).append(buildedPage);
}

function paginationCampaignDetails(selector, numberOfPage, currentPage) {
    $(selector).empty();
    let currentPageButton = `<li>
        <button aria-current="page"
        onclick="getAllUser({{page}})"
            class="flex items-center justify-center mx-1 cursor-pointer rounded-lg px-3 h-8 text-blue-600 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white">{{page}}</button>

        </li>`;
    // Other Page
    let otherPage = `<li>
        <a onclick="getAllUser({{page}})"
            class="flex items-center justify-center me-1 px-3 h-8 leading-tight text-gray-500 bg-white hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 cursor-pointer rounded-lg dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">{{page}}</a>
        </li>`;
    let button = `<li>
        <button type="button" onclick="getAllUser({{page}})"
            class="flex items-center justify-center cursor-pointer px-3 h-8 leading-tight text-gray-500 bg-white rounded-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">{{button-text}}</button>
        </li>`;
    let dots = `<li class="page-item disabled" aria-disabled="true"><span class="page-link">...</span></li>`;
    let previousButton = button.replace("{{button-text}}", "<");
    if (currentPage != 1) {
        previousButton = previousButton.replace("{{page}}", currentPage - 1);
    }
    let buildedPage = previousButton;
    const TOTAL_SIDE_BUTTON = 1;

    let startingMiddlePage = currentPage - TOTAL_SIDE_BUTTON;
    if (startingMiddlePage < 1 || startingMiddlePage == 2) {
        startingMiddlePage = 1;
    }

    let endMiddlePage = currentPage + TOTAL_SIDE_BUTTON;
    if (endMiddlePage > numberOfPage || endMiddlePage == numberOfPage - 1) {
        endMiddlePage = numberOfPage;
    }

    for (let i = startingMiddlePage; i <= endMiddlePage; i++) {
        if (i == currentPage) {
            buildedPage += currentPageButton.replaceAll("{{page}}", i);
        } else {
            buildedPage += otherPage.replaceAll("{{page}}", i);
        }
    }

    let nextButton = button.replaceAll("{{button-text}}", ">");
    if (currentPage != numberOfPage) {
        nextButton = nextButton.replace("{{page}}", currentPage + 1);
    }
    buildedPage += nextButton;
    $(selector).append(buildedPage);
}

function showModal(id) {
    const options = {
        placement: "bottom-right",
        backdrop: "dynamic",
        backdropClasses:
            "bg-gray-700 dark:bg-gray-700 fixed inset-0 z-40",
        closable: true,
    };
    const instanceOptions = {
        id: "modalEl",
        override: true,
    };

    let modal = new Modal(document.getElementById(id), options, instanceOptions);
    modal.show();
}

function hideModal(id) {
    let modal = new Modal(document.getElementById(id));
    modal.hide();
}

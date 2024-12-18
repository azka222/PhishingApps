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

    let modal = new Modal(document.getElementById(id), options, instanceOptions);
    modal.show();
}

function hideModal(id) {
    let modal = new Modal(document.getElementById(id));
    modal.hide();
}

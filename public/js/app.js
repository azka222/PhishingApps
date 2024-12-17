function test(){
    console.log('test');
}

function showModal(id){
    const modal = new Modal(document.getElementById(id), {
        placement: 'center',
        backdrop: 'static',
    });
}



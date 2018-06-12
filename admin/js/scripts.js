$(document).ready(function() {

    //CKEditor 5
    ClassicEditor.create(document.querySelector('#body')).catch( error => {
        console.error(error);
    });

});


$(document).ready(function () {
    $(".style_form").validate({
        rules: {
            name: {
                required: true,
                minlength: 3,
            },
            pseudo: {
                required: true,
                minlength: 3,
            },
            email: {
                required: true,
                email: true,
            },
            subject: {
                required: true,
                minlength: 3,
            },
        },
        messages: {
            name: {
                minlength: "Le nom doit comporter 3 charactères minimum !",
            },
            pseudo: {
                minlength: "Le pseudo doit comporter 3 charactères minimum !",
            },
            email: {
                email: "L'email doit respecter le format: nom@domain.com ",
            },
            subject: {
                minlength: "L'objet doit comporter 3 charactères minimum !",
            },
        },
    });
});
$.extend($.validator.messages, {required: "Ce champ est obligatoire !"});

require('./bootstrap');

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': config.csrf
    }
});
requestRenderTasks();

function requestRenderTasks() {
    $.post(
        config.routes.renderTasks,
        function (data) {
            $(".todo-container").html(data);
        }
    );
}
function renderModal(title) {
    $.ajaxSetup();
    $.ajax({
        type: 'POST',
        url: config.routes.renderModal,
        data: {title: title},
        success: function (response) {
            if (response.template) {
                $(`#practice_modal`).html(response.template);
                $(`#practice_modal`).modal('show');
                doSort()
            }
        },
    });
}

function doSort() {
    $(".sidebar-list-tasks").sortable({
        axis: "y", containment: `.sidebar-list-tasks`,
        stop: function () {
            let sequence = $(".sidebar-list-tasks").sortable('toArray');
            let title = $(".sidebar-list-tasks").closest('.modal-content')
                .children('.sidebar-header').children('h5').text().trim()
            $.ajax({
                type: 'POST',
                url: config.routes.sortSubtasks,
                data: {sequence: sequence, title: title},
                success: function (response) {
                    renderSubtasks(title)
                },
            });
        }
    });
}
$(document).delegate('#form-edit-subtask-submit', 'click', function (e) {
    e.preventDefault();
    let ind = $(`.form-edit-subtask`).children(`input[name="ind"]`).val();
    var subtask = $(`.form-edit-subtask`).children(`input[name="subtask"]`).val();
    let title = $(`.form-edit-subtask`).children(`input[name="title"]`).val();
    $.ajax({
        type: 'POST',
        url: config.routes.updateSubtask,
        data: {"_token": $('meta[name="csrf-token"]').attr('content'), ind: ind, title: title, subtask: subtask},
        success: function (response) {
            if (response.validationMessage === 'success') {
                $(".sidebar-list-tasks").sortable("enable")
                renderSubtasks(title)
            } else {
                let error = $(`.alert-modal`).html(response.validationMessage)
                error.removeClass('d-none')
            }
        },
        statusCode: {
            401: function () {
                alert('Вы не авторизованны');
                window.location.href = 'login';
            }
        },
    });
}).delegate('.add-subtask-btn', 'click', function () {
    if ($(this).parent().children('.form-add-subtask-wrapper')[0].childElementCount === 0) {
        $(this).parent().children('.form-add-subtask-wrapper')
            .html(
                '<form class="form-add-subtask mb-5">' +
                '<input type="hidden" name="_token" value="' + config.csrf + '">' +
                '<input type="text" name="subtask">' +
                '<input type="hidden" name="title" value="{{$obTask->title}}">' +
                '<button type="button" class="add-subtask-submit" id="form-add-subtask-submit"><img src="images/accept.svg" alt="accept-svg"></button>' +
                '</form>'
            );
    } else {
        $(this).parent().children('.form-add-subtask-wrapper').children('.form-add-subtask').remove();
    }
}).delegate('.delete-task-btn', 'click', function () {
    let title = $(this).parent().parent().children('p').text()
    $.ajax({
        type: 'POST',
        url: config.routes.delete,
        data: {title: title},
        success: function (response) {
            if (response.validationMessage === 'success') {
                requestRenderTasks();
            } else {
                console.log(response.validationMessage)
            }
        },
    });
}).delegate('.modal-open-btn', 'click', function () {
    renderModal($(this).closest('.todo-item').children('p').text().trim())
}).delegate('#form-edit-title-submit', 'click', function () {
    let old = $(`.form-edit-header`).children(`input[name="old"]`).val();
    var title = $(`.form-edit-header`).children(`input[name="title"]`).val();
    $.ajax({
        type: 'POST',
        url: config.routes.updateTitle,
        data: {"_token": $('meta[name="csrf-token"]').attr('content'), old: old, title: title},
        success: function (response) {
            if (response.validationMessage === 'success') {
                $(`#practice_modal`).modal('hide');
                requestRenderTasks()
            } else {
                let error = $(`.alert-modal`).html(response.validationMessage)
                error.removeClass('d-none')
            }
        },
        statusCode: {
            401: function () {
                alert('Вы не авторизованны');
                window.location.href = 'login';
            }
        },
    });
}).delegate('.delete-subtask-btn', 'click', function () {
    let ind = $(this).closest('.sidebar-task-wrapper').attr('index')
    let title = $(this).closest('.modal-content')
        .children('.sidebar-header').children('h5').text().trim()
    $.ajax({
        type: 'POST',
        url: config.routes.deleteSubtask,
        data: {title: title, ind: ind},
        success: function (response) {
            if (response.validationMessage === 'success') {
                renderSubtasks(title);
            } else {
                console.log(response.validationMessage)
            }
        },
    });
}).delegate('.edit-subtask-btn', 'click', function () {
    let title = $(this).closest('.modal-content').children('.sidebar-header').children('.sidebar-header-text').text().trim();
    let ind = $(this).closest('.sidebar-task-wrapper').attr('index')
    if ($(this).closest('.sidebar-task-item-content').children('.form-edit-wrapper')[0].childElementCount === 0) {
        $(".sidebar-list-tasks").sortable("disable");
        $(this).closest('.sidebar-task-item-content').children('.form-edit-wrapper')
            .html(
                '<form class="form-edit-subtask ml-0 mb-3" action="#">' +
                '<input type="text" name="subtask">' +
                '<input type="hidden" name="_token" value="' + config.csrf + '">' +
                '<input type="hidden" name="title" value="' + title + '">' +
                '<input type="hidden" name="ind" value="' + ind + '">' +
                '<button type="button" id="form-edit-subtask-submit"><img src="images/accept.svg" alt="accept-svg"></button>' +
                '</form>'
            );
    } else {
        $(".sidebar-list-tasks").sortable("enable");
        $(this).closest('.sidebar-task-item-content').children('.form-edit-wrapper').children('.form-edit-subtask').remove();
    }
}).delegate('.edit-header-text', 'click', function () {
    if (!$(this).closest('.sidebar').children('.form-edit-header-wrapper').has('.form-edit-header').length) {
        $(this).closest('.sidebar').children('.form-edit-header-wrapper')
            .html(
                '<form class="form-edit-header ml-0 mt-3">' +
                '<input type="text" name="title">' +
                '<input type="hidden" name="_token" value="' + config.csrf + '">' +
                '<input type="hidden" name="old" value="' + $(`.sidebar-header-text`).text().trim() + '">' +
                '<button type="button" id="form-edit-title-submit"><img src="images/accept.svg" alt="accept-svg"></button>' +
                '</form>'
            );
    } else {
        $('.sidebar-list-tasks').sortable('enable');
        $('.form-edit-header-wrapper').children('.form-edit-header').remove();
    }
}).delegate(".form-add-button", "click", function (e) {
    e.preventDefault();
    let title = $("input[name=title]").val();
    $.ajax({
        type: 'POST',
        url: config.routes.create,
        data: {"_token": config.csrf, title: title},
        success: function (response) {
            if (response.validationMessage === 'success') {
                requestRenderTasks();
            } else {
                let error = $(`.alert-danger`).html(response.validationMessage)
                error.removeClass('d-none')
            }
        },
        statusCode: {
            401: function () {
                alert('Вы не авторизованны');
                window.location.href = 'login';
            }
        },
    });
});
$(".submit-button-login-form").click(function (e) {
    e.preventDefault();
    let password = $("input[name=password]").val();
    let email = $("input[name=email]").val();
    $.ajax({
        type: 'POST',
        url: config.routes.login,
        data: {"_token": config.csrf, password: password, email: email},
        success: function (response) {
            if (response.redirect) {
                window.location.href = response.redirect;
            } else {
                let error = $(`.alert-danger`).html(response.validationMessage)
                error.removeClass('d-none')
            }
        },
    });
});
$(".submit-button-register-form").click(function (e) {
    e.preventDefault();
    let password = $("input[name=password]").val();
    let firstname = $("input[name=firstname]").val();
    let email = $("input[name=email]").val();
    $.ajax({
        type: 'POST',
        url: config.routes.register,
        data: {"_token": config.csrf, password: password, firstname: firstname, email: email},
        success: function (response) {
            if (response.redirect) {
                window.location.href = response.redirect;
            } else {
                console.log(response)
                let error = $(`.alert-danger`).html(response.validationMessage)
                error.removeClass('d-none')
            }
        },

    });
});

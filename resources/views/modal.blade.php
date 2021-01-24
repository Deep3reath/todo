<div class="modal-dialog" style="max-width: max-content">
    <script type="text/javascript">
        function deleteSubtask(el, title) {
            let ind = $(el).closest('.sidebar-task-wrapper').attr('index')
            $.ajaxSetup();
            $.ajax({
                type: 'POST',
                url: "{{ route('delete-subtask') }}",
                data: {title: title, ind:ind},
                success: function (response) {
                    if (response.validationMessage === 'success') {
                        renderSubtasks(title);
                    } else {
                        console.log(response.validationMessage)
                    }
                },
            });
        }
        $(document).on('click touchstart', '#form-edit-subtask-submit', function (e) {
            e.preventDefault();
            let ind = $(`.form-edit-subtask`).children(`input[name="ind"]`).val();
            var subtask = $(`.form-edit-subtask`).children(`input[name="subtask"]`).val();
            let title = $(`.form-edit-subtask`).children(`input[name="title"]`).val();
            $.ajax({
                type: 'POST',
                url: "{{ route('update-subtask') }}",
                data: {"_token": $('meta[name="csrf-token"]').attr('content'), ind: ind, title:title, subtask:subtask},
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
        });
        $(`.sidebar-list-tasks`).delegate('.edit-subtask-btn', 'click', function () {
            let title = $(this).closest('.modal-content').children('.sidebar-header').children('.sidebar-header-text').text().trim();
            let ind = $(this).closest('.sidebar-task-wrapper').attr('index')
            if ($(this).closest('.sidebar-task-item-content').children('.form-edit-wrapper')[0].childElementCount === 0) {
                $(".sidebar-list-tasks").sortable("disable");
                $(this).closest('.sidebar-task-item-content').children('.form-edit-wrapper')
                    .html(
                        '<form class="form-edit-subtask ml-0 mb-3" action="#">' +
                        '@csrf' +
                        '<input type="text" name="subtask">' +
                        '<input type="hidden" name="title" value="'+title+'">' +
                        '<input type="hidden" name="ind" value="'+ind+'">' +
                        '<button type="button" id="form-edit-subtask-submit"><img src="images/accept.svg" alt="accept-svg"></button>' +
                        '</form>'
                    );
            } else {
                $(".sidebar-list-tasks").sortable("enable");
                $(this).closest('.sidebar-task-item-content').children('.form-edit-wrapper').children('.form-edit-subtask').remove();
            }
        })
        $(document).ready(function () {
            $(".sidebar-list-tasks").sortable({
                axis: "y", containment: `.sidebar-list-tasks`,
                stop: function () {
                    let sequence = $(".sidebar-list-tasks").sortable('toArray');
                    let title = $(".sidebar-list-tasks").closest('.modal-content')
                        .children('.sidebar-header').children('h5').text().trim()
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('sort-subtasks') }}",
                        data: { sequence: sequence, title:title },
                        success: function (response) {
                            renderSubtasks(title)
                        },
                    });
                }
            });
        })
        $('.form-edit-header-wrapper').delegate('button', 'click', function (e) {
            e.preventDefault()
            let old = $(`.form-edit-header`).children(`input[name="old"]`).val();
            var title = $(`.form-edit-header`).children(`input[name="title"]`).val();
            $.ajax({
                type: 'POST',
                url: "{{ route('update-title') }}",
                data: {"_token": $('meta[name="csrf-token"]').attr('content'), old: old, title:title},
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
        });
        $('.edit-header-text').off().click(function () {
            if (!$(this).closest('.sidebar').children('.form-edit-header-wrapper').has('.form-edit-header').length) {
                $(this).closest('.sidebar').children('.form-edit-header-wrapper')
                    .html(
                        '<form class="form-edit-header ml-0 mt-3">' +
                        '@csrf' +
                        '<input type="text" name="title">' +
                        '<input type="hidden" name="old" value="{{$obTask->title}}">' +
                        '<button type="button" id="form-edit-title-submit"><img src="images/accept.svg" alt="accept-svg"></button>' +
                        '</form>'
                    );
            } else {
                $('.sidebar-list-tasks').sortable('enable');
                $('.form-edit-header-wrapper').children('.form-edit-header').remove();
            }
        })
        $('.form-add-subtask-wrapper').delegate('button', 'click', function (e) {
            e.preventDefault();
            let title = "{{$obTask->title}}";
            let subtask = $("input[name=subtask]").val();
            $.ajax({
                type: 'POST',
                url: "{{ route('create-subtask') }}",
                data: {"_token": $('meta[name="csrf-token"]').attr('content'), subtask: subtask, title: title},
                success: function (response) {
                    if (response.validationMessage === 'success') {
                        renderSubtasks("{{$obTask->title}}")
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
        });
        $('.add-subtask-btn').click( function () {
            if ($(this).parent().children('.form-add-subtask-wrapper')[0].childElementCount === 0) {
                $(this).parent().children('.form-add-subtask-wrapper')
                    .html(
                        '<form class="form-add-subtask mb-5">' +
                        '@csrf' +
                        '<input type="text" name="subtask">' +
                        '<input type="hidden" name="title" value="{{$obTask->title}}">' +
                        '<button type="button" class="add-subtask-submit" id="form-add-subtask-submit"><img src="images/accept.svg" alt="accept-svg"></button>' +
                        '</form>'
                    );
            } else {
                $(this).parent().children('.form-add-subtask-wrapper').children('.form-add-subtask').remove();
            }
        })
        renderSubtasks("{{$obTask->title}}")
        renderModalComments("{{$obTask->id}}")
    </script>
    <section class="modal-content sidebar mr-5 d-flex flex-column">
        <p class="alert alert-modal alert-danger d-none mt-5" onclick="$(this).addClass('d-none')"></p>
        <div class="sidebar-header mt-5">
            <h5 class="fz-18 text-center sidebar-header-text">{{$obTask->title}}
                <button class="ml-3 edit-header-text"><img src="images/edit.svg" alt="edit"></button>
            </h5>
            <div class="sidebar-header-likes d-flex flex-row align-items-center">
                <img src="images/like.svg" alt="like" class="mr-3">
                <p class="fz-12 mb-0 ml-0">{{$like}}</p>
            </div>
        </div>
        <div class="form-edit-header-wrapper ml-0 mr-0"></div>
        <div class="sidebar-list-tasks d-flex flex-column justify-content-between pt-5 mb-5"></div>
        <div class="sidebar-comments">
            <p class="fz-14">Комментарии:</p>
            <div class="sidebar-comments-wrapper">
                <div class="sidebar-comments-container mb-5"></div>
            </div>
            <div class="sidebar-comments-actions d-flex flex-column pt-5 mb-5">
                <div class="form-add-subtask-wrapper ml-0 mr-0"></div>
                <button class="fz-12 mb-3 add-subtask-btn">Добавить подзадачу</button>
            </div>
        </div>
    </section>
</div>

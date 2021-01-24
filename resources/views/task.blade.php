<?php  $i = 1 ?>
@foreach($obTasks as $obTask)
    <div class="todo-item d-flex flex-row align-items-center">
        <p class="ml-5">{{$obTask->title}}</p>
        <div class="mr-5 item-links" id="{{$obTask->title}}">
            <button class="delete" name="delete" onclick="deleteTask('{{$obTask->title}}')">Удалить</button>
            <button class="update" name="update" onclick="renderModal('{{$obTask->title}}');">Изменить</button>
        </div>
    </div>
    <div class="modal fade" id="practice_modal">
        @yield('modal')
    </div>
    <?php ++$i ?>
@endforeach
<script defer type="text/javascript">
    function renderModal(title) {
        $.ajaxSetup();
        $.ajax({
            type: 'POST',
            url: "{{ route('renderModal') }}",
            data: {title: title},
            success: function (response) {
                if (response.template) {
                    $(`#practice_modal`).html(response.template);
                    $(`#practice_modal`).modal('show');
                }
            },
        });
    }

    function renderModalComments(task) {
        $.ajaxSetup();
        $.ajax({
            type: 'POST',
            url: "{{ route('renderModalComments') }}",
            data: {task: task},
            success: function (response) {
                if (response.template) {
                    $(`.sidebar-comments-container`).html(response.template);
                }
            },
        });
    }

    function renderSubtasks(title) {
        $.ajaxSetup();
        $.ajax({
            type: 'POST',
            url: "{{ route('renderSubtasks') }}",
            data: {title: title},
            success: function (response) {
                if (response.template) {
                    $(`.sidebar-list-tasks`).html(response.template);
                }
            },
        });
    }

    function deleteTask(title) {
        $.ajaxSetup();
        $.ajax({
            type: 'POST',
            url: "{{ route('delete') }}",
            data: {title: title},
            success: function (response) {
                if (response.validationMessage === 'success') {
                    requestRenderTasks();
                } else {
                    console.log(response.validationMessage)
                }
            },
        });
    }
</script>

<?php  $i = 1 ?>
@foreach($obTasks as $obTask)
    <div class="todo-item d-flex flex-row align-items-center">
        <p class="ml-5">{{$obTask->title}}</p>
        <div class="mr-5 item-links" id="{{$obTask->title}}">
            <button class="delete" name="delete" onclick="deleteTask('{{$obTask->title}}')">Удалить</button>
            {{--            <button class="update" name="update" onclick="$(`#practice_modal-{{$i}}`).modal('show');">Изменить</button>--}}
            <button class="update" name="update" onclick="renderModal('{{$obTask->title}}');">Изменить</button>
        </div>
    </div>
    {{--    <div class="modal fade" id="practice_modal-{{$i}}">--}}
    {{--        <div class="modal-dialog">--}}
    {{--            <form>--}}
    {{--                @csrf--}}
    {{--                <div class="modal-content" style="height: 250px;">--}}
    {{--                    <h5 class="align-self-center pt-3">Изменить задачу: {{$obTask->title}}</h5>--}}
    {{--                    <div class="modal-body btn-group-vertical">--}}
    {{--                        <div class="modal-alert-{{$obTask->id}}  alert alert-danger d-none align-self-center"></div>--}}
    {{--                        <input type="hidden" class="form-control" name="old" value="{{$obTask->title}}">--}}
    {{--                        <input type="text" class="form-control" name="fresh" value="{{$obTask->title}}" placeholder="Введите задачу..">--}}
    {{--                    </div>--}}
    {{--                    <input type="button" value="Изменить" class="submit-update align-self-center mb-3 btn btn-dark" style="width: 150px;">--}}
    {{--                </div>--}}
    {{--            </form>--}}
    {{--        </div>--}}
    {{--    </div>--}}
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

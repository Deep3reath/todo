
    <?php  $i = 1 ?>
    @foreach($tasks as $task)
        <div class="d-flex flex-row task-item">
            <div class="task-item-title-container"><h5><span>{{$i}})</span>{{$task->title}}</h5></div>
                <button class="update" onclick="$(`#practice_modal-{{$i}}`).modal('show');"></button>
                <button class="delete" onclick="deleteTask('{{$task->title}}')"></button>
        </div>
        <div class="modal fade" id="practice_modal-{{$i}}">
            <div class="modal-dialog">
                <form>
                    @csrf
                    <div class="modal-content" style="height: 250px;">
                        <h5 class="align-self-center pt-3">Изменить задачу: {{$task->title}}</h5>
                        <div class="modal-body btn-group-vertical">
                            <div class="modal-alert-{{$task->id}}  alert alert-danger d-none align-self-center"></div>
                            <input type="hidden" class="form-control" name="old" value="{{$task->title}}">
                            <input type="text" onclick=""  class="form-control" name="fresh" value="{{$task->title}}" placeholder="Введите задачу..">
                        </div>
                        <input type="button" value="Изменить" class="submit-update align-self-center mb-3 btn btn-dark" style="width: 150px;">
                    </div>
                </form>
            </div>
        </div>

        <?php $i++ ?>
    @endforeach
    <script type="text/javascript">
        function deleteTask(title) {
            $.ajaxSetup();
            $.ajax({
                type:'GET',
                url:"{{ route('delete') }}",
                data:{title:title},
                success: function (response) {
                    if (response.redirect) {
                        renderTasks();
                    } else {
                        console.log(response.validationMessage)
                    }
                },
            });
        }
        $(".submit-update").click(function(e){
            e.preventDefault();
            let title = $("input[name='fresh']").val();
            let old = $("input[name='old']").val();
            $.ajax({
                type:'POST',
                url:"{{ route('update') }}",
                data:{"_token": $('meta[name="csrf-token"]').attr('content'),title:title, old:old},
                success: function (response) {
                    if (response.redirect) {
                        renderTasks();
                        $(`.modal-backdrop`).hide();
                        $(`.modal-dialog`).hide();
                    } else {
                        $(`.modal-alert-`+response.id).html(response.validationMessage).removeClass('d-none')
                    }
                },
            });
        });
    </script>

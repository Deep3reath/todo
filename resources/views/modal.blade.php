<div class="modal-dialog">
        <form>
            @csrf
            <div class="modal-content" style="height: 250px;">
                <h5 class="align-self-center pt-3">Изменить задачу: {{$obTask->title}}</h5>
                <div class="modal-body btn-group-vertical">
                    <div class="modal-alert  alert alert-danger d-none align-self-center"></div>
                    <input type="hidden" class="form-control" name="old" value="{{$obTask->title}}">
                    <input type="text" class="form-control" name="fresh" value="{{$obTask->title}}" placeholder="Введите задачу..">
                </div>
                <input type="button" value="Изменить" class="submit-update align-self-center mb-3 btn btn-dark" style="width: 150px;">
            </div>

            <script defer type="text/javascript">
                $(".submit-update").click(function (e) {
                    e.preventDefault();
                    let title = $("input[name='fresh']").val();
                    let old = $("input[name='old']").val();
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('update') }}",
                        data: {"_token": $('meta[name="csrf-token"]').attr('content'), title: title, old: old},
                        success: function (response) {
                            if (response.validationMessage === 'success') {
                                requestRenderTasks();
                                $(`.modal-backdrop`).hide();
                                $(`.modal-dialog`).hide();
                            } else {
                                $(`.modal-alert`).html(response.validationMessage).removeClass('d-none')
                            }
                        },
                    });
                });
            </script>

        </form>
</div>

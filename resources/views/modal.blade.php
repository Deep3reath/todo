<div class="modal-dialog" style="max-width: max-content">
    <script type="text/javascript">
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

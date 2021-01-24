<?php $indSub = 0; ?>

@foreach($arSubtasks as $subtask)
<div class="sidebar-task-item ml-0 mb-3 d-flex ui-state-default" id="{{$indSub}}">
    <div class="sidebar-task-item-content">
        <div class="sidebar-task-wrapper ml-0 d-flex flex-row" index="{{$indSub}}">
            <div class="sidebar-task-subtask-text ml-3 d-flex flex-row align-items-center">
                <p class="ml-0 mb-0 fz-16 ">{{$subtask}}</p>
            </div>
            <div class="sidebar-list-actions">
                <div class="d-flex flex-row">
                    <button class="ml-3 mr-2 edit-subtask-btn">
                        <img src="images/edit.svg" alt="edit">
                    </button>
                    <button onclick="deleteSubtask($(this), '{{$title}}')">
                        <img src="images/delete.svg" alt="delete-subtask">
                    </button>
                </div>
            </div>
        </div>
        <div class="form-edit-wrapper"></div>
    </div>
</div>
    <?php ++$indSub ?>
@endforeach

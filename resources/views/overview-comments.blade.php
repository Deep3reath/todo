@foreach($obComments as $obComment)
    <div class="overview-comments-item d-flex flex-column">
        <p class="fz-16 ml-0 mb-1">{{$obComment->user->firstname}}:</p>
        <p class="fz-18 ml-1">{{$obComment->content}}</p>
    </div>
@endforeach

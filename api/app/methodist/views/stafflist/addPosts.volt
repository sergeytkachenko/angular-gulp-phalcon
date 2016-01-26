<div class="alert alert-danger" role="alert" id="addPostsMsg" style="display: none;"></div>
<div class="alert alert-success" role="alert" id="addPostsSuccess" style="display: none;">{{trans._('post_added')}}</div>
<form class="form-inline" id="addPostsForm" method="POST" action="/methodist/stafflist/savePost">
    <div class="input-append">
        <input type="text" class="form-control" id="postTitle" name="title" placeholder="{{trans._('enter_post')}}" minlength="3" required>
        <span class="input-group-btn">
            <button class="btn btn-primary" type="submit">{{trans._('add')}}</button>
        </span>
    </div>
</form>

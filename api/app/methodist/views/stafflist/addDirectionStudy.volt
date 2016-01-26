<div class="alert alert-danger" role="alert" id="addDirectionStudyMsg" style="display: none;"></div>
<div class="alert alert-success" role="alert" id="addDirectionStudySuccess" style="display: none;">{{trans._('educ_dir_added')}}</div>
<form class="form-inline" id="addDirectionStudyForm" method="POST" action="/methodist/stafflist/saveDirectionStudy">
    <div class="input-append">
        <input type="text" class="form-control" id="directionStudyTitle" name="title" placeholder="{{trans._('enter_dir_name')}}" minlength="3" required>
        <span class="input-group-btn">
            <button class="btn btn-primary" type="submit">{{trans._('edd')}}</button>
        </span>
    </div>
</form>

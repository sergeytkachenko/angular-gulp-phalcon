<form class="form-inline" id="addStafflist" method="GET" action="add">
    <div class="input-append">
        <input type="text" class="form-control" id="nameStafflistGroup" name="title" placeholder="{{trans._('enter_staffing')}}" minlength="3" required>
        <span class="input-group-btn">
            <button class="btn btn-primary" type="submit">{{trans._('add')}}</button>
        </span>
    </div>
</form>

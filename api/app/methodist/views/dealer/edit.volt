<nav class="navbar navbar-default">
    <a role="button" class="btn btn-default" href="/methodist/dealer">
        <i class="fa fa-long-arrow-left"></i> {{trans._('all_dealers')}}
    </a>
</nav>
{% if saved %}<div class="alert alert-success" role="alert">{{trans._('data_saved')}}</div>{% endif %}
<form method="post" class="form-horizontal" action="/methodist/dealer/save?redirect={{ router.getRewriteUri() }}">
    <input type="hidden" id="id" name="id" value="{{ dealer.id }}">
    {% if dealer.id %}
    <div class="control-group">
        <label for="id"  class="control-label">{{trans._('enterprise_id')}} </label>
        <div class="controls">
            <input disabled type="text" id="id" value="{{ dealer.id }}">
        </div>
    </div>
    {% endif %}
    <div class="control-group">
        <label for="title"  class="control-label"> </label>
        <div class="controls">
            <input type="text" id="title" name="title" value="{{ dealer.title|e }}" required>
        </div>
    </div>
    <div class="control-group">
        <label for="address" class="control-label">{{trans._('enterprise_address')}}</label>
        <div class="controls">
            <input type="text" id="address" name="address" value="{{ dealer.address|e }}">
        </div>
    </div>
    <div class="control-group" style="{{ dealers|length == 0? 'display:none': '' }}">
        <label class="control-label" for="parent_id">{{trans._('parent_enterprise')}}</label>
        <div class="controls">
            <select class="form-control" name="parent_id" id="parent_id">
                <option value="">{{trans._('missing')}}</option>
                {%  for data in dealers %}
                    <option value="{{ data.id }}" {{ data.id == dealer.id ? 'selected' : '' }}>{{ data.title }}</option>
                {% endfor %}
                {% if dealers|length == 0 %}
                    <option value="NULL" >{{trans._('no_more_dealers')}}</option>
                {% endif %}
            </select>
        </div>
    </div>
    <div class="control-group">
        <label  class="control-label" for="status">{{trans._('enterprise_status')}}</label>
        <div class="controls">
            <select class="form-control" name="status" id="status" required>
                {%  for dealerStatus in dealerStatuses %}
                    <option value="{{ dealerStatus.id }}" {% if dealer.status == dealerStatus.id %} selected {% endif %}>{{ dealerStatus.title }}</option>
                {% endfor %}
            </select>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="region_id">{{trans._('region_city')}}</label>
        <div class="controls">
            <select class="form-control" name="region_id" id="region_id" required>
                {%  for region in regions %}
                    <option value="{{ region.id }}" {{ region.id == regionId? 'selected' : '' }}>{{ region.name }}</option>
                {% endfor %}
            </select>
            <select class="form-control" name="city_id" id="city_id" required>
                {% if dealer.id %}
                    {%  for city in dealer.City.Region.City %}
                        <option value="{{ city.id }}" {{ city.id == dealer.city_id ? 'selected': '' }}>{{ city.name }}</option>
                    {% endfor %}
                {% else %}

                    {%  for city in regionFirst.City %}
                        <option value="{{ city.id }}" >{{ city.name }}</option>
                    {% endfor %}
                {% endif %}
            </select>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="stafflist_group_id">{{trans._('staff_schedule')}}</label>
        <div class="controls">
            <select class="form-control" name="stafflist_group_id" id="stafflist_group_id" required>
                {%  for staffListGroup in staffListGroup %}
                    <option value="{{ staffListGroup.id }}" {{ staffListGroup.id == dealer.stafflist_group_id ? 'selected': '' }}>
                        {{ staffListGroup.title }}</option>
                {% endfor %}
            </select>
        </div>
    </div>
    <div class="control-group">
        <label  class="control-label" for="brands">{{trans._('brands')}}</label>
        <div class="controls">
            <select class="form-control chosen-select" name="brands[]" id="brands"  multiple>
                {%  for brand in brands %}
                    <option value="{{ brand['id'] }}" {{ brand['selected'] }} {{ brand['disabled'] }} >{{ brand['title'] }}</option>
                {% endfor %}
            </select>
        </div>
    </div>
    <div class="control-group">
        <label  class="control-label"  for="activities">{{trans._('action_line')}}</label>
        <div class="controls">
            <select class="form-control chosen-select" name="activities[]" id="activities" multiple>
                {%  for activity in activities %}
                    <option value="{{ activity['id'] }}" {{ activity['selected'] }} {{ activity['disabled'] }}>{{ activity['title'] }}</option>
                {% endfor %}
            </select>
        </div>
    </div>
    <hr />
    {% if dealer.id %}
    <div class="control-group">
        <label  class="control-label" for="students">{{trans._('students')}} ({{ count(dealer.StudentsPosts) }})</label>
        <div class="controls">
            <select class="form-control" name="students" id="students">
                {%  for studentAbility in dealer.StudentsAbilities %}
                    <option value="{{ studentAbility.students.id }}" >
                        {{ studentAbility.students.Users.last_name }}
                        {{ studentAbility.students.Users.name }}
                        {{ studentAbility.students.Users.second_name }}
                    </option>
                {% endfor %}
            </select>
            <a role="button" class="btn btn-default" href="javascript:editStudent()" id="edit-student" target="_blank">{{trans._('edit_student')}}</a>
        </div>
    </div>
    {% endif %}
    <hr />
    <div class="control-group">
        <label  class="control-label" for="inspectors">{{trans._('controllers')}}: </label>
        <div class="controls" id="inspectors-controls">
            <div  style="margin-bottom: 10px; display: none;" class="inspector-group">
                <select class="form-control" name="inspectors[]" id="inspectors" >
                    <option disabled>{{trans._('loading')}}...</option>
                </select>
                <button type="button" class="btn btn-danger" onclick="deleteInspector(this);">{{trans._('delete')}}</button>
            </div>
            {%  for dealerController in dealerControllers %}
            <div  style="margin-bottom: 10px;" class="inspector-group">
                <select class="form-control" name="inspectors[]" id="inspectors">
                    {% for controller in controllers  %}
                        <option value="{{ controller.id }}" {% if dealerController.Users.id == controller.id %} selected {% endif %} >
                            {{ controller.email }}
                        </option>
                    {% endfor %}
                </select>
                <button type="button" class="btn btn-danger" onclick="deleteInspector(this);">{{trans._('delete')}}</button>
                <a role="button" class="btn default" href="/methodist/inspector/edit/{{ dealerController.Users.id }}" target="_blank" style="margin-left: 10px;">{{trans._('to_edit')}}</a>
            </div>
            {% endfor %}
        </div>
    </div>
    <div class="control-group">
        <div class="controls">
            <button type="button" class="btn btn-primary" onclick="addInspector();">{{trans._('add_controller')}}</button>
        </div>
    </div>
    <br>
    <div class="span6" style="margin-left: 0">
        <button type="submit" class="btn btn-success" style="float: right" >{{trans._('save')}}</button>
        <a role="button" class="btn btn-default" href="/methodist/dealer">{{trans._('add_controller')}}{{trans._('undo')}}</a>
    </div>
</form>
<script>
    $(document).ready(function () {
        $(".chosen-select").chosen({disable_search_threshold: 10});
    });
    function editStudent () {
        var studentId = $("select[name=students]").val();
        if(!studentId) return;
        $("a#edit-student").attr("href", "/methodist/student/edit/"+studentId);
        $("a#edit-student")[0].click();
    }
    function addInspector () {
        var inspectorGroup = $(".inspector-group:hidden").clone();
        $(inspectorGroup).css("display", "block");

        $.post("/methodist/inspector/getAll", function( data ) {
            var html = "";
            $.each(data, function (key, user) {
                html += "<option value='"+user.id+"'>"+user.email+"</option>";
            });
            $(inspectorGroup).find("select").html(html);
            $("#inspectors-controls").append($(inspectorGroup));
        });
    }

    function deleteInspector (that) {
        var div = $(that).parents(".inspector-group");
        $(div).fadeOut(function () {
            $(div).remove();
        });
    }
</script>
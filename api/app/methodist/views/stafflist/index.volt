<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addStafflistGroup" data-whatever="{{trans._('add')}}">{{trans._('add_staff_schedule')}}</button>

<div class="modal fade" id="addStafflistGroup" tabindex="-1" role="dialog" aria-labelledby="addStafflistGroup" aria-hidden="true" hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="{{trans._('close')}}"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="addStafflistGroupLabel">{{trans._('add_staff_schedule')}}</h4>
            </div>
            <div class="modal-body" style="text-align: center;">
                {% include ("stafflist/addStafflistGroup") %}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{trans._('close')}}</button>
            </div>
        </div>
    </div>
</div>

<hr/>
{% for staff in stafflistGroup %}
    {% if loop.first %}
        <table id="example" class="table table-striped table-bordered table-hover ordering" cellspacing="0" width="100%">
        <thead style="text-align: center;">
        <tr>
            <th data-column="id">ID</th>
            <th width="80%">{{trans._('name_staff_schedule')}}</th>
            <th>{{trans._('action')}}</th>
        </tr>
        </thead>
        <tbody>
    {% endif %}
    <tr>
        <td style="text-align: center;">{{staff.id}}</td>
        <td>{{staff.title}}</td>
        <td style="text-align: center;">
            <div class="btn-group" role="group" aria-label="...">
                <a href="/methodist/stafflist/edit/{{staff.id}}" role="button" class="btn btn-default btn-lg" aria-label="{{trans._('to_edit')}}">
                    <span class="fa fa-pencil-square-o fa-fw"></span>
                </a>
                <!--<button type="button" class="btn btn-default btn-lg" style="color:red" aria-label="{{trans._('to_deactivate')}}">
                    <span class="fa fa-times fa-fw"></span>
                </button>-->
            </div>
        </td>
    </tr>
    {% if loop.last %}
        </tbody>
        </table>
    {% endif %}
    {% elsefor %}
    <div class="alert alert-warning" role="alert">{{trans._('no_staff_schedule_found')}}</div>
{% endfor %}
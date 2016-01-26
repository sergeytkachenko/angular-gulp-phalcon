<br/>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="" data-whatever="{{trans._('add')}}">
    {{trans._('add_personnel_plan')}}
</button>

<hr/>
{% for staff in stafflistPostPlan %}
    {% if loop.first %}

        <table id="example" class="table table-striped table-bordered table-hover ordering" cellspacing="0" width="100%">
        <thead style="text-align: center;">
        <tr>
            <th data-column="id">ID</th>
            <th>{{trans._('post_name')}}</th>
            <th>{{trans._('action')}}</th>
        </tr>
        </thead>
        <tbody>
    {% endif %}
    <tr>
        <td style="text-align: center;">{{ staff.id }}</td>
        <td>{{ staff.title }}</td>
        <td style="text-align: center;">
            <div class="btn-group" role="group" aria-label="...">
                <button type="button" class="btn btn-default btn-lg" aria-label="{{trans._('to_edit')}}">
                    <span class="fa fa-pencil-square-o fa-fw"></span>
                </button>

                <button type="button" class="btn btn-default btn-lg" style="color:red" aria-label="{{trans._('to_deactivate')}}">
                    <span class="fa fa-times fa-fw"></span>
                </button>
            </div>
        </td>
    </tr>
    {% if loop.last %}
        </tbody>
        </table>
    {% endif %}
    {% elsefor %}
    <div class="alert alert-warning" role="alert">{{trans._('no_personnel_plan_found')}}</div>
{% endfor %}
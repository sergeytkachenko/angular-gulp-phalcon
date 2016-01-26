<nav class="navbar navbar-default">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#checkIPN" data-whatever="{{trans._('add')}}"><i class="fa fa-user-plus"></i> {{trans._('add_student')}}</button>
</nav>
<div class="modal fade" id="checkIPN" tabindex="-1" role="dialog" aria-labelledby="checkIPN" aria-hidden="true" hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="{{trans._('close')}}"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="checkIPNLabel">{{trans._('adding_ptn')}}</h4>
            </div>
            <div class="modal-body" style="text-align: center;">
                {% include ("student/checkIPN") %}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{trans._('cancel')}}</button>
            </div>
        </div>
    </div>
</div>

<hr/>
{% for student in page.items %}
    {% if loop.first %}
        {%  if countItems > 0  %}{{ partial("partials/pagination") }}{% endif %}
        <table id="example" class="table table-striped table-bordered table-hover ordering" cellspacing="0" width="100%">
            <thead style="text-align: center;">
            <tr>
                <th data-column="id">ID</th>
                <th>{{trans._('login')}}</th>
                <th>{{trans._('family_name')}}</th>
                <th>{{trans._('name')}}</th>
                <th>{{trans._('surname')}}</th>
                <th>{{trans._('sex')}}</th>
                <th>{{trans._('date_of_birth')}}</th>
                <th>{{trans._('reg_ate')}}</th>
                <th>{{trans._('is_active')}}?</th>
                <th>{{trans._('action')}}</th>
            </tr>
            </thead>
            <tbody>
    {% endif %}
                <tr>
                    <td style="text-align: center;">{{student.id}}</td>
                    <td>{{student.users.login}}</td>
                    <td>{{student.users.name}}</td>
                    <td>{{student.users.last_name}}</td>
                    <td>{{student.users.second_name}}</td>
                    <td style="text-align: center;">
                        {% if student.users.is_male == 1 %}
                            <span class="fa fa-male fa-2x"></span>
                        {% else %}
                            <span class="fa fa-female fa-2x"></span>
                        {% endif %}
                    </td>
                    <td>{{student.users.birthday}}</td>
                    <td>{{student.users.date_registration}}</td>
                    <td style="text-align: center;">
                        {% if student.users.is_active == 1 %}
                            <span class="fa fa-check-square-o fa-2x" style="color:green"></span>
                        {% else %}
                            <span class="fa fa-square-o fa-2x"></span>
                        {% endif %}
                    </td>
                    <td style="text-align: center;">
                        <div class="btn-group" role="group" aria-label="...">
                            <!--<button type="button" class="btn btn-default" aria-label="{{trans._('review')}}">
                                <span class="fa fa-file-text-o fa-fw"></span>
                            </button>-->

                            <a href="/methodist/student/edit/{{student.id}}" role="button" class="btn btn-default btn-lg" aria-label="{{trans._('to_edit')}}">
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
    <div class="alert alert-warning" role="alert">{{trans._('no_student_found')}}</div>
{% endfor %}

<script>
    $(document).ready(function () {
        $("table.ordering").order();
    });
</script>
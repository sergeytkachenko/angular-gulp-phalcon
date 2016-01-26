<nav class="navbar navbar-default">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addDirectionStudy"
            data-whatever="{{trans._('add')}}">
        <i class="fa fa-plus"></i> {{trans._('add_dir_training')}}
    </button>
</nav>
<div class="modal fade" id="addDirectionStudy" tabindex="-1" role="dialog" aria-labelledby="addDirectionStudy"
     aria-hidden="true" hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="{{trans._('close')}}"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="addDirectionStudyLabel">{{trans._('add_dir_training')}}</h4>
            </div>
            <div class="modal-body" style="text-align: center;">
                {% include ("stafflist/addDirectionStudy") %}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{trans._('close')}}</button>
            </div>
        </div>
    </div>
</div>

<hr/>

{% if countItems > 0 %}
    <div>
        <div class="span6">{% if countItems > 0 %}{{ partial("partials/pagination") }}{% endif %}</div>
        <div class="span6" style="text-align: right">
            <form method="get" action="/methodist/stafflist/directionStudy/" class="pagination form-inline">
                <div class="form-group" style="display: inline-block;">
                    <label for="exampleInputName2">{{trans._('on_page')}}</label>
                    <select name="page-count" style="width: 70px;" onchange="$(this).parents('form').submit();">
                        <option value="10" {% if pageCount == 10 %} selected {% endif %}>10</option>
                        <option value="25" {% if pageCount == 25 %} selected {% endif %}>25</option>
                        <option value="50" {% if pageCount == 50 %} selected {% endif %}>50</option>
                        <option value="100" {% if pageCount == 100 %} selected {% endif %}>100</option>
                    </select>
                </div>
                <div class="form-group" style="display: inline-block;">
                    <input type="text" class="form-control" placeholder="" name="search" value="{{ search }}">
                </div>
                <button class="btn btn-default" type="submit">{{trans._('search')}}</button>
            </form>
        </div>
    </div>
    <table class="table table-striped table-bordered table-hover ordering">
        <tr>
            <th data-column="id">Id</th>
            <th data-column="title" width="80%">{{trans._('dir_name')}}</th>
            {#<th>{{trans._('action')}}</th>#}
        </tr>
        {% for item in page.items %}
            <tr>
                <td>{{ item.id }}</td>
                <td>{{ item.title }}</td>
                {#<td style="text-align: center;">#}
                {#<div class="btn-group" role="group" aria-label="...">#}
                {#<button type="button" class="btn btn-default btn-lg disabled" aria-label="{{trans._('to_edit')|lower}}">#}
                {#<span class="fa fa-pencil-square-o fa-fw"></span>#}
                {#</button>#}
                {#<button type="button" class="btn btn-default btn-lg disabled" style="color:red" aria-label="{{trans._('to_deactivate')}}">#}
                {#<span class="fa fa-times fa-fw"></span>#}
                {#</button>#}
                {#</div>#}
                {#</td>#}
            </tr>
        {% endfor %}

    </table>
    {% if countItems > 0 %}{{ partial("partials/pagination") }}{% endif %}

    <?php echo $this->trans->_('you_on_page', array('pagename' => $page->current, 'frompage' => $page->total_pages)); ?>

{% else %}
    <div class="alert alert-warning" role="alert">{{trans._('dir_not_found')}}</div>
{% endif %}

<script>
    $(document).ready(function () {
        $("table.ordering").order();
    });
</script>
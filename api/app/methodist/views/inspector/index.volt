<nav class="navbar navbar-default">
    <a role="button" class="btn btn-primary" href="/methodist/inspector/add">
        <i class="fa fa-plus"></i> {{trans._('add_inspector')}}
    </a>
</nav>
<div>
    <div class="span6">{%  if countItems > 0  %}{{ partial("partials/pagination") }}{% endif %}</div>
    <div class="span6" style="text-align: right">
        <form method="get" action="/methodist/inspector/" class="pagination form-inline">
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
                <input type="text" class="form-control" placeholder="{{trans._('what_to_search')}}" name="search" value="{{ search }}" >
            </div>
            <button class="btn btn-default" type="submit">{{trans._('search')}}</button>
        </form>
    </div>
</div>
{%  if countItems == 0  %}
    <h4>{{trans._('found_nothing')}}</h4>
{% endif %}
<table class="table table-striped table-bordered table-hover ordering" >
    <tr>
        <th data-column="id">Id</th>
        <th data-column="email">Email</th>
        <th data-column="last_name">{{trans._('surname')}}</th>
        <th data-column="name">{{trans._('name')}}</th>
        <th data-column="second_name">{{trans._('f_name')}}</th>
        <th data-column="pmobile">{{trans._('m_phone')}}</th>
        <th>{{trans._('to_edit')}}</th>
    </tr>
    {% for item in page.items %}
        <tr>
            <td>{{ item.id }}</td>
            <td>{{ item.email }}</td>
            <td>{{ item.last_name }}</td>
            <td>{{ item.name }}</td>
            <td>{{ item.second_name }}</td>
            <td>{{ item.pmobile }}</td>

            <td><a class="btn btn-info" href="/methodist/inspector/edit/{{ item.id }}" role="button"><i class="fa fa-edit"></i></a></td>
        </tr>
    {% endfor %}

</table>
{%  if countItems > 0  %}{{ partial("partials/pagination") }}{% endif %}

<?php echo $this->trans->_('you_on_page', array('pagename' => $page->current, 'frompage' => $page->total_pages)); ?>
<script>
    $(document).ready(function () {
        $("table.ordering").order();
    });
</script>
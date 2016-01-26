<nav class="navbar navbar-default">
    <a role="button" class="btn btn-primary" href="/methodist/dealer/add">
        <i class="fa fa-plus"></i> {{trans._('add_dealer')}}
    </a>
</nav>
<hr/>
{% if countItems > 0 %}
    <div>
        <div class="span6">{% if countItems > 0 %}{{ partial("partials/pagination") }}{% endif %}</div>
        <div class="span6" style="text-align: right">
            <form method="get" action="/methodist/dealer/" class="pagination form-inline">
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
                    <input type="text" class="form-control" placeholder="{{trans._('what_to_search')}}" name="search" value="{{ search }}">
                </div>
                <button class="btn btn-default" type="submit">{{trans._('search')}}</button>
            </form>
        </div>
    </div>

    <table class="table table-striped table-bordered table-hover ordering">
        <tr>
            <th data-column="id">Id</th>
            <th data-column="title">{{trans._('title')}}</th>
            <th data-column="address">{{trans._('address')}}</th>
            <th>{{trans._('region')}}</th>
            <th data-column="city_id">{{trans._('city')}}</th>
            <th data-column="stafflist_group_id">{{trans._('staff_schedule')}}</th>
            <th>{{trans._('brands')}}</th>
            <th>{{trans._('action_line')}}</th>
            <th>{{trans._('edit.')}}</th>
        </tr>
        {% for item in page.items %}
            <tr>
                <td>{{ item.id }}</td>
                <td>{{ item.title }}</td>
                <td>{{ item.address }}</td>
                <td>{{ item.City.Region.name }}</td>
                <td>{{ item.City.name }}</td>
                <td>{{ item.StafflistGroup.title }}</td>
                <td>
                    {% for brand in item.DealersBrands %}
                        <button type="button" class="btn btn-default btn-xs">{{ brand.Brands.title }}</button>
                    {% endfor %}
                </td>
                <td>
                    {% for activity in item.DealersActivities %}
                        <button type="button" class="btn btn-default btn-xs">{{ activity.Activities.title }}</button>
                    {% endfor %}
                </td>
                <td><a class="btn btn-info" href="/methodist/dealer/edit/{{ item.id }}" role="button"><i
                                class="fa fa-edit"></i></a></td>
            </tr>
        {% endfor %}

    </table>
    {% if countItems > 0 %}{{ partial("partials/pagination") }}{% endif %}

    <?php echo $this->trans->_('you_on_page', array('pagename' => $page->current, 'frompage' => $page->total_pages)); ?>

{% else %}
    <div class="alert alert-warning" role="alert">{{trans._('no_dealer_found')}}</div>
{% endif %}

<script>
    $(document).ready(function() {
        $("table.ordering").order();
    });
</script>
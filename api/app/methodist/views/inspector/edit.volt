<nav class="navbar navbar-default">
    <a role="button" class="btn btn-default" href="/methodist/inspector">
        <i class="fa fa-long-arrow-left"></i> {{trans._('all_inspectors')}}
    </a>
</nav>
{% if saved %}<div class="alert alert-success" role="alert">{{trans._('data_saved')}}</div>{% endif %}
<form method="post" class="form-horizontal" action="/methodist/inspector/save?redirect={{ router.getRewriteUri() }}">
    <input type="hidden" id="id" name="id" value="{{ inspector.id }}">
    {% if inspector.id %}
        <div class="control-group">
            <label for="id"  class="control-label">{{trans._('inspectors_id')}} </label>
            <div class="controls">
                <input disabled type="text" id="id" value="{{ inspector.id }}">
            </div>
        </div>
    {% endif %}
    <div class="control-group">
        <label for="email"  class="control-label">Email * </label>
        <div class="controls">
            <input type="email" id="email" name="email" value="{{ inspector.email|e }}" required>
        </div>
    </div>
    <div class="control-group">
        <label for="password"  class="control-label">{{trans._('password')}} * </label>
        <div class="controls">
            <input {{ passwordDisabled }} type="password" id="password" name="password" value="" required  >
            {% if passwordDisabled %}
                <button type="button" class="btn btn-danger" onclick="$('input[type=password]').removeAttr('disabled');">{{trans._('change')}}</button>
            {% endif %}
        </div>
    </div>
    <div class="control-group">
        <label for="pmobile" class="control-label">{{trans._('m_phone')}}</label>
        <div class="controls">
            <input type="text" id="pmobile" name="pmobile" value="{{ inspector.pmobile|e }}">
        </div>
    </div>
    <div class="control-group">
        <label for="last_name"  class="control-label">{{trans._('surname')}} </label>
        <div class="controls">
            <input type="text" id="last_name" name="last_name" value="{{ inspector.last_name|e }}" >
        </div>
    </div>
    <div class="control-group">
        <label for="name" class="control-label">{{trans._('name')}}</label>
        <div class="controls">
            <input type="text" id="name" name="name" value="{{ inspector.name|e }}">
        </div>
    </div>
    <div class="control-group">
        <label for="second_name" class="control-label">{{trans._('f_name')}}</label>
        <div class="controls">
            <input type="text" id="second_name" name="second_name" value="{{ inspector.second_name|e }}">
        </div>
    </div>

    <br>
    <div class="span6" style="margin-left: 0">
        <button type="submit" class="btn btn-success" style="float: right" >{{trans._('save')}}</button>
        <a role="button" class="btn btn-default" href="/methodist/inspector">{{trans._('undo')}}</a>
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
</script>
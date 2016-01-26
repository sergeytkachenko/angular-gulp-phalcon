<nav class="navbar navbar-default">
    <a role="button" class="btn btn-default" href="javascript:history.back();" >
        <i class="fa fa-long-arrow-left"></i> {{trans._('back')}}
    </a>
</nav>
{% for error in errors %}
    <div class="alert alert-danger" role="alert">{{ error }}</div>
{% endfor %}
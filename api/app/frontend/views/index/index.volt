<style>
    html, body, .container {
        height: 100%;
        background: rgb(206,220,231); /* Old browsers */
        background: -moz-linear-gradient(top,  rgba(206,220,231,1) 0%, rgba(89,106,114,1) 100%); /* FF3.6+ */
        background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(206,220,231,1)), color-stop(100%,rgba(89,106,114,1))); /* Chrome,Safari4+ */
        background: -webkit-linear-gradient(top,  rgba(206,220,231,1) 0%,rgba(89,106,114,1) 100%); /* Chrome10+,Safari5.1+ */
        background: -o-linear-gradient(top,  rgba(206,220,231,1) 0%,rgba(89,106,114,1) 100%); /* Opera 11.10+ */
        background: -ms-linear-gradient(top,  rgba(206,220,231,1) 0%,rgba(89,106,114,1) 100%); /* IE10+ */
        background: linear-gradient(to bottom,  rgba(206,220,231,1) 0%,rgba(89,106,114,1) 100%); /* W3C */
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#cedce7', endColorstr='#596a72',GradientType=0 ); /* IE6-9 */
    }
    .container {
        width: 400px;
        min-width: 400px;
        display: table;
        vertical-align: middle;


    }
    .vertical-center-row {
        display: table-cell;
        vertical-align: middle;

    }
    .borders {
        /*height: 100%;*/
        padding: 20px;
        margin: 14px;
        border: 1px solid #e1e1e8;
        border-radius: 4px;
        border-color: rgb(76,76,76);
        max-width: 420px;
        background: rgb(238,238,238); /* Old browsers */
        background: -moz-linear-gradient(top,  rgba(238,238,238,1) 0%, rgba(238,238,238,1) 100%); /* FF3.6+ */
        background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(238,238,238,1)), color-stop(100%,rgba(238,238,238,1))); /* Chrome,Safari4+ */
        background: -webkit-linear-gradient(top,  rgba(238,238,238,1) 0%,rgba(238,238,238,1) 100%); /* Chrome10+,Safari5.1+ */
        background: -o-linear-gradient(top,  rgba(238,238,238,1) 0%,rgba(238,238,238,1) 100%); /* Opera 11.10+ */
        background: -ms-linear-gradient(top,  rgba(238,238,238,1) 0%,rgba(238,238,238,1) 100%); /* IE10+ */
        background: linear-gradient(to bottom,  rgba(238,238,238,1) 0%,rgba(238,238,238,1) 100%); /* W3C */
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#eeeeee', endColorstr='#eeeeee',GradientType=0 ); /* IE6-9 */

    }
    .control-label {
        float: left;
        width: 60px !important;
    }
    .controls {
        margin-left: 70px !important;
    }
</style>

<div class="container">
    <div class="row vertical-center-row">
        <div class="col-lg-12 borders">
            <div class="alert alert-danger" role="alert" id="NotValid" {% if not err %} style="display: none;" {% endif  %}>
                {% if err == "1" %}
                    {{trans._('wrong_login_passw')}}
                {% endif  %}
                {% if err == "2" %}
                    {{trans._('no_access')}}
                {% endif  %}
            </div>
            <form class="form-horizontal" name="loginForm" id="loginForm" method="post" action="/api/login">

                <div class="control-group">
                    <label class="control-label" for="login">{{trans._('login')}} </label>

                    <div class="controls">
                        <input type="text" class="form-control" size="200" name="login" placeholder="{{trans._('login')}}" required>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="pass">{{trans._('password')}} </label>

                    <div class="controls">
                        <input type="password" class="form-control" size="200" name="pass" placeholder="{{trans._('password')}}" required>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <button type="submit" class="btn btn-success" style="float: right"><span class="fa fa-arrow-circle-o-right"></span>
                            {{trans._('entry')}}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="addPostDialog" tabindex="-1" role="dialog" aria-labelledby="addPost" aria-hidden="true"
     hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="{{trans._('close')}}"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="addPostLabel">{{trans._('add_post')}}</h4>
            </div>
            <div class="modal-body" style="text-align: center;">
                {% include ("stafflist/addPosts") %}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{trans._('close')}}</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addDirectionStudyDialog" tabindex="-1" role="dialog" aria-labelledby="addDirectionStudy"
     aria-hidden="true"
     hidden="true">
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


<nav class="navbar navbar-default">
    <a role="button" class="btn btn-default" href="/methodist/stafflist/">
        <i class="fa fa-long-arrow-left"></i> {{trans._('all_staffing')}}
    </a>
</nav>
<table id="example" class="table table-striped table-bordered table-hover ordering" cellspacing="0" width="100%">
    <thead style="text-align: center;">
    <tr>
        <th width="40%">{{trans._('post_name')}}</th>
        <th width="40%">{{trans._('educ_dir')}}</th>
        <th>Дія</th>
    </tr>
    </thead>
    <tfoot>
    <tr>
        <form method="POST" id="formx" action="javascript:void(null);">
            <td>
                <div class="controls">
                    <input type="hidden" id="namePost" name="title" style="width:350px;">
                </div>
            </td>
            <td>
                <div class="controls">
                    <input type="hidden" id="nameDirectionStudy" name="title" style="width:350px;">
                </div>
            </td>
            <td style="text-align: center;">
                <input type="hidden" id="stafflistGroup" name="stafflistGroup" value="{{ gid }}">
                <button class="btn btn-primary" id="stafflist-save">
                    <span class="fa fa-floppy-o"></span>
                </button>
            </td>
        </form>
    </tr>
    </tfoot>
    <tbody>
    {% for staff in stafflist %}
        <tr>
            <td width="49%">{{ staff.Posts.title }}</td>
            <td width="49%">{{ staff.DirectionStudy.title }}</td>
            <td>
                <div class="btn-group" role="group" aria-label="...">
                    <a href="#" role="button" class="btn btn-default btn-lg disabled" aria-label="{{trans._('to_edit')}}">
                        <span class="fa fa-pencil-square-o fa-fw"></span>
                    </a>

                    <button type="button" class="btn btn-default btn-lg disabled" style="color:red" aria-label="{{trans._('delete')}}">
                        <span class="fa fa-times fa-fw"></span>
                    </button>
                </div>
            </td>
        </tr>
    {% endfor %}
    </tbody>
</table>
<button class="btn" id="addRecordButton">
    <span class="fa fa-plus"></span> {{trans._('add')}}
</button>

<script>
    function showAddRecordForm(show) {
        if (show) {
            $("#namePost").select2("container").show();
            $("#nameDirectionStudy").select2("container").show();
            $("#stafflist-save").show();
            $("#addRecordButton").hide();
        } else {
            $("#namePost").select2("container").hide();
            $("#nameDirectionStudy").select2("container").hide();
            $("#stafflist-save").hide();
            $("#addRecordButton").show();
        }
    }
    $(document).ready(function() {
        showAddRecordForm(false);
    });
    $("#addRecordButton").click(function() {
        showAddRecordForm(true);
    });
    $("#namePost").select2({
        language: "uk",
        multiple: false,
        dropdownAutoWidth: false.valueOf(),
        "ajax": {
            url: "/crud/stafflist/getPosts/"+$("#stafflistGroup").val(),
            data: function(term, page) {
                return { title: term, page: page };
            },
            dataType: "JSON",
            quietMillis: 250,
            results: function(data, page) {
                var more = (page * 30)<data.total_count;
                return {results: data, more: more};
            },
            cache: false
        },
        createSearchChoice: function(term, data) {
            if ($(data).filter(function() {
                return this.title.localeCompare(term);
            }).prevObject.length===0) {
                return {id: -1, text: term, disabled: true};
            }
        },
        initSelection: function(element, callback) {
            var data = {id: element.val(), text: element.val()};
            callback(data);
        },
        formatResult: function(el) {
            var markup = '';
            if (el.id!== -1) {
                markup = el.title;
            } else {
                markup += '<div style="align: center;">' + '<p>{{trans._('no_matches')}}</p><p>{{trans._('can_add_new')}}</p>' + '<button class="btn btn-warning" id="addPostButton" data-toggle="modal" data-target="#addPostDialog" ' + 'onclick="onAddPostButtonClick();"> ' + '<span class="fa fa-plus"></span> {{trans._('add')}} ' + '</button>' + '</div>';
            }
            return markup;
        },
        formatSelection: function(el) {return el.title;}
    });

    function onAddPostButtonClick() {
        $("#namePost").select2("close");
        $('#postTitle').val("");
        $('#addPostsForm').show();
        $('.modal-footer').show();
        $('#addPostsSuccess').hide();
        $('#addPostDialog').modal('show');
    }

    $("#addPostsForm").submit(function() {
        var url = "/crud/posts/add"; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            data: $("#addPostsForm").serialize(), // serializes the form's elements.
            success: function(data) {
                if (data.retcode===0) { //Если есть результат и ответ успешный
                    $('#addPostsForm').hide();
                    $('#addPostsSuccess').show();
                } else {
                    data.msgs.forEach(function(element, index, array) {$('#addPostsMsg').text(element);});
                    $('#addPostsMsg').show();
                }
            },
            error: function(jqXHR, textStatus, errorMessage) {
                console.log(errorMessage); // Optional
                $('#addPostsMsg').text(errorMessage);
                $('#addPostsMsg').show();
            }
        });

        return false; // avoid to execute the actual submit of the form.
    });

    $("#nameDirectionStudy").select2({
        language: "uk",
        multiple: false,
        dropdownAutoWidth: false.valueOf(),
        "ajax": {
            url: "/crud/directionStudy/search",
            data: function(term, page) {
                return { title: term, page: page };
            },
            dataType: "json",
            quietMillis: 250,
            results: function(data, page) {
                var more = (page * 30)<data.total_count;
                return {results: data, more: more};
            },
            cache: false
        },
        createSearchChoice: function(term, data) {
            if ($(data).filter(function() {
                return this.title.localeCompare(term);
            }).prevObject.length===0) {
                return {id: -1, text: term, disabled: true};
            }
        },
        initSelection: function(element, callback) {
            var data = {id: element.val(), text: element.val()};
            callback(data);
        },
        formatResult: function(el) {
            var markup = '';
            if (el.id!== -1) {
                markup = el.title;
            } else {
                markup += '<div style="align: center;">' + '<p>{{trans._('no_matches')}}</p><p>{{trans._('can_add_new')}}</p>' + '<button class="btn btn-warning" id="addDirectionStudyButton" data-toggle="modal" data-target="#addDirectionStudyDialog" ' + 'onclick="onAddDirectionStudyButtonClick();"> ' + '<span class="fa fa-plus"></span> {{trans._('add')}} ' + '</button>' + '</div>';
            }
            return markup;
        },
        formatSelection: function(el) {return el.title;}
    });

    function onAddDirectionStudyButtonClick() {
        $("#nameDirectionStudy").select2("close");
        $('#directionStudyTitle').val("");
        $('#addDirectionStudyForm').show();
        $('.modal-footer').show();
        $('#addDirectionStudySuccess').hide();
        $('#addDirectionStudyDialog').modal('show');
    }

    $("#addDirectionStudyForm").submit(function() {
        var url = "/crud/directionStudy/add"; // the script where you handle the form input.

        $.ajax({
            type: "POST",
            url: url,
            data: $("#addDirectionStudyForm").serialize(), // serializes the form's elements.
            success: function(data) {
                if (data.retcode===0) { //Если есть результат и ответ успешный
                    $('#addDirectionStudyForm').hide();
                    $('#addDirectionStudySuccess').show();
                } else {
                    data.msgs.forEach(function(element, index, array) {$('#addDirectionStudyMsg').text(element);});
                    $('#addDirectionStudyMsg').show();
                }
            },
            error: function(jqXHR, textStatus, errorMessage) {
                console.log(errorMessage); // Optional
                $('#addDirectionStudyMsg').text(errorMessage);
                $('#addDirectionStudyMsg').show();
            }
        });

        return false; // avoid to execute the actual submit of the form.
    });

    $("#stafflist-save").click(function() {
        $.ajax({
            type: "POST",
            url: "/crud/stafflist/save",
            data: {
                post: function() { return $("#namePost").val(); },
                directionStudy: function() { return $("#nameDirectionStudy").val(); },
                stafflistGroup: function() { return $("#stafflistGroup").val(); }
            },
            success: function(data) {
                if (data.retcode===0) { //Если есть результат и ответ успешный
                    location.reload();
                } else {
                    data.msgs.forEach(function(element, index, array) {$('#addDirectionStudyMsg').text(element);});
                    $('#addDirectionStudyMsg').show();
                }
            },
            error: function(jqXHR, textStatus, errorMessage) {
                console.log(errorMessage); // Optional
                $('#addDirectionStudyMsg').text(errorMessage);
                $('#addDirectionStudyMsg').show();
            }
        });
    });

</script>


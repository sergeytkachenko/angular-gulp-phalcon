<nav class="navbar navbar-default">
    <a role="button" class="btn btn-default" href="/methodist/student">
        <i class="fa fa-long-arrow-left"></i> {{trans._('all_students')}}
    </a>
</nav>
{% if (not nothing) %}
    <div class="alert alert-danger" role="alert" id="NotValid" style="display: none;"></div>
    <form class="form-horizontal" name="studentForm" id="studentForm" method="post" action="/methodist/student/save">
    <div class="control-group">
        <label class="control-label" for="ind-code">{{trans._('ptn')}} </label>

        <div class="controls">
            <input type="text" class="input-small uneditable-input" readonly size="15" name="ind_code"
                   value={{ ind_code }}>
            {% if user.id %}
                <input type="hidden" name="id" value="{{ student.id }}">
                <input type="hidden" name="uid" value="{{ user.id }}">
            {% endif %}
        </div>
    </div>
    <div class="control-group required">
        <label class="control-label" for="name">{{trans._('snf')}} </label>

        <div class="controls">
            <input type="text" class="form-control" size="200" name="last_name" placeholder="{{trans._('surname')}}" required
                   value="{{ user.last_name }}">
            <input type="text" class="form-control" size="200" name="name" placeholder="{{trans._('name')}}" required
                   value="{{ user.name }}">
            <input type="text" class="form-control" size="200" name="second_name" placeholder="{{trans._('f_name')}}" required
                   value="{{ user.second_name }}">
        </div>
    </div>
    <div class="control-group required">
        <label class="control-label" for="login">{{trans._('login_password')}} </label>

        <div class="controls">
            <input type="text" class="form-control" size="200" name="login" placeholder="{{trans._('login')}}" required
                   value="{{ user.login }}">
            <input type="text" class="form-control" size="200" name="password" placeholder="{{trans._('password')}}" required
                   value="{{ user.password }}">
        </div>
    </div>
    <div class="control-group required">
        <label class="control-label" for="is_male">{{trans._('sex')}} </label>

        <div class="controls">
            <div class="btn-toolbar" style="margin:0px;">
                <div class="btn-group" data-toggle-name="is_male" data-toggle="buttons-radio">
                    <button type="button" class="btn" value="1" data-toggle="button">
                        <span class="fa fa-male"></span>
                    </button>
                    <button type="button" class="btn" value="0" data-toggle="button">
                        <span class="fa fa-female"></span>
                    </button>
                </div>
                <input type="hidden" name="is_male" value="{{ user.is_male }}"/>
            </div>
        </div>
    </div>
    <div class="control-group required">
        <label class="control-label" for="birthday">{{trans._('date_of_birth')}} </label>

        <div class="controls">
            <input type="date" class="form-control" size="200" name="birthday" required value="{{ user.birthday }}">
        </div>
    </div>
    <div class="control-group required">
        <label class="control-label" for="educ">{{trans._('education')}} </label>

        <div class="controls">
            <button type="button" id="educButton" name="educButton" class="btn" onclick="addEducationClick();">
                <span class="fa fa-plus"> {{trans._('add')}}</span>
            </button>
            <div id="educations">
                {% if student!=NULL %}
                    {% for education in student.StudentsEducation %}
                        <div id="education_n{{ education.id }}" class="form-horizontal panel">
                            <a class="closable fa fa-times" href="javascript:void(0);" onclick="removeBlock(this);"></a>
                            <label class="custom-label">{{trans._('education_level')}}: </label>
                            <span>{{ education.Educations.title }}</span>
                            <label class="custom-label" id="education_child_id_label" style="display: none;">{{trans._('educ_quality_level')}}: </label>
                            <span>{{ education.Educations.title }}</span>
                            <label class="custom-label">{{trans._('specialty')}}: </label>
                            <span>{{ education.speciality }}</span>
                            <label class="custom-label">{{trans._('quality')}}: </label>
                            <span>{{ education.qualify }}</span>
                            <label class="custom-label">{{trans._('educational_institution')}}: </label>
                            <span>{{ education.institution }}</span>
                            <label class="custom-label">{{trans._('diploma_number')}}: </label>
                            <span>{{ education.diploma_number }}</span>
                            <label class="custom-label">{{trans._('date_issue_diploma')}}: </label>
                            <span>{{ education.diploma_date }}</span>
                            <input type="hidden" id="student_education" name="student_education[]"
                                   value='{{ JSON_encode(education) }}'>
                        </div>
                    {% endfor %}
                {% endif %}
                <div id="education_edit" class="form-horizontal panel" style="display: none;">
                    <legend id="education-head">{{trans._('education')}}</legend>
                    <div class="alert alert-success" role="alert" id="education-saved" style="display: none;">{{trans._('education_saved')}}</div>
                    <label class="custom-label">{{trans._('education_level')}}: </label>
                    <select class="form-control" id="education_id" onchange="parentEducationChange(this)">
                        {% for education in allEducations %}
                            <option value="{{ education.id }}">{{ education.title }}</option>
                        {% endfor %}
                    </select>
                    <label class="custom-label" id="education_child_id_label" style="display: none;">{{trans._('educ_quality_level')}}: </label>
                    <select class="form-control" id="education_child_id" style="display: none;">
                    </select>
                    <label class="custom-label">{{trans._('specialty')}}: </label>
                    <input type="text" class="input-xxlarge form-control" id="speciality" size="400" value="-">
                    <label class="custom-label">{{trans._('quality')}}: </label>
                    <input type="text" class="input-xxlarge form-control" id="qualify" size="400" value="-">
                    <label class="custom-label">{{trans._('educational_institution')}}: </label>
                    <input type="text" class="input-xxlarge form-control" id="institution" size="400" value="-">
                    <label class="custom-label">{{trans._('diploma_number')}}: </label>
                    <input type="text" class="input-large form-control" id="diploma_number" size="40" value="-">
                    <label class="custom-label">{{trans._('date_issue_diploma')}}: </label>
                    <input type="date" class="input-large form-control" id="diploma_date" size="15" value="">
                    <br/><br/>
                    <button type="button" class="btn btn-danger" id="education_deastroy"
                            onclick="cancelEducationClick(this);"><span class="fa fa-times"></span> {{trans._('undo')}}
                    </button>
                    <button type="button" class="btn btn-primary" id="education_save" style="float: right"
                            onclick="saveEducationClick(this);"><span class="fa fa-floppy-o"></span> {{trans._('save')}}
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="address_home">{{trans._('address')}} </label>

        <div class="controls">
            <input type="text" class="input-xxlarge form-control" size="400" name="address_home"
                   placeholder="{{trans._('real_address')}}" value="{{ user.address_home }}">
        </div>
    </div>
    <!--<div class="control-group">
        <label class="control-label" for="photo_src">{{trans._('photo')}} </label>
        <div class="controls">
            <input type="file" class="form-control" size="200" name="photo_src" placeholder="{{trans._('choose_photo')}}" accept="image/jpeg,image/png,image/gif">
        </div>
    </div>-->
    <div class="control-group required">
        <label class="control-label" for="email">{{trans._('email')}} </label>

        <div class="controls">
            <input type="email" class="form-control" size="200" name="email" placeholder="email@example.com" required
                   email="true" value="{{ user.email }}">
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="phome">{{trans._('phones')}}</label>

        <div class="controls">
            <input type="tel" class="form-control" size="200" name="phome" placeholder="{{trans._('contact_phone')}}"
                   value="{{ user.phome }}">
            <input type="tel" class="form-control" size="200" name="pmobile" placeholder="{{trans._('mobile_phone')}}"
                   value="{{ user.pmobile }}">
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="position">{{trans._('post')}} </label>

        <div class="controls">
            <button type="button" name="postButton" id="postButton" class="btn" onclick="addPostClick();">
                <span class="fa fa-plus"> {{trans._('add')}}</span>
            </button>
            <div id="positions">
                {% if student!=NULL %}
                    {% for post in student.StudentsPosts %}
                        <div id="education_n{{ education.id }}" class="form-horizontal panel">
                            <a class="closable fa fa-times" href="javascript:void(0);" onclick="removeBlock(this);"></a>
                            <label class="custom-label">{{trans._('enterprise')}}: </label>
                            <span>{{ post.Dealers.title }}</span>
                            <label class="custom-label">{{trans._('post')}}: </label>
                            <span>{{ post.Posts.title }}</span>
                            <label class="custom-label">{{trans._('brands')}}: </label>
                            <span>
                                    {% for spb in post.StudentsPostsBrands %}
                                        {{ spb.Brands.title }}{% if not loop.last %},{% endif %}
                                    {% endfor %}
                            </span>
                            <label class="custom-label">{{trans._('areas_of_activity')}}: </label>
                            <span>
                                   {% for spa in post.StudentsPostsActivities %}
                                       {{ spa.Activities.title }}{% if not loop.last %},{% endif %}
                                   {% endfor %}
                            </span>
                            <label class="custom-label">{{trans._('rate')}}: </label>
                            <span>{{ post.rate }}</span>
                            <label class="custom-label">{{trans._('date_of_appointment')}}: </label>
                            <span>{{ post.appoint_date }}</span>
                            <input type="hidden" id="student_education" name="student_post[]"
                                   value='{{ studentPostsJSON|json_encode }}'>
                        </div>
                    {% endfor %}
                {% endif %}
                <div id="post-edit" class="form-horizontal panel" style="display: block;">
                    <legend id="post-head">{{trans._('post')}}</legend>
                    <div class="alert alert-success" role="alert" id="post-saved" style="display: none;">{{trans._('post_saved')}}
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="dealer">{{trans._('enterprise')}}: </label>

                        <div class="controls">
                            <select class="form-control" name="dealer" id="dealer" style="width: 220px;"
                                    onchange="dealerChange(this)">
                                <option value="" selected disabled>{{trans._('choose_enterprise')}}</option>
                                {% for dealer in allDealers %}
                                    <option value="{{ dealer.id }}">{{ dealer.title }}</option>
                                {% endfor %}
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" id="post-label" for="post" style="display: none;">{{trans._('post')}}: </label>

                        <div class="controls">
                            <select class="form-control" name="post" id="post" style="display: none; width: 220px;">
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="brands">{{trans._('brands')}}: </label>

                        <div class="controls">
                            <select class="form-control chosen-select" name="brands" id="brands" multiple
                                    data-placeholder="{{trans._('choose_brands')}}">
                                {% for brand in brands %}
                                    <option value="{{ brand['id'] }}" {{ brand['selected'] }} {{ brand['disabled'] }} >{{ brand['title'] }}</option>
                                {% endfor %}
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="activities">{{trans._('areas_of_activity')}}: </label>

                        <div class="controls">
                            <select class="form-control chosen-select" name="activities" id="activities" multiple
                                    data-placeholder="{{trans._('choose_areas')}}">
                                {% for activity in activities %}
                                    <option value="{{ activity['id'] }}" {{ activity['selected'] }} {{ activity['disabled'] }}>{{ activity['title'] }}</option>
                                {% endfor %}
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="rate">{{trans._('rate')}}: </label>

                        <div class="controls">
                            <input type="number" class="form-control" name="rate" id="rate" size="400" value="1.0"
                                   max="2.0" min="0.1" step="0.1">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="appoint_date">{{trans._('date_of_appointment')}}: </label>

                        <div class="controls">
                            <input type="date" class="input-large form-control" name="appoint_date" id="appoint_date"
                                   size="15" value="">
                        </div>
                    </div>
                    <br/><br/>
                    <button type="button" class="btn btn-danger" id="post-deastroy" onclick="cancelPostClick(this);">
                        <span class="fa fa-times"></span> {{trans._('undo')}}
                    </button>
                    <button type="button" class="btn btn-primary" id="post-save" style="float: right"
                            onclick="savePostClick(this);"><span class="fa fa-floppy-o"></span> {{trans._('save')}}
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!--<div class="control-group">
        <label class="control-label" for="phome">{{trans._('post')}} </label>
        <div class="controls">
            <input type="tel" class="input-xxlarge form-control" size="200" name="phome" placeholder="{{trans._('post_label')}}">
        </div>
    </div>-->

    <!--<div class="checkbox">
        <label>
            <input type="checkbox"> {{trans._('is_active')}}
        </label>
    </div>-->
    <div class="span6" style="margin-left: 0">
        <div class="controls">
            <button type="submit" class="btn btn-success" style="float: right"><span class="fa fa-floppy-o"></span>
                {{trans._('save')}}
            </button>
            <a role="button" class="btn btn-default" href="/methodist/student"><span class="fa fa-ban"></span> {{trans._('undo')}}</a>
        </div>
    </div>

    </form>
    <script>
    var educCounter = 0;
    var postCounter = 0;

    function escapeHtmlEntities(str) {
        if (typeof jQuery!=='undefined') {
            // Create an empty div to use as a container,
            // then put the raw text in and get the HTML
            // equivalent out.
            return jQuery('<div/>').text(str).html();
        }

        // No jQuery, so use string replace.
        return str.replace(/&/g, '&amp;').replace(/>/g, '&gt;').replace(/</g, '&lt;').replace(/"/g, '&quot;');
    }

    //Очистить поля блока
    function clearBlock(name) {
        $(name).children().each(function() {
            this.value = "";
        });
    }
    //удалить блок
    function removeBlock(elem) {
        $(elem).parent().remove();
    }

    function addPostClick() {
        clearBlock("#post-edit");
        $("#post-edit").css("display", "block");
        $("#postButton").css("display", "none");
        //console.log("Update chosen "+$("#post-activities").);
        $("#post-activities").trigger("chosen:updated");
    }

    function FormatResult(item) {
        var markup = "";
        if (item.name!==undefined) {
            markup += "<option value='" + item.id + "'>" + item.name + "</option>";
        }
        return markup;
    }

    function FormatSelection(item) {
        return item.name;
    }

    //Выбор должностей у предприятия
    function dealerChange(elem) {

        var select = elem;
        var dealerId = $(elem).val();

        $.post("/crud/stafflist/getPostsByDealer?id=" + dealerId, function(data) {
            $("select[id=post]").html("<option>{{trans._('loading')}}...</option>");
            var html = "";
            $.each(data, function(key, post) {
                html += "<option value='" + post.id + "'>" + post.title + "</option>";
            });
            if (html.length>1) {
                $("select[id=post]").css("display", "block");
                $("label[id=post-label]").css("display", "block");
                $("select[id=post]").html(html);
                $("#post").select2();
            } else {
                $("select[id=post]").css("display", "none");
                $("label[id=post-label]").css("display", "none");
                $("select[id=post]").html("");
                $("#post").select2();
                $("#s2id_post").hide();
            }
        });
    }

    //Сохранение должности
    /** сериализуется во скрытый input по причине того, что
     *  при создании пользователя у него ещё нет ID в БД,
     *  а резервировать его заранее -- плохая идея.
     **/
    function savePostClick(elem) {
        var data = {};
        postCounter++;
        var html = '<div id="post-js' + postCounter + '" class="form-inline panel">';
        html += '<a class="closable fa fa-times" href="javascript:void(0);" onclick="removeBlock(this);"></a>';
        $("#post-edit").find("input, label, select").each(function() {
            if (this.tagName==="LABEL") {
                html += '<label class="custom-label">' + $(this).html() + '</label> ';
            } else if (this.tagName==="SELECT") {
                if ($(this).hasClass("chosen-select")) {
                    html += '<span>';
                    if ($(this).find("option:selected")) {
                        $(this).find("option:selected").each(function() {
                            html += $(this).text() + ', ';
                        })
                    } else {
                        html += '<span>-</span><br>';
                    }
                    html = html.substring(0, html.length - 2);
                    html += '</span><br>';
                    data[this.id] = $(this).chosen().val();
                } else {
                    if ($(this).find("option:selected").html()) {
                        html += '<span>' + $(this).find("option:selected").html() + '</span><br>';
                    } else {
                        html += '<span>-</span><br>';
                    }
                    data[this.id] = this.value;
                }
            }
            /*Здесь добавлена проверка на соотв. класса, т.к. choosen добавляет свой служебный input,
             чтобы на его место не ставились прочерки лишние. */ else if ((this.tagName==="INPUT") && ($(this).hasClass("form-control"))) {
                if (this.value.length>0) {
                    html += '<span>' + this.value + '</span><br>';
                } else {
                    html += '<span>-</span><br>';
                }
                data[this.id] = this.value;
            }

        });
        html += "<input type='hidden' id='student-post' name='student_post[]' value='" + escapeHtmlEntities($.toJSON(data)) + "'>";
        clearBlock("#post-edit");
        $("div[id=post-saved]").css("display", "block");
        $("div[id=post-edit]").css("display", "none");
        $("#postButton").css("display", "block");
        html += '</div>';
        $("div[id=positions]").append(html);
    }

    function addEducationClick() {
        clearBlock("#education_edit");
        $("#education_edit").css("display", "block");
        $("#educButton").css("display", "none");
    }
    //Выбор дочерного типа обучения
    function parentEducationChange(elem) {
        var select = elem;
        var educId = $(elem).val();
        //var elemId = elem.id.match(/\d+$/)[0]; //вытащить из ID элемента только номер
        $.post("/crud/education/search?parent_id=" + educId, function(data) {
            $("select[id=education_child_id]").html("<option>{{trans._('loading')}}...</option>");
            var html = "";
            $.each(data, function(key, educ) {
                html += "<option value='" + educ.id + "'>" + educ.title + "</option>";
            });
            if (html.length>1) {
                $("select[id=education_child_id]").css("display", "block");
                $("label[id=education_child_id_label]").css("display", "block");
                $("select[id=education_child_id]").html(html);
            } else {
                $("select[id=education_child_id]").css("display", "none");
                $("label[id=education_child_id_label]").css("display", "none");
                $("select[id=education_child_id]").html("");
            }
        });
    }

    //Отменить должность
    function cancelPostClick(elem) {
        clearBlock("#post-edit");
        $("div[id=post-edit]").css("display", "none");
        $("#postButton").css("display", "block");
    }

    //Отменить обучение
    function cancelEducationClick(elem) {
        clearBlock("#education_edit");
        $("div[id=education_edit]").css("display", "none");
        $("#educButton").css("display", "block");
    }

    //Сохранение обучения
    /** сериализуется во скрытый input по причине того, что
     *  при создании пользователя у него ещё нет ID в БД,
     *  а резервировать его заранее -- плохая идея.
     **/
    function saveEducationClick(elem) {
        var chr = { '"': '&quot;', '&': '&amp;', '<': '&lt;', '>': '&gt;' };
        var data = {};
        educCounter++;
        var html = '<div id="education_js' + educCounter + '" class="form-inline panel">';
        html += '<a class="closable fa fa-times" href="javascript:void(0);" onclick="removeBlock(this);"></a>';
        $("#education_edit").find("input, label, select").each(function() {
            if (this.tagName==="LABEL") {
                html += '<label class="custom-label">' + $(this).html() + '</label> ';
            } else if ((this.tagName==="SELECT")) {
                if ($(this).find("option:selected").html()) {
                    html += '<span>' + $(this).find("option:selected").html() + '</span><br>';
                } else {
                    html += '<span>-</span><br>';
                }
            } else if (this.tagName==="INPUT") {
                if (this.value.length>0) {
                    html += '<span>' + this.value + '</span><br>';
                } else {
                    html += '<span>-</span><br>';
                }
            }
            data[this.id] = this.value;
        });

        html += "<input type='hidden' id='student_education' name='student_education[]' value='" + escapeHtmlEntities($.toJSON(data)) + "'>";
        $("div[id=education-saved]").css("display", "block");
        $("div[id=education_edit]").css("display", "none");
        $("#educButton").css("display", "block");
        html += '</div>';
        $("div[id=educations]").append(html);
    }

    $(document).ready(function() {
        $("select#dealer").select2({
            language: "uk",
            dropdownAutoWidth: false
        });
        /*$("select#dealer").select2({
         createSearchChoice:function(term, data) { if ($(data).filter(function() { return this.text.localeCompare(term)===0; }).length===0) {return {id:term, text:term};} },
         });*/

        $(".chosen-select").chosen({disable_search_threshold: 10});
        // Скрыть блок с должностями. Скрывать его сразу нельзя, т.к. тогда не отрабатывает chosen
        $("#post-edit").hide();
        jQuery.validator.setDefaults({
            lang: 'uk'
        });
        $("#studentForm").validate({
            errorLabelContainer: "#NotValid",
            wrapper: "li",
            rules: {

            }
        });
    });
    </script>
{% else %}
    <div class="alert alert-danger" role="alert" id="NotValid">
        <H5>{{trans._('student_not_found')}}</H5>
    </div>
{% endif %}
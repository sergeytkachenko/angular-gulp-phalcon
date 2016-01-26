<div class="alert alert-danger" role="alert" id="NoCode" style="display: none;"></div>
<form class="form-inline" id="INNForm" method="GET" action="add">
    <div class="input-append">
        <input type="number" name="ind_code" id="ind_code" class="form-control" placeholder="{{trans._('ptn')}}" minlength="10"
               maxlength="10"
               sizeh="10" min="0" max="9999999996" required>
        <span class="input-group-btn">
            <button class="btn btn-primary" type="submit">{{trans._('further')}}</button>
        </span>
    </div>
</form>

<script>
    $(document).ready(function() {
        $.validator.addMethod("correctINN", function(value, element) {
            //Далее следует алгоритм проверки корректности ИНН по данным Википедии
            var x = (value.toString()[0]) * (-1) + (value.toString()[1]) * (5) + (value.toString()[2]) * (7) + (value.toString()[3]) * (9) + (value.toString()[4]) * (4) + (value.toString()[5]) * (6) + (value.toString()[6]) * (10) + (value.toString()[7]) * (5) + (value.toString()[8]) * (7);
            x = (x % 11) % 10;
            if (x!=(value.toString()[9])) {console.log("The last INN number must to be " + x);}
            return (x==(value.toString()[9]));
        }, "{{trans._('wrong_ptn')}}");

        jQuery.validator.setDefaults({
            lang: 'uk'
        });
    });

    $("#INNForm").validate({
        errorLabelContainer: "#NoCode",
        wrapper: "li",
        rules: {
            ind_code: {
                correctINN: true,
                required: true,
                remote: {
                    type: "GET",
                    url: "/crud/students/checkIPN",
                    cache: false,
                    data: {
                        ind_code: function() { return $("#ind_code").val(); }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(jqXHR.status);
                        console.log(textStatus);
                        console.log(errorThrown);
                    },
                    dataFilter: function(data) {
                        if (data!=="false") {//Если такой студент не найден
                            return "\"{{trans._('exists_ptn')}} {{trans._('try')}}<a href='edit/" + JSON.parse(data).id + "'>{{trans._('to_edit')|lower}}</a> {{trans._('it')}}.\"";
                        } else {return true;} //То валидация должна пройти успешно
                    }
                }
            }
        }
    });
</script>
/**
 * Created by s.korzun on 19.03.15.
 */
jQuery(function($) {
    //Создание радио-кнопок-переключателей
    $('div.btn-group[data-toggle-name]').each(function() {
        var group   = $(this);
        var form    = group.parents('form').eq(0);
        var name    = group.attr('data-toggle-name');
        var hidden  = $('input[name="' + name + '"]', form);
        $('button', group).each(function(){
            var button = $(this);
            button.on('click', function(){
                hidden.val($(this).val());
            });
            if(button.val() == hidden.val()) {
                button.addClass('active');
            }
        });
    });

    //Выбор городов по области
    $("select[name=region_id]").on("change", function () {
        var select = this;
        var regionId = $(this).val();
        $.post("/crud/city/search?region_id="+regionId, function( data ) {
            $("select[name=city_id]").html("<option>завантаження...</option>");
            var html = "";
            $.each(data, function (key, city) {
                html += "<option value='"+city.id+"'>"+city.name+"</option>";
            });
            $("select[name=city_id]").html(html);
        });
    })
});

/**
 * @autor Sergey Tkachenko
 сортировка таблиц
 **/
$.fn.order = function () {
    $ (this).find("th[data-column]").each(function () {
        var locationOrderType = parse("order-type"),
            locationOrderColumn = parse("order-column");
        var append = '<i class="fa fa-sort-up" data-order-type="asc"></i><i class="fa fa-sort-desc" data-order-type="desc"></i>';
        var els = $(this).append(append);
        els.each(function () {
            var orderColumn = $(this).attr("data-column");
            if(locationOrderColumn == orderColumn) {
                $(this).find("i[data-order-type="+locationOrderType+"]").addClass("active");
            }
            var href = location.href;
            href = href.replace(/\&?order\-type=(asc|desc)/, "").replace(/\&?order\-column=[^&]+/, "");
            $(this).find(".fa-sort-up").on("click", function () {
                var orderType = $(this).attr("data-order-type");
                var path = location.search? href+"&order-column="+orderColumn+"&order-type="+orderType : href + "?order-column="+orderColumn+"&order-type="+orderType;
                location.href = path;
            })
            $(this).find(".fa-sort-desc").on("click", function () {
                var orderType = $(this).attr("data-order-type");
                var path = location.search? href+"&order-column="+orderColumn+"&order-type="+orderType : href + "?order-column="+orderColumn+"&order-type="+orderType;
                location.href = path;
            })
        })
    });
}

function parse (val) {
    var result = "Not found",
        tmp = [];
    location.search
        //.replace ( "?", "" )
        // this is better, there might be a question mark inside
        .substr(1)
        .split("&")
        .forEach(function (item) {
            tmp = item.split("=");
            if (tmp[0] === val) result = decodeURIComponent(tmp[1]);
        });
    return result;
}
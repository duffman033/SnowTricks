(function () {
    $("#showMoreOffsetComments").val(10); //Init display card

    $(".loadmore-comments").click(function () {
        var offset = $("#showMoreOffsetComments").val();
        var trick = $("#trickId").val();
        var path = $(this).attr('data-href');
        $.ajax({
            type: 'POST',
            url: path,
            data: {
                offset: offset,
                trick: trick
            },
            success: function (data) {
                //Display comment
                for (var i = 0; i < data.length; i++) {
                    var html = "";

                    html += '<p>Test</p>';

                    $("#list-comments").append(html);
                }

                $(".loadmore-comments").hide();
            },
            error: function (data) {
                alert("error " + data);
            }
        });
    });

})();
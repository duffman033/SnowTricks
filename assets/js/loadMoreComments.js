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
                console.log(data)
                for (var i = 0; i < data.length; i++) {
                    var html = "";

                    html += '<li>';
                    html += '<div class="entry-comments-item">';
                    if (data[i]['avatar'] != null) {
                        html += '<img src="public/uploads/' + data[i]['avatar'] + '" class="entry-comments-avatar" alt="TestPseudo">';
                    } else {
                        html += '<i class="fas fa-user-circle fa-sm"></i>';
                    }
                    html += '<div class="entry-comments-body">';
                    html += '<span class="entry-comments-author"><p>' + data[i]['user'] + '</p></span>';
                    html += '<span class="comment-date">' + data[i]['created'] + '</span>';
                    html += '<p class="comment-content text-justify">' + data[i]['content'] + '</p>';
                    html += '</div>';
                    html += '</div>';
                    html += '</li>';

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
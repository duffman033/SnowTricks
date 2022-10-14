(function() {

    $(".alert").show();
    setTimeout(function() { $(".alert").fadeOut('slow'); }, 2000);

    $(function () {
        $("#loadMedia").on('click', function (e) {
            e.preventDefault();
            $("div.load-media").removeClass('d-none');
            $("#loadMedia").addClass('d-none');
            $("#hideMedia").removeClass('d-none');
        });
        $("#hideMedia").on('click', function (e) {
            e.preventDefault();
            $("div.load-media").addClass('d-none');
            $("#loadMedia").removeClass('d-none');
            $("#hideMedia").addClass('d-none');
        });

    });


    $(function () {
        $(window).scroll(function() {
            if ($(this).scrollTop() - 200 > 0) {
                $('#to-top').stop().slideDown('fast'); // show the button
                $('#to-down').stop().slideUp('fast');
            } else {
                $('#to-top').stop().slideUp('fast'); // hide the button
                $('#to-down').stop().slideDown('fast');
            }
        });
    });


    $(function () {
        $("#to-top").on("click", function () {
            $("html, body").animate({
                scrollTop: 0
            }, 200);
        });
    });

})()
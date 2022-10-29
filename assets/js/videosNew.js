$(document).ready(function () {
    var $collectionHolderVideo;
    var $newLinkLiVideo = $('#trickVideos');

    $collectionHolderVideo = $('#trickVideos');

    $addTagButtonVideo = $('#addVideoUpload');

    $addTagButtonVideo.on('click', function (e) {
        // add a new tag form (see next code block)
        addTagForm($collectionHolderVideo, $newLinkLiVideo);
    });

    var initialVideosIndex = 0;

    function addTagForm($collectionHolder, $newLinkLi) {

        $('#trickVideos').data('index', initialVideosIndex + $('#trickVideos').find(':input').length);
        // Get the data-prototype explained earlier
        var prototype = $collectionHolder.data('prototype');
        // get the new index
        var index = $collectionHolder.data('widget-counter') || $collectionHolder.children().length;

        var newForm = prototype;

        // Replace '__name__' in the prototype's HTML to
        // instead be a number based on how many items we have
        newForm = newForm.replace(/__name__/g, index) + "<hr/>";

        // increase the index with one for the next item
        $collectionHolder.data('index', index + 1);

        // Display the form in the page in an li, before the "Add a tag" link li
        var $newFormLi = $('<div></div>').append(newForm);
        $newLinkLi.append($newFormLi);
    }

    $(document).on('click', '.deleteVideo', function (e) {
        $(this).parent().parent().remove();
    });
});
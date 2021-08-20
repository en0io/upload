$(document).ready(function () {
    $("#uploader").on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            xhr: function () {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function (evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = ((evt.loaded / evt.total) * 100);
                        $(".progress-bar").width(percentComplete + '%');
                        $(".progress-bar").html(percentComplete + '%');
                    }
                }, false);
                return xhr;
            },
            type: 'POST',
            url: 'upload',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $(".progress-bar").width('0%');
                $(".progress-bar").show();

                $('#uploadStatus').html('');
            },
            error: function () {
                $('#uploadStatus').html('<p style="color:#EA4335;">File upload failed, please try again.</p>');
            },
            success: function (resp) {
                if (resp == 'ok') {
                    $('#uploader')[0].reset();
                    $('#uploadStatus').html('<p style="color:#28A74B;">File has uploaded successfully!</p>');
                    location.reload();

                } else if (resp == 'err') {
                    $('#uploadStatus').html('<p style="color:#EA4335;">Please select a valid file to upload.</p>');
                }
            }
        });
    });
});

$(".copylink").click(function () {
    navigator.clipboard.writeText($(this).data('url'));
});

jQuery(document).ready(function ($) {
    $('#commentform').attr('enctype', "multipart/form-data");

    $('#do_uploadFile').click(function () {
        $('#ywar-uploadFile').click();
    })

    $('#ywar-uploadFile').on('change', function () {
        var input = document.getElementById("ywar-uploadFile");
        if ((attach.limit_multiple_upload > 0) && (input.files.length > attach.limit_multiple_upload)) {
            alert('Too many files selected.');
            this.value = '';
            return;
        }

        var ul = document.getElementById("uploadFileList");
        var preview_image = function (files, index) {
            var oFReader = new FileReader();
            oFReader.readAsDataURL(files[index]);

            oFReader.onload = function (oFREvent) {
                document.getElementById("img_preview" + index).src = oFREvent.target.result;
            };
        };

        while (ul.hasChildNodes()) {
            ul.removeChild(ul.firstChild);
        }
        for (var i = 0; i < input.files.length; i++) {
            var li = document.createElement("li");
            li.innerHTML = '<div style="display: inline;"><img id="img_preview' + i + '" style="width: 100px; height: 100px;"></div>';
            preview_image(input.files, i);
            ul.appendChild(li);
        }
        if (!ul.hasChildNodes()) {
            var li = document.createElement("li");
            li.innerHTML = 'No Files Selected';
            ul.appendChild(li);
        }
    });

    // Prevent submission if limit is exceeded.
    $('#commentform').submit(function () {
        var input = document.getElementById("ywar-uploadFile");
        if ((attach.limit_multiple_upload > 0) && (input.files.length > attach.limit_multiple_upload))
            return false;
    });
});


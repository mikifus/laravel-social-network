Dropzone.autoDiscover = false;

function setConfirmUnload(fn) {
  window.onbeforeunload = fn;
}

$(function(){
    window._images_dropzone = $("#images_dropzone").dropzone({
    uploadMultiple: false,
    autoProcessQueue: false,
    parallelUploads: 100,
    maxFilesize: 10,
    acceptedFiles: 'image/*',
    previewsContainer: '#dropzonePreview',
    previewTemplate: document.querySelector('#preview-template').innerHTML,
    addRemoveLinks: false,
    dictRemoveFile: 'Remove',//TODO: Translation
    dictFileTooBig: 'Image is bigger than 10MB',//TODO: Translation

    // The setting up of the dropzone
    init:function() {

        var myDropzone = this;

        this.on("addedfile", function(file) {
            setConfirmUnload(function(){
                //TODO: Translation
                return "Not all files have been uploaded. Do you want to go?";
            });
            $("#submit_all").show();
        });

        this.on("queuecomplete", function(file) {
            setConfirmUnload(null);
        });

        $("#submit_all").click(function(e) {
            // Make sure that the form isn't actually being sent.
            e.preventDefault();
            e.stopPropagation();
            myDropzone.processQueue();
        });
    },
    accept: function(file, done){
        // Default trigger won't occur, so a manual call is needed
        $(window._images_dropzone).trigger('addedfile', [file]);
        done();
    },
    sending: function(file, xhr, formData) {
//       var value = $(file.previewElement.querySelectorAll("[data-dz-extrafields]"))
//         .find("input[name=title_input]").val();

        var extrafields = $( file.previewElement.querySelectorAll("[data-dz-extrafields]") );

        var fields = extrafields.find("input");
        $.each(fields, function( index, field ) {
            formData.append($(field).attr('name'), $(field).val());
        });
      var album_id = $('select[name=main_imagealbum_id]').val() || null;
      var album_title = $('input[name=main_imagealbum_title]').val();

//       formData.append("title", value); // Append all the additional input data of your form here!
      if (album_id) {
        formData.append("imagealbum_id", album_id);
      }
      if (album_title) {
        formData.append("imagealbum_title", album_title);
      }
    },
    error: function(file, response) {
        if($.type(response) === "string")
            var message = response; //dropzone sends it's own error messages in string
        else
            var message = response.message;
        file.previewElement.classList.add("dz-error");
        _ref = file.previewElement.querySelectorAll("[data-dz-errormessage]");
        _results = [];
        for (_i = 0, _len = _ref.length; _i < _len; _i++) {
            node = _ref[_i];
            _results.push(node.textContent = message);
        }
        $( file.previewElement.querySelectorAll("[data-dz-extrafields]") ).hide();
        return _results;
    },
    success: function(file,done) {
        file.previewElement.classList.add("dz-success");
        $( file.previewElement.querySelectorAll("[data-dz-extrafields]") ).hide();
        $( file.previewElement.querySelectorAll("[data-dz-remove]") ).hide();
    }
});
});
//};
//Dropzone.options.trackDropzone = {

$(function(){
    window._tracks_dropzone = $("#tracks_dropzone").dropzone({
//    url: utils.url.base_url("tracks/add"),
    uploadMultiple: false,
    autoProcessQueue: false,
    parallelUploads: 100,
    maxFilesize: 20,
    acceptedFiles: 'audio/mp3',
    previewsContainer: '#dropzonePreview',
    previewTemplate: document.querySelector('#preview-template').innerHTML,
    addRemoveLinks: false,
    dictRemoveFile: 'Remove',//TODO: Translation
    dictFileTooBig: 'file is bigger than 20MB',//TODO: Translation

    // The setting up of the dropzone
    init:function() {

        var myDropzone = this;

        this.on("addedfile", function(file) {
            setConfirmUnload(function(){
                //TODO: Translation
                return "Not all files have been uploaded. Do you want to go?";
            });
            $("#submit_all").show();
            // Check jsvalidation
            var extrafields = $( file.previewElement.querySelectorAll("[data-dz-extrafields]") );
            extrafields.find('.tracks_inside_form').validate(window._jsvalidator_rules[".tracks_inside_form"]);
        });

        this.on("thumbnail", function(file, dataUrl) {
            var url = dataUrl;
        });

        this.on("queuecomplete", function(file) {
            setConfirmUnload(null);
        });

        // First change the button to actually tell Dropzone to process the queue.
        $("#submit_all").click(function(e) {
            // Make sure that the form isn't actually being sent.
            e.preventDefault();
            e.stopPropagation();
            if( $('.tracks_inside_form').valid() )
            {
                myDropzone.processQueue();
            }
        });
    },
    error: function(file, response) {
        if($.type(response) === "string")
            var message = response; //dropzone sends it's own error messages in string
        else
            var message = response.message;
        file.previewElement.classList.add("dz-error");
        _ref = file.previewElement.querySelectorAll("[data-dz-errormessage]");
        _results = [];
        for (_i = 0, _len = _ref.length; _i < _len; _i++) {
            node = _ref[_i];
            _results.push(node.textContent = message);
        }
        $( file.previewElement.querySelectorAll("[data-dz-extrafields]") ).hide();
        // TODO: Retry button for the failed uploads
        return _results;
    },
    success: function(file,done) {
        file.previewElement.classList.add("dz-success");
        $( file.previewElement.querySelectorAll("[data-dz-extrafields]") ).hide();
        $( file.previewElement.querySelectorAll("[data-dz-remove]") ).hide();
    },
    sending: function(file, xhr, formData) {
        var extrafields = $( file.previewElement.querySelectorAll("[data-dz-extrafields]") );

        var fields = extrafields.find("input,select");
        $.each(fields, function( index, field ) {
            formData.append($(field).attr('name'), $(field).val());
        });
    },
    accept: function(file, done){
        var that = this;
        // Prepare elements
        var extrafields = $( file.previewElement.querySelectorAll("[data-dz-extrafields]") );
        var audio_preview = $("<audio controls >");

        // Create reader
        reader = new FileReader();

        // Set reader callback
        reader.onloadend = function () {
            // Show the preview
            audio_preview.attr('src', reader.result);
            $( file.previewElement.querySelectorAll(".dz-audio-preview") ).append(audio_preview);

            // Read media tags
            window.jsmediatags.read(file, {
                onSuccess: function(info) {
                    var tags = info.tags;
                    extrafields.find("input[name=title]").val(tags.title);
                    extrafields.find("input[name=author]").val(tags.artist);
                    if( tags.comment ) {
                        extrafields.find("textarea[name=description]").val(tags.comment.text);
                    }
                    
                    // Default trigger won't occur, so a manual call is needed
                    $(window._tracks_dropzone).trigger('addedfile', [file]);
                },
                onError: function(error) {
                  console.log(error);
                }
            });
        };

        // read the file
        reader.readAsDataURL(file);

        done();
    }
});
});
//};
$(function(){
    var musicalbums_dropzone = function( preview_selector ){
        function removeFileFromDatabase() {
            var data = {};
            switch(preview_selector)
            {
                case '#front_preview':
                    data['cover'] = 'front';
                    break;
                case '#back_preview':
                    data['cover'] = 'back';
                    break;
            }
            var url = $(preview_selector).find('.dz-remove>a').attr('href');
            $.ajax({
                type: 'POST',
                url: url,
                data: data,
                dataType: 'json'
            });
        }
        return {
            maxFiles: 1,
            uploadMultiple: false,
            autoProcessQueue: true,
            parallelUploads: 1,
            maxFilesize: 20,
            acceptedFiles: 'image/*',
            previewsContainer: preview_selector,
            previewTemplate: document.querySelector('#preview-template').innerHTML,
            addRemoveLinks: false,
            dictRemoveFile: 'Remove',//TODO: Translation
            dictFileTooBig: 'file is bigger than 20MB',//TODO: Translation
            thumbnailWidth: 120,
            thumbnailHeight: 120,

           // The setting up of the dropzone
           init:function() {

                var myDropzone = this;

                this.on("addedfile", function(file) {
                });

                this.on("maxfilesexceeded", function(file) {
                      this.removeAllFiles();
                      this.addFile(file);
                });

                $(preview_selector).find('.default_remove').click(function(e){
                    e.preventDefault();
                    removeFileFromDatabase();
                    $(preview_selector).find('.default_preview').remove();
                });
           },
            sending: function(file, xhr, formData) {
                $(preview_selector).find('.default_preview').remove();

                switch(preview_selector)
                {
                    case '#front_preview':
                        formData.append("cover", 'front');
                        break;
                    case '#back_preview':
                        formData.append("cover", 'back');
                        break;
                }
            },
           error: function(file, response) {
               if($.type(response) === "string")
                   var message = response; //dropzone sends it's own error messages in string
               else
                   var message = response.message;
               file.previewElement.classList.add("dz-error");
               _ref = file.previewElement.querySelectorAll("[data-dz-errormessage]");
               _results = [];
               for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                   node = _ref[_i];
                   _results.push(node.textContent = message);
               }
               $( file.previewElement.querySelectorAll("[data-dz-extrafields]") ).hide();
               return _results;
           },
           removedfile: function(file) {
               removeFileFromDatabase();
                var _ref;
                return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
            }
       }
    };
    window._musicalbums_dropzone_front = $("#front_dropzone").dropzone(musicalbums_dropzone('#front_preview'));
    window._musicalbums_dropzone_back  = $("#back_dropzone").dropzone(musicalbums_dropzone('#back_preview'));
});
//};

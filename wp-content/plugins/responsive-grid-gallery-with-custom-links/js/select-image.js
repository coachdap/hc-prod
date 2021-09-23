jQuery(document).ready(function($){

    var custom_uploader;
    //console.log(abcfrggcl_si.selectButton); abcfrggcl_si.btnImgL

    //btn ID
    $(abcfrggcl_si.btnImg).click(function(e) {

        e.preventDefault();

        //console.log(abcfrggcl_si.btnImgL);

        //If the uploader object has already been created, reopen the dialog
        if (custom_uploader) {
            custom_uploader.open();
            return;
        }

        //Extend the wp.media object
        custom_uploader = wp.media.frames.file_frame = wp.media({
            //title: abcfrggcl_si.title,
            button: { text:  abcfrggcl_si.button },
            library: { type: 'image' },
            frame:    'select',
            state:   'mystate'
        });

        custom_uploader.states.add([
          new wp.media.controller.Library({
            id: 'mystate',
            title: abcfrggcl_si.title,
            priority: 20,
            toolbar: 'select',
            filterable: 'uploaded',
            library: wp.media.query( custom_uploader.options.library ),
            multiple: false,
            editable: false,
            displayUserSettings: false,
            displaySettings: true,
            allowLocalEdits: true
          })
        ]);

        //When a file is selected, grab the URL and set it as the text field's value
        custom_uploader.on('select', function() {
            var attachment = custom_uploader.state().get('selection').first().toJSON();

            //$(gtm_marker_img.urlTxt).val(attachment.url);
            //var media_thumbnail = media_attachment.sizes.thumbnail.url;
            //
            //var selectedSizeUrl = attachment.sizes[$('select[name="size"]').val()].url;
            //console.log(selectedSizeUrl);
            //$(gtm_marker_img.urlTxt).val(selectedSizeUrl);

            console.log(attachment.id);

            $(abcfrggcl_si.imgUrl).val(attachment.sizes[$('select[name="size"]').val()].url);
            $(abcfrggcl_si.imgID).val(attachment.id);
            //var media_thumbnail = media_attachment.sizes.thumbnail.url;
        });

        //Open the uploader dialog
        custom_uploader.open();
    });

});
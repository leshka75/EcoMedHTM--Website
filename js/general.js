$(document).ready(function(){
    jQuery('#camera_wrap').camera({
        loader: false,
        pagination: true,
        minHeight: '250',
        thumbnails: false,
        height: '235px',
        caption: true,
        navigation: false,
        fx: 'mosaic'
    });
});
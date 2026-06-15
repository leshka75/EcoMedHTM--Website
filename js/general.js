$(document).ready(function(){
    // Build badge — branch + version + timestamp injected by stamp.js on every commit
    if(window.__BUILD__){
        var b=window.__BUILD__;
        var label=b.branch+(b.version?' · '+b.version:'')+' · '+b.time;
        var nav=document.getElementById('build-badge-nav');
        var foot=document.getElementById('build-badge-footer');
        if(nav&&b.branch!=='main') nav.innerHTML='<span class="build-pill">'+label+'</span>';
        if(foot) foot.textContent=label;
    }

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
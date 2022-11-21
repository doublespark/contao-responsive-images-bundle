(function(){
    $(document).ready(function(){

        // Get the window object
        var windowObj = $(window);

        // Detect if the user is on a retina device
        var retina = window.devicePixelRatio > 1;

        // Get the images
        var images = $('img.respond');

        if(images.length > 0)
        {
            // Set the images on load
            var w = windowObj.width();
            updateImages(images, w, retina);

            // Set the images on resize
            windowObj.resize(function(){
                var w = windowObj.width();
                updateImages(images, w, retina);
            });
        }
    });

    /**
     * Adjust images
     */
    function updateImages(images, window_width, retina)
    {
        images.each(function(i, img){

            // Get the current size
            var currentSize = img.getAttribute('data-size');

            if(window_width <= window.responsiveBreakPoints.tablet && currentSize != 'mobile')
            {
                img.setAttribute('src', img.getAttribute('data-mobile'));
                img.setAttribute('data-size', 'mobile');
                return;
            }

            if(window_width <= window.responsiveBreakPoints.desktop && window_width > window.responsiveBreakPoints.tablet && currentSize != 'tablet')
            {
                img.setAttribute('src', img.getAttribute('data-tablet'));
                img.setAttribute('data-size', 'tablet');
                return;
            }

            if(window_width > window.responsiveBreakPoints.desktop && window_width < window.responsiveBreakPoints.large && currentSize != 'desktop')
            {
                img.setAttribute('src', img.getAttribute('data-desktop'));
                img.setAttribute('data-size', 'desktop');
                return;
            }

            if(window_width > window.responsiveBreakPoints.large && currentSize != 'large')
            {
                img.setAttribute('src', img.getAttribute('data-large'));
                img.setAttribute('data-size', 'large');
                return;
            }

        });
    }

})();
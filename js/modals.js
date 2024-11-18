(function ($) {
    $(document).ready(function () {
        $modal = $('.modal')
        $contact = $('.modal__contact')
        $lightbox = $('.modal__lightbox')

        function openModal(type) {
            $modal.addClass('modal--open')
            if(type === "contact") {
                $contact.addClass('modal__contact--selected')
            } else if(type === "lightbox") {
                $lightbox.addClass('modal__lightbox--selected')
            } else {
                $modal.removeClass('modal--open')
            }
        }

        // Open contact modal with main menu
        $('.menu-item-contact').on('click', function(e) {
            e.preventDefault()
            openModal('contact')
        })

        // Open contact modal on photo details
        $('.btn-contact').on('click', function(e) {
            e.preventDefault()
            $ref = $(this).attr('data-photo')
            $('.wpcf7-text[name=photo-ref]').val($ref)
            openModal('contact')
        })

        // Open lightbox modal on photo list
        $('.listed-photo__infos__fullscreen').on('click', function(e) {
            e.preventDefault()
            $ref = $(this).attr('href')
            openModal('lightbox')
        })

        // Close the modal
        $modal.on('click', function(e) {
            $modal.addClass('modal--close')
            $modal.removeClass('modal--open')
            setTimeout(() => {
                $modal.removeClass('modal--close')
                $contact.removeClass('modal__contact--selected')
                $lightbox.removeClass('modal__lightbox--selected')
            }, 500)

        })
        // Don't close if click on modal
        $('.modal__contact').on('click', function(e) {e.stopPropagation()})
        $('.modal__lightbox').on('click', function(e) {e.stopPropagation()})
    })
})(jQuery)
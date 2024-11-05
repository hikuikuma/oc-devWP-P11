jQuery(document).ready(function($) {
    $modal = $('.modal')
    $contact = $('.modal__contact')
    $lightbox = $('.modal__lightbox')

    $('.menu-item-contact').on('click', function(e) {
        e.preventDefault()
        $modal.addClass('modal--open')
        $contact.addClass('modal__contact--selected')
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
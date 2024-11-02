jQuery(document).ready(function($) {
    $contact = $('.contact')
    $('.menu-item-contact').on('click', function(e) {
        e.preventDefault()
        $contact.addClass('open')
    })

    $contact.on('click', function(e) {
        $contact.addClass('close')
        $contact.removeClass('open')
        setTimeout(() => $contact.removeClass('close'), 500)

    })
    $('.contact__modal').on('click', function(e) {
        e.stopPropagation()
    })
})
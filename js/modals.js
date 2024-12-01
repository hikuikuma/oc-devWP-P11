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
            if( $('.navbar').hasClass('open') ) {
                $('.navbar').removeClass('open')
                $('.burger-menu').removeClass('toggled')
            }
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
            const photoID = $(this).attr('data-id')
            openLightBox(photoID, $(this))
        })

        // Change photo on lightbox
        $('.lightbox__nav').on('click', function(e) {
            e.preventDefault()
            const photoID = $(this).attr('data-id')
            $('.lightbox__media__photo').remove()
            $('.infos__reference').text('Référence de la photo')
            $('.infos__categorie').text('Catégorie')
            openLightBox(photoID, $(this))
        })

        // Lightbox opener
        function openLightBox(photoID, eventFrom = null) {
            if ( eventFrom === null ) {
                alert(`Erreur dans l'ouverture de la lightbox`)
                console.log(eventFrom)
            }
            const image = eventFrom
            const list = $('.photos-list__list')
            openModal('lightbox')

            const ajaxURL = image.attr('href')
            const data = {
                action: image.attr('data-action'),
                nonce:  image.attr('data-nonce'),
                ref: image.attr('data-ref'),
                id: image.attr('data-id'),
                paging: list.attr('data-paging'),
                categorie: list.attr('data-categorie'),
                format: list.attr('data-format'),
                order: list.attr('data-order'),
            }

            $.ajax({
                "type": 'POST',
                "url": ajaxURL,
                "dataType": 'json',
                "data": data,
                "headers": {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'Cache-Control': 'no-cache',
                },
                "success": function (response) {
                    $('.lightbox__media__photo').remove()
                    $('.infos__reference').text(response.data.post.ref)
                    $('.infos__categorie').text(response.data.post.category)
                    $('#previousLightbox').attr('data-id', response.data.post.previous)
                    $('#nextLightbox').attr('data-id', response.data.post.next)
                    let classes = "lightbox__media__photo"
                    $('.lightbox__media').prepend(`<img class="${classes}" src="${response.data.post.image}">`)
                },
                "error": function (xhr, status, error) {
                    console.log(xhr.responseText)
                }
            })
        }

        const target = document.querySelector('.photos-list__list')
        const observer = new MutationObserver(function (mutations) {
            $('.listed-photo__infos__fullscreen').on('click', function(e) {
                e.preventDefault()
                const ref = $(this).attr('data-ref')
                openLightBox(ref, $(this))
            })
        })
        observer.observe(target, {
            attributes: true,
            childList: true,
            characterData: true
        })


        // Close the modal
        function closeModals() {
            $modal.addClass('modal--close')
            $modal.removeClass('modal--open')
            setTimeout(() => {
                $modal.removeClass('modal--close')
                $contact.removeClass('modal__contact--selected')
                $lightbox.removeClass('modal__lightbox--selected')
                $('.lightbox__media__photo').remove()
            }, 500)
        }
        $modal.on('click', closeModals )
        $('modal__lightbox__closer').on('click', closeModals )

        // Don't close if click on modal
        $('.modal__contact').on('click', function(e) {e.stopPropagation()})
        $('.modal__lightbox__content').on('click', function(e) {e.stopPropagation()})
    })
})(jQuery)

(function ($) {
    $(document).ready(function () {
        //********************
        // Load more button
        //********************
        $('.photos-list__more-button').on('click', function(e) {
            e.preventDefault();
            const photoList = $('.photos-list__list')
            const loadMoreButton = $(this)
            const ajaxURL = $(this).data('ajaxurl');
            const data = {
                action: $(this).attr('data-action'),
                nonce:  $(this).attr('data-nonce'),
                categorie: $(this).attr('data-categorie'),
                format: $(this).attr('data-format'),
                paging: $(this).attr('data-paging'),
                loaded: $(this).attr('data-loaded'),
                order: $(this).attr('data-order'),
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
                    photoList.append(response.data.posts)
                    const total =  response.data.values.total
                    const loaded = response.data.values.loaded
                    if( total > loaded ){
                        $('.photos-list__load-more').show()
                        $('.photos-list__more-button').attr('data-loaded', loaded)
                    } else {
                        $('.photos-list__load-more').hide()
                    }
                },
                "error": function (xhr, status, error) {
                    console.log(xhr.responseText)
                }
            })
        })


        //********************
        // Filters and sorters
        //********************
        $('.dropdown__menu__item').on('click', function(e) {
            e.preventDefault()
            
            const photoList = $('.photos-list__list')
            const itemMenu = $(this)
            const dropdownButton = itemMenu.parent().siblings('.dropdown__toggle')

            const paging = photoList.attr('data-paging')
            const thisFilter = itemMenu.attr('data-filter')
            const nonce = itemMenu.attr('data-nonce')
            let format = photoList.attr('data-format')
            let categorie = photoList.attr('data-categorie')
            let order = photoList.attr('data-order')
            let action = itemMenu.attr('data-action')

            // Filter already applied, we remove the filter
            if( itemMenu.hasClass('selected') ) {
                itemMenu.toggleClass('selected')
                if( action === 'motaphoto_filter_categories' ) {
                    categorie = ''
                    photoList.attr('data-categorie', categorie)
                    const value = dropdownButton.attr('data-name')
                    dropdownButton.html(value)
                } else if( action === 'motaphoto_filter_formats' ) {
                    format = ''
                    photoList.attr('data-format', format)
                    const value = dropdownButton.attr('data-name')
                    dropdownButton.html(value)
                } else if( action === 'motaphoto_sorter' ) {
                    order = 'id-asc'
                    photoList.attr('data-order', order)
                    const value = dropdownButton.attr('data-name')
                    dropdownButton.html(value)
                }
            }
            // Filter not applied, it will be applied by removing a filter of the same type if it exists
            else {
                itemMenu.siblings('.selected').removeClass('selected') // Remove other selected item on same menu
                itemMenu.addClass('selected') // Selected current item

                // Change value of dropdown button
                const value = itemMenu.html()
                dropdownButton.html(value)

                // Closing the dropdown
                itemMenu.parent().removeClass('show')
                dropdownButton.removeClass('active')

                // Retrieving changing value
                if( action === 'motaphoto_filter_categories' ) {
                    categorie = thisFilter
                    photoList.attr('data-categorie', categorie)
                }
                if( action === 'motaphoto_filter_formats' ) {
                    format = thisFilter
                    photoList.attr('data-format', format)
                }
                if( action === 'motaphoto_sorter' ) {
                    order = thisFilter
                    photoList.attr('data-order', order)
                }
            }

            const ajaxURL = itemMenu.attr('data-ajaxurl');
            const data = {
                action: action,
                nonce:  nonce,
                order: order,
                format: format,
                categorie: categorie,
                paging: paging
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
                    if( !response.success ) {
                        alert(response.data)
                        return
                    }
                    photoList.html(response.data.posts)
                    const categorie = response.data.values.categorie
                    const format = response.data.values.format
                    const order = response.data.values.order
                    const total =  response.data.values.total
                    if( total > response.data.values.paging ){
                        $('.photos-list__load-more').show()
                        $('.photos-list__more-button').attr('data-categorie', categorie)
                        $('.photos-list__more-button').attr('data-format', format)
                        $('.photos-list__more-button').attr('data-order', order)
                        $('.photos-list__list').attr('data-total', total)
                    } else {
                        $('.photos-list__load-more').hide()
                    }
                },
                "error": function (xhr, status, error) {
                    console.log(xhr.responseText)
                }
            })
        })

        //********************
        // Dropdowns menus
        //********************
        $('.dropdown__toggle').on('click', function(e) {
            dd_ID = $(this).attr('id')
            if ($(this).hasClass('active')) {} else {
                $('.dropdown__toggle').each(function() { $(this).removeClass('active') } )
                $('.dropdown__menu').each(function() { $(this).removeClass('show') } )
            }
            $(this).toggleClass('active')
            $(`.dropdown__menu[aria-labelledby=${dd_ID}]`).toggleClass('show')
        })

    });
})(jQuery);

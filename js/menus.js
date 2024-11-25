(function ($) {
    $(document).ready(function () {

        $('.burger-menu').on('click', function (e) {
            e.preventDefault()
            $(this).toggleClass('toggled')
            $('.navbar').toggleClass('open')
        })

    })
})(jQuery)

$(document).ready(function(){
    $('.add-line').on('click', function(e) {
        e.preventDefault()

        var count = $('.env-line').length
        var key = $('.env-line-form').find('.line-key').val()
        var value = $('.env-line-form').find('.line-value').val()

        $('.env-line-form').find('.line-key').val('')
        $('.env-line-form').find('.line-value').val('')

        var tpl = $('#env-line-template').clone(true)

        $(tpl).removeAttr('id').addClass('env-line')

        $(tpl).find('.line-key').val(key.trim().toLocaleUpperCase())
        $(tpl).find('.line-key').attr('name', 'lines['+ count +'][key]')

        $(tpl).find('.line-value').val(value.trim())
        $(tpl).find('.line-value').attr('name', 'lines['+ count +'][value]')

        $(tpl).prependTo($('.env-line-container')).show()
    })

    $('.delete-line').on('click', function(e) {
        e.preventDefault();

        var key = $(this).parents('.env-line').find('.line-key').val();
        $(this).parents('.env-line').remove();

        if ($('#remove-key-tpl').length < 1) {
            return;
        }

        var tpl = $('#remove-key-tpl').clone(true)

        $(tpl).attr("name", "remove_key[]")
        $(tpl).removeAttr("id")
        $(tpl).appendTo('.remove-key-container')
        $(tpl).val(key)

    })
})

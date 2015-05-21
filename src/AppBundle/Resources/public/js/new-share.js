$(document).ready(function () {


    function format(repo) {
        if (repo.loading) return 'поиск...';

        var markup = '<div class="item_sel" data-symbol="' + repo.symbol + '">' + repo.name + '</div>';

        return markup;
    }

    function formatSelection(repo) {
        return repo.name || repo.text;
    }

    $(".js-data-ajax").select2({
        ajax: {
            url: url + 'shares/api/get-name',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term
                };
            },
            processResults: function (data) {
                return {
                    results: data.ResultSet.Result
                };
            },
            cache: false
        },
        escapeMarkup: function (markup) {
            return markup;
        },
        minimumInputLength: 1,
        templateResult: format,
        templateSelection: formatSelection
    });

    $('body').on('click', '.item_sel', function () {
        var text = $(this).text(),
            symbol = $(this).attr('data-symbol');
        $('.js-data-ajax').val(text).trigger("change").select2("close");
        $('.select2-selection__rendered').text(text);
        $('input#appbundle_share_name').val(symbol);
        $('input#appbundle_share_fullName').val(text);
        $('#submit_form').attr('disabled', false);
    });

    $('#submit_form').click(function () {
        if ($('input#appbundle_share_name').val())
            $('form').submit();
        else
            alert('Требуется выбрать акцию!');
    });
});
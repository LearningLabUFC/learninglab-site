jQuery(document).ready(function($) {
    $('#filter-form').on('submit', function() {
        $(this).find('input, select').each(function() {
            if (!$(this).val()) {
                $(this).prop('disabled', true);
            }
        });
    });
});

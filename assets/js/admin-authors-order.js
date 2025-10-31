jQuery(document).ready(function($) {
    function updateAuthorOrderInput() {
        var ordered_ids = [];
        $('#selected-authors-list li').each(function() {
            ordered_ids.push($(this).data('id'));
        });
        $('#artigo_autores_order').val(ordered_ids.join(','));
    }

    if ($('#selected-authors-list').length > 0) {
        $('#selected-authors-list, #available-authors-list').sortable({
            connectWith: ".author-sort-list",
            placeholder: "ui-sortable-placeholder",
            receive: function(event, ui) {
                updateAuthorOrderInput();
            },
            stop: function(event, ui) {
                updateAuthorOrderInput();
            }
        }).disableSelection();
    }
});
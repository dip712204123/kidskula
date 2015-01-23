var tagsurl = $("#tags-url").val();
$(".select2tags").select2(
        {
            tags: true,
            tokenSeparators: [",", " "],
            minimumInputLength: 1,
            placeholder: 'Enter Tags',
            maximumSelectionSize: 10,
            closeOnSelect: true,
            multiple: true,
            ajax: {
                url: tagsurl,
                quietMillis: 100,
                dataType: 'json',
                data: function(term, page) {
                    return {
                        q: term
                    };
                },
                results: function(data, page) {

                    return {results: data};
                }
            }

        }
);

$("#save-question").click(function() {

    var cond = $("#form-question-sets").valid();
    if (cond) {
        $("#form-question-sets").submit();
    }

});

function geteditpopup(id) {
    var data = $('#tags-data-' + id).val();
    if (data != '') {
        var data = JSON.parse(data);
        $('#vet_supportbundle_vetcommCommunityQuestions_tags-' + id).select2('data', data);
    }

    $('#open-modal-feedcontent-edit-' + id).trigger('click');
}
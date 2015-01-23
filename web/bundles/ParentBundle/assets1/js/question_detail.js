var loader = '<i class="fa fa-fw fa-spinner fa-spin"></i> Loading Answers ...';
$("#anwer-content").html(loader);

$.ajax({
    url: $("#commenturl").val(),
    type: 'GET',
    success: function(html) {
        //alert(html);
        $("#anwer-content").html(html);
    }

});

function writeanswer(e) {
    var form = $(e).closest('form');
    var data = $(form).serialize();
	var articleId = $("#articleId").val();
	
	data = data + "&articleId="+articleId;
	//alert(data);
    var loader = '<i class="fa fa-fw fa-spinner fa-spin"></i> Saving your answer ...';
    $("#anwer-content").html(loader);
    $.ajax({
        url: $("#commenturl").val(),
        type: 'POST',
        data: data,
        success: function(html) {
			//alert(html);
            $("#anwer-content").html(html);
            $(form)[0].reset();
            $(".close").trigger('click');
        },
        error: function() {
            $("#anwer-content").html('Error loading answeres');
        }

    });


}

function replytoans(e) {
    var form = $(e).closest('form');
    var data = $(form).serialize();
	var articleId = $("#articleId").val();
	
	data = data + "&articleId="+articleId;
	//alert(data);
    // $("#close-reply").trigger('click');
    var loader = '<i class="fa fa-fw fa-spinner fa-spin"></i> Saving your answer ...';
    $(".modal-title").html(loader);
    $.ajax({
        url: $("#commenturl").val(),
        type: 'POST',
        data: data,
        success: function(html) {

            $(form)[0].reset();
            $("#close-reply").trigger('click').promise().done(function() {
                $("#anwer-content").html(html);
                $(".modal-backdrop").remove();
                $("body").removeClass('modal-open');
                $(".modal-title").html('');
            });



        },
        error: function() {
            $("#anwer-content").html('Error loading answeres');
        }

    });
}
function markanswere(id, status, e) {
    var temphtml = $(e).html();
    var loader = '<i class="fa fa-fw fa-spinner fa-spin"></i> Saving your choice ...';
    $(e).html(loader);
    $.ajax({
        url: $("#commenturl").val(),
        type: 'POST',
        data: {'answere_id': id, status: status},
        success: function(html) {

            $("#anwer-content").html(html);



        },
        error: function() {
            $(e).html('Error occurred');
        }

    });
}

function getupdatecomment(e, id) {
    var form = $(e).closest('form');
    var loader = '<i class="fa fa-fw fa-spinner fa-spin"></i> Saving ...';
    $(e).html(loader);
    if ($(form).valid()) {
        $.ajax({
            url: $("#commenturl").val(),
            type: 'POST',
            data: $(form).serialize(),
            success: function(html) {

                $("#anwer-content").html(html);



            },
            error: function() {
                $(e).html('Error occurred');
            }

        });
    }


}

function removecomment(e, id) {
    if (!confirm("Are you sure?")) {
        return false;
    }
    var loader = '<i class="fa fa-fw fa-spinner fa-spin"></i> Removing comment ...';
    $(e).html(loader);
    $.ajax({
        url: $("#commenturl").val(),
        type: 'POST',
        data: {remove: id},
        success: function(html) {

            $("#anwer-content").html(html);



        },
        error: function() {
            $(e).html('Error occurred');
        }

    });
}


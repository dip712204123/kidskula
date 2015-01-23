/*var loader = '<i class="fa fa-fw fa-spinner fa-spin"></i> Loading Answers ...';
$("#anwer-content").html(loader);
$.ajax({
    url: $("#commenturl").val(),
    type: 'GET',
    success: function(html) {
        //alert(html);
        $("#anwer-content").html(html);
    }

});*/

function writeanswer(e,articleid) {

    var form = $(e).closest('form');
    var data = $(form).serialize();
	var clubid = $("#clubid").val();
	
	data = data + "&clubid="+clubid;
	//alert(data);
    var loader = '<h2> Saving your answer ...</h2>';
    $("#anwer-content"+articleid).html(loader);
    $.ajax({
        url: $("#commenturl").val(),
        type: 'POST',
        data: data,
        success: function(html) {
			//alert(html);
            $("#anwer-content"+articleid).html(html);
            $(form)[0].reset();
            $(".close").trigger('click');
        },
        error: function() {
            $("#anwer-content"+articleid).html('<h2>Error loading answeres.</h2>');
        }
    });

}

function replytoans(e,articleid,parentid) {
    var form = $(e).closest('form');
    var data = $(form).serialize();
    var clubid = $("#clubid").val();
	
	data = data + "&clubid="+clubid;
    var loader = '<h2> Saving your answer ...</h2>';
    //$(".modal-title").html(loader);
    $.ajax({
        url: $("#commenturl").val(),
        type: 'POST',
        data: data,
        success: function(html) {
    
            $(form)[0].reset();
            //$("#close-reply").trigger('click').promise().done(function() {
                $("#anwer-content"+articleid).html(html);
                $("#comment-wallmessages-"+parentid).show('slow');
            //});
        },
        error: function() {
            $("#anwer-content").html('<h2>Error loading answeres.</h2>');
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

function removecomment(e, id,eventId) {
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
            $("#article_comments"+id).html("");
        },
        error: function() {
            $(e).html('Error occurred');
        }
    });
}


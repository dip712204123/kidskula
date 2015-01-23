jQuery(function($){

    // Create variables (in this scope) to hold the API and image size
    var jcrop_api,
        boundx,
        boundy,

        // Grab some information about the preview pane
        $preview = $('#preview-pane'),
        $pcnt = $('#preview-pane .preview-container'),
        $pimg = $('#preview-pane .preview-container img'),

        xsize = $pcnt.width(),
        ysize = $pcnt.height();
    
    //console.log('init',[xsize,ysize]);
	var db_x = $('#x').val();
	var db_y = $('#y').val();
	var db_img_width = $('#img_width').val();
	var db_img_height = $('#img_height').val();
	//updatePreview();
	
		
    $('#target').Jcrop({
	  bgFade: true,
      bgOpacity: .7,
      /*setSelect: [ 60, 70, 240, 130 ],*/
	  setSelect: [ db_x, db_y, db_img_width, db_img_height ],	  
      onChange: updatePreview,
      onSelect: updatePreview,
      aspectRatio: xsize / ysize
    },function(){
		  // Use the API to get the real image size
		  var bounds = this.getBounds();
		  //console.log(bounds);
		  boundx = bounds[0];
		  boundy = bounds[1];
		  // Store the API in the jcrop_api variable
		  jcrop_api = this;  
	
	  	/******* after upload pic start ******/
		var rx = xsize / db_img_width;
		var ry = ysize / db_img_height;
		
		var margin_left_value = $pimg.css("margin-left");
	 	margin_left_value = Math.abs(parseInt(margin_left_value, 10));
		
		var margin_top_value = $pimg.css("margin-top");
	 	margin_top_value = Math.abs(parseInt(margin_top_value, 10));
		//margin_top_value = parseInt(margin_top_value, 10);
		
		var img_width = eval(Math.round(rx * boundx)) + eval(margin_left_value);
		var img_height = eval(Math.round(ry * boundy)) + eval(Math.round(ry * margin_top_value));
		//alert(img_height);
		//alert(Math.round(ry *boundy) + ' - ' +img_height);
		
		//var img_height = eval($('#img_height').val()) - eval(margin_top_value);
		
		//$('#img_height').val()
		//alert(img_width);
	
		$pimg.css({
		  width: Math.round(rx * boundx) + 'px',
		  height: Math.round(ry * boundy) + 'px'
		});
		/*$pimg.css({
		  width: img_width + 'px',
		  height: img_height + 'px'
		});*/
		/******* after upload pic end ******/

      // Move the preview into the jcrop container for css positioning
      $preview.appendTo(jcrop_api.ui.holder);
    });

    function updatePreview(c)
    { //console.log(c.w);
		//console.log(c.x);
      if (parseInt(c.w) > 0)
      {
        var rx = xsize / c.w;
        var ry = ysize / c.h;

        $pimg.css({
          width: Math.round(rx * boundx) + 'px',
          height: Math.round(ry * boundy) + 'px',
          marginLeft: '-' + Math.round(rx * c.x) + 'px',
          marginTop: '-' + Math.round(ry * c.y) + 'px'
        });
		
		$('#x').val(c.x);
		$('#y').val(c.y);
		$('#x2').val(c.x2);
		$('#y2').val(c.y2);
		$('#img_width').val(c.w);
		$('#img_height').val(c.h);	
      }
    };
  });
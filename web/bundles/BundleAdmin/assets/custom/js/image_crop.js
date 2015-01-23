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
    
	var db_x = $('#x').val();
	var db_y = $('#y').val();
	var db_img_width = $('#x2').val();
	var db_img_height = $('#y2').val();
		
    $('#target').Jcrop({
	  bgFade: true,
      bgOpacity: .7,
	  setSelect: [ db_x, db_y, db_img_width, db_img_height ],  
      onChange: updatePreview,
      onSelect: updatePreview,
      aspectRatio: xsize / ysize
    },function(){
		  // Use the API to get the real image size
		  var bounds = this.getBounds();
		  
		  boundx = bounds[0];
		  boundy = bounds[1];
		  // Store the API in the jcrop_api variable
		  jcrop_api = this;  
		  
		  /*************** to show previous image in preview section start *****************/
		  $('#target').Jcrop({onLoad: updatePreview});
		  /*************** to show previous image in preview section end *****************/

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
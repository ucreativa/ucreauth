/*          _\|/_
            (0 0)
--------o00o-{_}-o00o-----------------------

UCREAUTH v1.0 (2011)
Funciones y procedimientos JavaScript
UCREATIVA. 
--------------------------------------------
*/

function basic_tooltip(element){
	
	$(document).ready(function() {
		
	    //Select all anchor tag with rel set to tooltip
	    $(element).mouseover(function(e) {
	        //Grab the title attribute's value and assign it to a variable
	        var tip = $(this).attr('title');   
	         
	        //Remove the title attribute's to avoid the native tooltip from the browser
	        $(this).attr('title','');
	         
	        //Append the tooltip template and its value
	        $(this).append('<div id="tooltip"><div class="tipBody">' + tip + '</div></div>');    
	         
	        //Set the X and Y axis of the tooltip
	        $('#tooltip').css('top', e.pageY + 10 );
	        $('#tooltip').css('left', e.pageX + 20 );
	         
	        //Show the tooltip with faceIn effect
	        $('#tooltip').fadeIn('500');
	         
	    }).mousemove(function(e) {
	     
	        //Keep changing the X and Y axis for the tooltip, thus, the tooltip move along with the mouse
	    $('#tooltip').css('top', e.pageY + 2 );
	    $('#tooltip').css('left', e.pageX + 2 );
	        
	    $('#tooltip').css('position','absolute');
	    $('#tooltip').css('z-index','9999');
	    $('#tooltip').css('color','#333');
	    $('#tooltip').css('font-size','10px');
	    $('#tooltip').css('width','180px');
	    
	    $('.tipBody').css('border','solid 1px #DDD');
	    $('.tipBody').css('background-color','#fff'); 
	    $('.tipBody').css('padding','4px 4px 4px 6px');
	    $('.tipBody').css('moz-border-radius','5px');
	    $('.tipBody').css('border-radius','5px');
	    $('.tipBody').css('webkit-border-radius','5px');  
	         
	    }).mouseout(function() {
	     
	        //Put back the title attribute's value
	        $(this).attr('title',$('.tipBody').html());
	     
	        //Remove the appended tooltip template
	        $(this).children('div#tooltip').remove();
	         
	    });
	 
	});
}
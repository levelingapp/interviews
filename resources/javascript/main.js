$(document).ready(function(){
    $("#eventsForm").submit(function(e){
        e.preventDefault();

        var address = $("#address").val();

        $.get( "fake-route/?controller=events&address=" + address, function( data ) {

            var obj = $.parseJSON( data);

            var toHtml = "";
            $.each(obj, function(index) {
                toHtml +=    "<div class=\"col-sm-4 mt-3\">" +
                    "<div class=\"card\" style=\"width: 18rem;\">" +
                    "<div class=\"card-body\">" +
                    " <h5 class=\"card-title\">" + obj[index].title.substr(0, 36) + "...</h5>" +
                    "<p class=\"card-text\">" + obj[index].description.substr(0, 100) + "...</p>" +
                    "<a href=\"#\" class=\"btn btn-primary\">More Info</a>" +
                    "</div>" +
                    "</div>" +
                    "</div>";
            });

            if(!toHtml){
                toHtml = "<div class='no-events'>No events found in a 55 mile radius of this address</div>"
            }

            $( "#all-events" ).html( toHtml );

        });
    });
});

$(document).ready(function() {
    // Select/unselect all checkboxes
    $("#selectAllBoxes").click(function(event){
        if (this.checked) {
            $(".checkBoxes").each(function() {
                this.checked = true;
            });
        } else {
            $(".checkBoxes").each(function() {
                this.checked = false;
            });
        }
    });

    var div_box = "<div id='load-screen'><div id='loading'></div></div>";
    $("body").prepend(div_box);
    $("#load-screen").delay(300).fadeOut(200, function() {
        $(this).remove();
    });

});


// Fix for US dates in DataTables
jQuery.extend( jQuery.fn.dataTableExt.oSort, {
    "datetime-us-flex-pre": function ( a ) {
        // If there's no slash, then it's not an actual date, so return zero for sorting
        if(a.indexOf('/') === -1) {
            return '0';
        } else {
            // Set optional items to zero
            var hour = 0,
                min = 0,
                ap = 0;
            // Execute match. Requires month, day, year. Can be mm/dd or m/d. Can be yy or yyyy
            // Time is optional. am/pm is optional
            // TODO - remove extra time column from array
            var b = a.match(/(\d{1,2})\/(\d{1,2})\/(\d{2,4})( (\d{1,2}):(\d{1,2}))? ?(am|pm|AM|PM|Am|Pm)?/),
                month = b[1],
                day = b[2],
                year = b[3];
            // If time exists then output hours and minutes
            if (b[4] != undefined) {
                hour = b[5];
                min = b[6];
            }
            // if using am/pm then change the hour to 24 hour format for sorting
            if (b[7] != undefined) {
                ap = b[7];
                if(hour == '12') hour = '0';
                if(ap == 'pm') hour = parseInt(hour, 10)+12;
            }

            // for 2 digit years, changes to 20__ if less than 70
            if(year.length == 2){
                if(parseInt(year, 10) < 70) year = '20'+year;
                else year = '19'+year;
            }
            // Converts single digits
            if(month.length == 1) month = '0'+month;
            if(day.length == 1) day = '0'+day;
            if(hour.length == 1) hour = '0'+hour;
            if(min.length == 1) min = '0'+min;
            var tt = year+month+day+hour+min;

            return tt;
        }
    },
    "datetime-us-flex-asc": function ( a, b ) {
        return a - b;
    },
    "datetime-us-flex-desc": function ( a, b ) {
        return b - a;
    }
});

$(document).ready( function() {

    // Copies selected content to clipboard
    var clipboard = new Clipboard('.copy');
    clipboard.on('success', function(e) {
        console.log(e);
    });
    clipboard.on('error', function(e) {
        console.log(e);
    });

    // Bulk changes values based on selection from dropdown
    var original_value = "";

    $('#status').on('change',function(){
        var value = $(this).val();
        if (value === "Awaiting to be Received") {
            $("#ipad, #ipad_imei, #ipad_phone_number, #iphone, #iphone_imei, #iphone_phone_number, #iphone_carrier, #laptop, #laptop_asset_number").val("N/A");
        } else {
        }
    });

    // Removes focus after pressing an email button
    $(".email-button").click(function(){
        $(this).blur();
    });

    // Sends row value to view_entry.php to pull up user record
    $(".click-row").click(function(){
        var a = this.id;
        var n = a.slice(7);
        window.location.href = "?p=view_entry&row=" + n;
    });

    // Initializes DataTable and sets column ordering
    $('#view-all').DataTable({
        colReorder: true,
        pageLength: 50,
        order: [[0, 'desc']],
        columnDefs: [
                { type: 'datetime-us-flex', targets: 0 }
               ]
    });

    // Variable used for filtering column values
    var table =  $('#view-all').DataTable();

    // Sets the filtering based on selected value in dropdown
    $('#site-dropdown').change(function () {
        table.columns(6).search( this.value ).draw();
    } );

    $('#site-dropdown').focus();

    // Basic link
    $("#go-back-button").click(function(){
        window.location = "?p=view_all";
    });

    // Basic link
    $("#landing-new-hires-button").click(function(){
        window.location = "?p=new_hires";
    });

    // Basic link
    $("#landing-departures-button").click(function(){
        window.location = "?p=departures";
    });

    // Changes visibility of other buttons when button is pressed
    $("#edit-button").click(function(){
        $("#save-button, #cancel-button, .view-input").show();
        $("#edit-button, #go-back-button, #print-button, .initial-text").hide();
        $("#status").focus();
        original_value = $("form").serializeArray();
    });

    // Cancel button that clears changes-made values
    $("#confirmation-cancel-button ").click(function(){
        $("#changes-made").empty();
    });

    // Save button check old and new values for comparison and display to user
    $("#save-button").click(function() {
        var new_value = $("form").serializeArray();
        for(var i=0; i<original_value.length; i++){
            $("#changes-made").append(original_value[i].value + " > " + "<strong>" + new_value[i].value  + "</strong>" + " " + "<br>");
        }
    });

    // Cancel button for editing fields. Also hides/shows the correct buttons for editing the fields
    $("#cancel-button").click(function(){
        $("#save-button, #cancel-button, .view-input").hide();
        $("#edit-button, #go-back-button, #print-button, .initial-text").show();
    });

    // Print button
    $("#print-button").click(function(){
        window.print();
    });

    // Turns the enter key push into a click event to avoid erroneously submitting the form without confirmation modal popping up first
    $( "form" ).keypress(function( event ) {
        if ( event.which == 13 ) {
            event.preventDefault();
            $("#save-button").click();
        }
    });

    // Fix for IE11 and Edge to relate buttons outside of form element
    $("#confirmation-save-button").click(function(){
        if (Modernizr.formattribute) {
            // supported
        } else {
            // not-supported
            $("#edit-values").submit();
        }
    });

    // Clears changes-made values when user does not confirm changes
    $('#confirmation-modal').on('hidden.bs.modal', function () {
        $("#changes-made").empty();
    });

    // User lookup search
    $( function() {
        function log( message ) {
            $( "<div>" ).text( message ).prependTo( "#log" );
            $( "#log" ).scrollTop( 0 );
        }

        $( "#remedy-search" ).autocomplete({
            source: "remedy_search.php",
            minLength: 2,
            select: function( event, ui ) {
                log( ui.item.value );
            }
        });
    } );
});


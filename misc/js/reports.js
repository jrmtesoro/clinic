$.ajax({
    url: "/clinic1/includes/ajax.php?tag=getDate&table=billing",
    type: "POST",
    dataType: "json",
    success: function(response) 
    {
        var minDate = response.min;
        var maxDate = response.max;
        $("#bsd").daterangepicker({
            startDate: minDate,
            endDate: maxDate,
            minDate: minDate,
            maxDate: maxDate,
            periods: ['day'],
            orientation: 'left',
            ranges: {},
            callback: function (startDate, endDate, period) {
                $(this).val(startDate.format('L') + ' – ' + endDate.format('L'));
                getTable();
            }
        });
        $("#bm").daterangepicker({
            startDate: minDate,
            endDate: maxDate,
            minDate: minDate,
            maxDate: maxDate,
            periods: ['month'],
            orientation: 'left',
            ranges: {},
            callback: function (startDate, endDate, period) {
                $(this).val(startDate.format('MM/YYYY') + ' – ' + endDate.format('MM/YYYY'));
                getTable();
            }
        });
        $("#by").daterangepicker({
            startDate: minDate,
            endDate: maxDate,
            minDate: minDate,
            maxDate: maxDate,
            periods: ['year'],
            orientation: 'left',
            ranges: {},
            callback: function (startDate, endDate, period) {
                $(this).val(startDate.format('YYYY') + ' – ' + endDate.format('YYYY'));
                getTable();
            }
        });
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
        console.log(XMLHttpRequest['responseText']);
        }
});

$.ajax({
    url: "/clinic1/includes/ajax.php?tag=getDate&table=patient",
    type: "POST",
    dataType: "json",
    success: function(response) 
    {
        var minDate = response.min;
        var maxDate = response.max;
        $("#psd").daterangepicker({
            startDate: minDate,
            endDate: maxDate,
            minDate: minDate,
            maxDate: maxDate,
            periods: ['day'],
            orientation: 'left',
            ranges: {},
            callback: function (startDate, endDate, period) {
                $(this).val(startDate.format('L') + ' – ' + endDate.format('L'));
                getTable();
            }
        });
        $("#pm").daterangepicker({
            startDate: minDate,
            endDate: maxDate,
            minDate: minDate,
            maxDate: maxDate,
            periods: ['month'],
            orientation: 'left',
            ranges: {},
            callback: function (startDate, endDate, period) {
                $(this).val(startDate.format('MM/YYYY') + ' – ' + endDate.format('MM/YYYY'));
                getTable();
            }
        });
        $("#py").daterangepicker({
            startDate: minDate,
            endDate: maxDate,
            minDate: minDate,
            maxDate: maxDate,
            periods: ['year'],
            orientation: 'left',
            ranges: {},
            callback: function (startDate, endDate, period) {
                $(this).val(startDate.format('YYYY') + ' – ' + endDate.format('YYYY'));
                getTable();
            }
        });
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
        console.log(XMLHttpRequest['responseText']);
        }
});

$.ajax({
    url: "/clinic1/includes/ajax.php?tag=getDate&table=result",
    type: "POST",
    dataType: "json",
    success: function(response) 
    {
        var minDate = response.min;
        var maxDate = response.max;
        $("#rsd").daterangepicker({
            startDate: minDate,
            endDate: maxDate,
            minDate: minDate,
            maxDate: maxDate,
            periods: ['day'],
            orientation: 'left',
            ranges: {},
            callback: function (startDate, endDate, period) {
                $(this).val(startDate.format('L') + ' – ' + endDate.format('L'));
                getTable();
            }
        });
        $("#rm").daterangepicker({
            startDate: minDate,
            endDate: maxDate,
            minDate: minDate,
            maxDate: maxDate,
            periods: ['month'],
            orientation: 'left',
            ranges: {},
            callback: function (startDate, endDate, period) {
                $(this).val(startDate.format('MM/YYYY') + ' – ' + endDate.format('MM/YYYY'));
                getTable();
            }
        });
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
        console.log(XMLHttpRequest['responseText']);
        }
});

function getTable()
{
    var tbk = $('#reports_selector').val();
    var option = $('#reports_option').val();
    var option1 = $('#reports_option1').val();
    var date = $("#"+tbk+option).val();
    var dateArr = date.split(" – ");
    var start = dateArr[0];
    var end = dateArr[1];
    var cols = [];
    var th = "";
    if (option1 == "info")
    {
        var title1 = "";
        if (tbk == "b")
        {
            $('#card-title').text("Billing Information");
            th = "<th>Billing ID</th><th>First Name</th><th>Last Name</th><th>Total</th><th>Services</th><th>Date Time</th>";
            cols = [
                {data : "id"},
                {data : "first"},
                {data : "last"},
                {data : "total"},
                {data : "services"},
                {data : "datetime"}
            ]
            title1 = "Sales Report";
        }
        else if (tbk == "p")
        {
            $('#card-title').text("Patient Information");
            th = "<th>Patient ID</th><th>First Name</th><th>Middle Name</th><th>Last Name</th><th>Address</th><th>Contact Number</th><th>Date Registered</th>";
            cols = [
                {"data" : "id"},
                {"data" : "first"},
                {"data" : "mid"},
                {"data" : "last"},
                {"data" : "address"},
                {"data" : "contact_number"},
                {"data" : "date_registered"},
            ]
            title1 = "Patient Report";
        }
        var table = $('#report-table').DataTable();
        table.clear().destroy();
        $('#columns').html(th);
        $('#ft').html("");
        $('#report-table').DataTable({
            "ajax" : {
                "url" : "/clinic1/includes/ajax.php?tag=get-table&table="+tbk+"&start="+start+"&end="+end+"&option="+option+"&option1="+option1,
                "dataSrc" : ""
            },
            "columns" : cols,
            "shim": {
                "vfs_fonts": ["pdfmake"]
            },
            dom: 'Bfrtip',
            buttons: [
                { 
                    extend: 'excelHtml5',
                    footer: true,
                    title: title1
                },
                { 
                    extend: 'pdfHtml5',
                    footer: true,
                    title: title1,
                    customize: function (doc) {
                        doc.content[1].table.widths =
                        Array(doc.content[1].table.body[0].length + 1).join('%').split('');
                    }
                }
            ]
        });
    }
    else if (option1 == "total")
    {
        var foot = "<th></th><th></th>";
        var title1 = "";
        if (option == "sd")
        {
            th = "<th>Date</th>";
        }
        else if (option == "m")
        {
            th = "<th>Month</th>"
        }
        else if (option == "y")
        {
            th = "<th>Year</th>"
        }

        if (tbk == "b")
        {
            $('#card-title').text("Billing Information");
            th += "<th>Total Transactions</th><th>Total Money</th>";
            cols = [
                {data : "date"},
                {data : "total_transaction"},
                {data : "total_money"}
            ]
            foot += "<th></th>";
            title1 = "Total Sales Report";
        }
        else if (tbk == "p")
        {
            $('#card-title').text("Patient Information");
            th += "<th>Total Patients</th>";
            cols = [
                {"data" : "date"},
                {"data" : "total_patients"}
            ]
            title1 = "Total Patients Report";
        }
        var table = $('#report-table').DataTable();
        table.clear().destroy();
        $('#columns').html(th);
        $('#ft').html(foot);
        $('#report-table').DataTable({
            "ajax" : {
                "url" : "/clinic1/includes/ajax.php?tag=get-table&table="+tbk+"&start="+start+"&end="+end+"&option="+option+"&option1="+option1,
                "dataSrc" : ""
            },
            "columns" : cols,
            "footerCallback": function ( row, data, start, end, display ) {
                var api = this.api(), data;
                var intVal = function ( i ) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '')*1 :
                        typeof i === 'number' ?
                            i : 0;
                };

                var col = 1;
                var title = "";
                if (tbk == "b")
                {
                    col = 2;
                    title = "Total Sales: "
                }
                else if (tbk == "p")
                {
                    title = "Total Patients: "
                }
                var total = api
                    .column(col)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
    
                $( api.column(col).footer() ).html(title+total);
            },
            dom: 'Bfrtip',
            buttons: [
                { 
                    extend: 'excelHtml5',
                    footer: true,
                    title: title1
                },
                { 
                    extend: 'pdfHtml5',
                    footer: true,
                    title: title1,
                    customize: function (doc) {
                        // doc.content[1].table.widths =
                        // Array(doc.content[1].table.body[0].length + 1).join('%').split('');
                        doc.content.splice( 1, 0, {
                            margin: [ 0, 0, 0, 12 ],
                            alignment: 'center',
                            image: img
                        } );
                    }
                }
            ]
        });
    }
}

$("#reports_selector, #reports_option1").change(function(){
    var tbk = $('#reports_selector').val();
    var option = $('#reports_option').val();
    if ($("#"+tbk+option).val() != "")
    {
        getTable();
    }
});

$("#reports_selector, #reports_option").change(function(){
    var tbk = $('#reports_selector').val();
    var option = $('#reports_option').val();
    $(".dates").addClass("d-none");
    $("#"+tbk+option).removeClass("d-none");
});
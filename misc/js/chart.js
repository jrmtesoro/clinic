$('#clickme').popover('show');
var text = "$('#clickme').popover('dispose')";
$(".popover-header").append('<button type="button" id="close" class="close" onclick="'+text+'">&times;</button>');
$("#clickme").popover('disable');

var labels = byMonth();

var donut_values = {
    labels : ["Fecalysis", "Urinalysis", "Hematology"],
    datasets : [{
        "label":"Examinations",
        "data": [1,2,3],
        "backgroundColor":["rgb(128,0,0,0.8)", "rgb(255,255,0,0.8)", "rgb(255,0,0,0.8)"]
    }]
};

var donut_ctx = document.getElementById("chartjs2").getContext("2d");
var donut_chart = new Chart(donut_ctx, {
    data: donut_values,
    type: 'doughnut',
    options: {
        responsive: true,
        title: {
            display: true,
            text: "Total Patients"
        }
    }
});


var patient_values = {
    labels : labels,
    datasets : [{
        "label":"Total Patients",
        "data": [],
        "backgroundColor":"rgb(0,0,255,0.5)",
        "borderWidth": 1
    }]
};

var patient_ctx = document.getElementById("chartjs").getContext("2d");
var patient_chart = new Chart(patient_ctx, {
    type: 'bar',
    data: patient_values,
    options : {
        responsive: true,
        legend: {
            display: false
        },
        onClick: barClick,
        tooltips: {
            displayColors: false,
            callbacks: {
                label: function(tooltipItem, data) {
                    return "Total Patients : "+tooltipItem.yLabel;
                }
            }
        },
        title: {
            display: true,
            text: "Total Patients"
        }
    }
});

var sales_values = {
    labels : labels,
    datasets : [{
        "label":"Total Patients",
        "data":[],
        "backgroundColor": "rgb(0,128,0,0.5)",
        "borderWidth": 1
    }]
};

var sales_ctx = document.getElementById("chartjs1").getContext("2d");
var sales_chart = new Chart(sales_ctx, {
    type: 'bar',
    data: sales_values,
    options : {
        responsive: true,
        legend: {
            display: false
        },
        tooltips: {
            displayColors: false,
            callbacks: {
                label: function(tooltipItem, data) {
                    return "Total Sales : "+tooltipItem.yLabel;
                }
            }
        },
        title: {
            display: true,
            text: "Total Sales"
        }
    }
});

getValues("sales", "month", "sales");
getValues("total-patients", "month", "patient");

function getValues(type, sort, chart)
{
    $.ajax({ 
        type: "POST",   
        url: "/clinic/includes/ajax-chart.php?do="+type,
        dataType: "json",
    
        success : function(response)
        {
            var values = [];
            if (sort == "month")
            {
                var d = new Date();
                var month_index = d.getMonth();
                for (x = 0; x <= month_index; x++)
                {
                    var found = false;
                    $.each(response, function(i, item) {
                        if (parseInt(response[i].month)-1 == x)
                        {
                            values.push(parseInt(response[i].total));
                            found = true;
                            return false;
                        }
                    });
                    if (!found)
                    {
                        values.push(0);
                    }
                }
            }
            else
            {
                for (x = 0; x <= 6; x++)
                {
                    var found = false;
                    $.each(response, function(i, item) {
                        if (response[i].day == moment().subtract(6-x, 'days').format("DD"))
                        {
                            values.push(parseInt(response[i].total));
                            found = true;
                            return false;
                        }
                    });
                    if (!found)
                    {
                        values.push(0);
                    }
                }
            }
            if (chart == "sales")
            {
                sales_chart.data.datasets[0].data = values;
                sales_chart.update();   
            }
            else
            {
                patient_chart.data.datasets[0].data = values;
                patient_chart.update();   
            }
        }
    });
}

function barClick(event, array)
{
    if (typeof array !== "undefined")
    {
        donut_chart.data.datasets[0].data = [];
        var value = array[0]._model.label;
        var month = false;
        var month_list = ["January","February","March","April","May","June","July","August","September","October","November","December"];
        for (i = 0; i < month_list.length; i++)
        {
            if (value == month_list[i])
            {
                month = true;
                break;
            }
        }

        if (month)
        {
            $.ajax({ 
                type: "POST",   
                url: "/clinic/includes/ajax-chart.php?get=patients&month="+value,
                dataType: "text",
                
                success : function(response)
                {
                    var table_list = ['fecalysis', 'urinalysis', 'hematology'];
                    for (i = 0; i < table_list.length; i++)
                    {
                        $.ajax({ 
                            type: "POST",   
                            url: "/clinic/includes/ajax-chart.php?donut=patients&table="+table_list[i]+"&month="+value,
                            dataType: "text",
                            
                            success : function(response)
                            {
                                donut_chart.data.datasets[0].data.push(parseInt(response));
                                donut_chart.update();
                            }
                        });
                    }
                    $("#table").removeClass("d-none");
                    $("#table2").html(response);
                    $('#table1').DataTable();
                    $("#btnTable").html(value+" Patient List");
                    $("#table3").collapse("show");
                }
            });
        }
        else
        {
            $.ajax({ 
                type: "POST",   
                url: "/clinic/includes/ajax-chart.php?get=patients&day="+value,
                dataType: "text",
                
                success : function(response)
                {
                    var table_list = ['fecalysis', 'urinalysis', 'hematology'];
                    for (i = 0; i < table_list.length; i++)
                    {
                        $.ajax({ 
                            type: "POST",   
                            url: "/clinic/includes/ajax-chart.php?donut=patients&table="+table_list[i]+"&day="+value,
                            dataType: "text",
                            
                            success : function(response)
                            {
                                donut_chart.data.datasets[0].data.push(parseInt(response));
                                donut_chart.update();
                            }
                        });
                    }
                    $("#table").removeClass("d-none");
                    $("#table2").html(response);
                    $('#table1').DataTable();
                    $("#btnTable").html(value+" Patient List");
                    $("#table3").collapse("show");
                }
            });
        }
    }
}



$('#table3').on('shown.bs.collapse', function () 
    {
        this.scrollIntoView({behavior: 'smooth' });
    });

function last7Days()
{
    var label_day = [];
    for(var i=0; i<=6; i++) 
    {
        label_day[i] = moment().subtract(6-i, 'days').format("MM/DD")
    }
    return label_day;
}

function byMonth()
{
    var d = new Date();
    var month_index = d.getMonth();
    var label_month = [];
    var month_list = ["January","February","March","April","May","June","July","August","September","October","November","December"];
    for (var i = 0; i <= month_index; i++)
    {
        label_month[i] = month_list[i];
    }
    return label_month;
}

$("#sort").change(function() {
    if (this.value == "month")
    {
        patient_chart.data.labels = byMonth();
        patient_chart.update();
        sales_chart.data.labels = byMonth();
        sales_chart.update();

        getValues("sales", "month", "sales");
        getValues("total-patients", "month", "patient");
    }
    else
    {
        patient_chart.data.labels = last7Days();
        patient_chart.update();
        sales_chart.data.labels = last7Days();
        sales_chart.update();
        getValues("sales1", "day", "sales");
        getValues("total-patients1", "day", "patient");
    }

});
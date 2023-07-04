<!DOCTYPE html>
<html lang="ru">
<head>
	<title>Demo</title>
	<meta name="description" content="">
	<base href="https://upterm.ru/demo/" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">
    <script src="js/bootstrap.bundle.min.js"></script>
	<script src="js/jquery-3.6.0.min.js"></script>

    <script src="js/flot/source/jquery.js"></script>
<script src="js/flot/lib/jquery.event.drag.js"></script>
<script src="js/flot/lib/jquery.mousewheel.js"></script>
<script src="js/flot/source/jquery.canvaswrapper.js"></script>
<script src="js/flot/source/jquery.colorhelpers.js"></script>
<script src="js/flot/source/jquery.flot.js"></script>
<script src="js/flot/source/jquery.flot.saturated.js"></script>
<script src="js/flot/source/jquery.flot.browser.js"></script>
<script src="js/flot/source/jquery.flot.drawSeries.js"></script>
<script src="js/flot/source/jquery.flot.uiConstants.js"></script>
<script src="js/flot/source/jquery.flot.navigate.js"></script>
<script src="js/flot/source/jquery.flot.touchNavigate.js"></script>
<script src="js/flot/source/jquery.flot.hover.js"></script>
<script src="js/flot/source/jquery.flot.touch.js"></script>
<script src="js/flot/source/jquery.flot.selection.js"></script>
<script src="js/flot/source/jquery.flot.time.js"></script>
</head>
<body>
	<div class="wrapper">
    От: <input id="from" type="datetime-local" value="2023-07-01T00:00"/>
    До: <input id="to" type="datetime-local" value="2023-07-05T00:00"/>
    <button id="get_inf" class="btn btn-primary">Сформировать график</button> 
	</div>
    <div id="placeholder"></div>
<script>
let dataset = [];

function getRandomIntInt(min, max) {
	min = Math.ceil(min);
	max = Math.floor(max);
	return Math.floor(Math.random() * (max - min + 1)) + min;
}

function visibleGr(){
	var plot = $.plot("#placeholder", [dataset], {
		series: {
			lines: {
				show: true
			},
			points: {
				show: true
			}
		},
		grid: {
			hoverable: true,
			clickable: true
		},
        xaxis: {
        mode: "time", 
            minTickSize: [1, "day"],
            timeformat: "%d",
            timeBase: "milliseconds"      
        },
		yaxis: {min: 0, tickSize: 10, minTickSize: 10, ticks: 10},
		zoom: {
			interactive: true
		},
		pan: {
			interactive: true,
			enableTouch: true
		}
	});
}

$("#get_inf").click(function() {
    let from = $("#from").val();
    let to = $("#to").val();

	$.post("ajax.php", {
        "reque": "get_inf",
        "from": from,
        "to": to
    }).done(function(data) {
        var obj = JSON.parse(data);
        if (obj["success"] == true){
            //заполняем датасет
            dataset = [];
            let events = obj["arr"];

            for (const [key, value] of Object.entries(events)) {
              let tmp = [new Date(key).getTime(), value]; 
                dataset.push(tmp);
            }

    

            //отрисовываем
			visibleGr();
		}
		else{
			alert("Что-то пошло не так!");
		}
	});
});





</script>
</body>
</html>
<?php use_helper('I18N') ?>

<!--Load the AJAX API-->
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">

    // Load the Visualization API and the piechart package.
    google.load('visualization', '1.0', {
        'packages':['corechart']
    });
    
    // Set a callback to run when the Google Visualization API is loaded.
    google.setOnLoadCallback(drawChart);
    
    // Callback that creates and populates a data table, 
    // instantiates the pie chart, passes in the data and
    // draws it.
    function drawChart() {

        // Create the deposit table.
        var data1 = new google.visualization.DataTable();
        data1.addColumn('string', '<?php echo $string ?>');
        data1.addColumn('number', '<?php echo $number ?>');
        data1.addRows([
            <?php $count = count($deposit_pie) ?>
            <?php foreach ($deposit_pie as $key => $value) : $i = 0 ?>
                ['<?php echo $key ?>', <?php echo $value ?>]
                <?php if ($i < $count) echo ',' ?>
                <?php $i++ ?>
            <?php endforeach ?>
        ]);

        // Set deposit chart options
        var options1 = {
            'title':'<?php echo __('Deposits (%money%)', array('%money%' => number_format($deposits, 2))) ?>',
            'width':450,
            'height':450
        };

        // Instantiate and draw deposit chart, passing in some options.
        var chart1 = new google.visualization.PieChart(document.getElementById('chart1_div'));
        chart1.draw(data1, options1);



        // Create the withdrawal table.
        var data2 = new google.visualization.DataTable();
        data2.addColumn('string', '<?php echo $string ?>');
        data2.addColumn('number', '<?php echo $number ?>');
        data2.addRows([
            <?php $count = count($withdrawal_pie) ?>
            <?php foreach ($withdrawal_pie as $key => $value) : $i = 0 ?>
                ['<?php echo $key ?>', <?php echo $value ?>]
                <?php if ($i < $count) echo ',' ?>
                <?php $i++ ?>
            <?php endforeach ?>
        ]);

        // Set withdrawal chart options
        var options2 = {
            'title':'<?php echo __('Withdrawals (%money%)', array('%money%' => number_format($withdrawals, 2))) ?>',
            'width':450,
            'height':450
        };

        // Instantiate and draw withdrawal chart, passing in some options.
        var chart2 = new google.visualization.PieChart(document.getElementById('chart2_div'));
        chart2.draw(data2, options2);
    }
</script>
<!--Div that will hold the pie chart-->
<div id="chart1_div" class="chart"></div>
<div id="chart2_div" class="chart"></div>

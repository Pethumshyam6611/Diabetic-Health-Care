<?php

function generateSystolicChart($patient_id) {
    try {
        $conn = conn::getConnection();
        $sql = "SELECT  YEAR(appointment.date) AS year,
                        MONTH(appointment.date) AS month, 
                        AVG(CAST(SUBSTRING_INDEX(visit_record.bp_systolic, 'mm', 1) AS UNSIGNED)) AS avg_bp_level
                FROM appointment
                INNER JOIN visit_record ON appointment.appointment_id = visit_record.appoinment_id
                WHERE appointment.patient_id = :pId
                GROUP BY YEAR(appointment.date), MONTH(appointment.date);";
        $query = $conn->prepare($sql);
        $query->execute([':pId'=> $patient_id]);
        $data = $query->fetchAll(PDO::FETCH_ASSOC);

        $chart_js = "
            google.charts.load('current', {'packages':['corechart']});
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {
                var data = google.visualization.arrayToDataTable([
                    ['Month', 'Average Systolic Pressure Level'],";
        foreach ($data as $row) {
            $monthYear = date('M Y', mktime(0, 0, 0, $row['month'], 1, $row['year']));

            $chart_js .= "['" . $monthYear . "', " . $row['avg_bp_level'] . "],";
        }
        $chart_js .= "
                ]);

                var options = {
                    title: 'Average Systolic Pressure by Month',
                    curveType: 'function',
                    legend: { position: 'bottom' },
                    hAxis: {
                        title: 'Month-Year'
                    },
                    vAxis: {
                        title: 'Systolic Pressure (mmHg)'
                    }
                    
                };

                var chart = new google.visualization.LineChart(document.getElementById('bp_chart'));

                chart.draw(data, options);
            }
        ";

        echo "<script type='text/javascript'>$chart_js</script>";
    } catch(Exception $e){
        echo "Error: ".$e->getMessage();
    }
}

?>



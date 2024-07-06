<?php


function generateGlucoseChart($patient_id) {
    try {
        $conn = conn::getConnection();
        $sql = "SELECT YEAR(appointment.date) AS year,
                       MONTH(appointment.date) AS month, 
                       AVG(CAST(SUBSTRING_INDEX(visit_record.glucose_level, 'mg', 1) AS UNSIGNED)) AS avg_glucose_level
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
                    ['Month', 'Average Glucose Level'],";
        foreach ($data as $row) {
            $monthYear = date('M Y', mktime(0, 0, 0, $row['month'], 1, $row['year']));
            $chart_js .= "['" . $monthYear . "', " . $row['avg_glucose_level'] . "],";
        }
        $chart_js .= "
                ]);

                var options = {
                    title: 'Average Glucose Level by Month',
                    curveType: 'function',
                    legend: { position: 'bottom' },
                    colors: ['red'],
                    hAxis: {
                        title: 'Month-Year'
                    },
                    vAxis: {
                        title: 'Glucose Level (mg/dL)'
                    }
                };

                var chart = new google.visualization.LineChart(document.getElementById('glucose_chart'));

                chart.draw(data, options);
            }
        ";

        echo "<script type='text/javascript'>$chart_js</script>";
    } catch(Exception $e){
        echo "Error: ".$e->getMessage();
    }
}
?>


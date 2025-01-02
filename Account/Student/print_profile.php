<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Printable Page</title>
    <link rel="shortcut icon" type="x-icon" href="https://i.postimg.cc/1Rgn7KSY/Dr-Ramon.png">
    <link rel="stylesheet" href="css/print_profile.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- FontAwesome 5 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://www.gstatic.com/charts/loader.js"></script>

    <!-- <script type="text/javascript" src="css/eval_graph.js"></script> -->
</head>

<body>
    <div class="print-container">
        <div class="container-grap-right">

            <div class="row-profile" id="row_profile">

                <div class="column-profile column-side profile-pic">
                    <img src="uploads/default.png" alt="Profile Image Preview" style="border-radius: 50%;">


                </div>
                <div class="column-profile ">
                    <div class="card-body">
                        <span class="fullname">sample name </span>
                        <span class="LRN">LRN: 123123124123</span>
                        <br>

                        <i class="fa fa-graduation-cap" aria-hidden="true"></i><span
                            class="other-info">stem</span>
                        <br>
                        <i class="fa fa-envelope" aria-hidden="true"></i><span class="other-info">@gmial.com</span>

                        <br>
                        <i class="fa fa-home" aria-hidden="true"></i><span class="other-info">olshco</span>
                        <br>
                        <i class="fa fa-briefcase" aria-hidden="true"></i><span
                            class="other-info">none</span>






                    </div>
                </div>
            </div>





        </div>

        <div class="student-graph">
            <hr>
            <h2 class="title-resume">Daily Insight</h2>
            <span class="description-resume">The line chart analyzes student daily performance in work
                immersion, and the pie chart displays the distribution of performance levels.</span>

            <div class="container-grap">
                <div class="dp-graph" id="piechart_3d"></div>
            </div>



            <div class="container-grap">
                <div class="dp-graph" id="dp_chart_div"></div>

            </div>
        </div>



        <div class="student-graph">
            <hr>
            <h2 class="title-resume">Evaluation Insight</h2>
            <span class="description-resume" style="margin-bottom:20px;">The graph summarizes supervisor feedback on students' work habits,
                skills, and social skills during immersion.</span>


            <div class="wp-graph eval-graph" id="wp-top-x-div" style="width: 100%; height: 400px;"></div>
            <div class="pro-graph eval-graph" id="pro-top-x-div" style="width: 100%; height: 400px;"></div>
            <div class="ld-graph eval-graph" id="ld-top-x-div" style="width: 100%; height: 400px;"></div>

        </div>

    </div>

    <!-- <button onclick="window.print()">Print this page</button> -->
</body>

<script>
    google.charts.load("current", {
        packages: ["corechart"]
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Task', 'Hours per Day'],
            ['Work Habits', 11],
            ['Work Skills', 2],
            ['Social Skills', 2]
        ]);

        var options = {
            title: "Total Work Performance",
            height: "100%",
            width: "100%",
            is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        chart.draw(data, options);
        window.addEventListener("resize", function() {
            if (chart) {
                drawChart();
            }
        });

    }


    ////////////////////////////////////////////////////DAILY PERFORMANCE ////////////////////////////////////

    google.charts.load("current", {
        packages: ["corechart", "line"]
    });
    google.charts.setOnLoadCallback(drawBasic);

    // function drawDailyPerformanceChart() {
    //     var dp_data = new google.visualization.DataTable();
    //     dp_data.addColumn("string", "Date");
    //     dp_data.addColumn("number", "Performance Rating");


    //     dailyPerformance.forEach(function(entry) {
    //         dp_data.addRow([entry.date, entry.score]); 
    //     });
    function drawBasic() {

        var dp_data = new google.visualization.DataTable();
        dp_data.addColumn('number', 'X');
        dp_data.addColumn('number', 'Date');

        dp_data.addRows([
            [0, 0],
            [1, 10],
            [2, 23],
            [3, 17],
            [4, 18],
            [5, 9],
            [6, 11],
            [7, 27],
            [8, 33],
            [9, 40],
            [10, 32],
            [11, 35],
            [12, 30],
            [13, 40],
            [14, 42],
            [15, 47],
            [16, 44],

        ]);


        var options = {
            title: "Daily Performance",
            height: "100%",
            width: "100%",
            // hAxis: {
            //     title: "Date",
            //     format: "MMM dd",
            // },
            vAxis: {
                title: "Performance Rating",
                minValue: 0,
                maxValue: 5,
            },
            legend: {
                position: "bottom"
            },
        };

        var dp_chart = new google.visualization.LineChart(
            document.getElementById("dp_chart_div")
        );
        dp_chart.draw(dp_data, options);
    }

    // Redraw the chart on window resize
    window.addEventListener("resize", function() {
        drawDailyPerformanceChart();
    });

    /////////////////////////////////////////////// WORK HABITS CHART ///////////////////////////////////////
    google.charts.load("current", {
        packages: ["bar"],
    });
    google.charts.setOnLoadCallback(drawWorkHabitsChart);

    // function drawWorkHabitsChart() {
    //     var data = new google.visualization.arrayToDataTable([
    //         ["Category", "Performance"],
    //         ["Punctuality", averages.avgPunctual || 0],
    //         ["Reports Regularly", averages.avgReportsRegularly || 0],
    //         [
    //             "Performs Tasks Independently",
    //             averages.avgPerformsTasksIndependently || 0,
    //         ],
    //         ["Self Discipline", averages.avgSelfDiscipline || 0],
    //         ["Dedication & Commitment", averages.avgDedicationCommitment || 0],
    //     ]);
    function drawWorkHabitsChart() {

        var data = google.visualization.arrayToDataTable([
            ["Category", "Performance"],
            ['Punctuality', 20],
            ['Reports Regularly', 50],
            ['Performs Tasks Independently', 30],
            ['Self Discipline', 18],
            ['Dedication & Commitment', 27]
        ]);

        var options = {
            title: "Work Habits",
            height: "100%", // Set height to 100%
            width: "100%", // Set width to 100%
            legend: {
                position: "none"
            },
            chart: {
                title: "Work Habits",
                subtitle: "Student work habits from the work immersion",
            },
            bars: "horizontal", // Required for Material Bar Charts.
            axes: {
                x: {
                    0: {
                        side: "top",
                        label: "Performance"
                    }, // Top x-axis.
                },
            },
            bar: {
                groupWidth: "90%"
            },
        };

        var chart = new google.charts.Bar(document.getElementById("wp-top-x-div"));
        chart.draw(data, options);
    }

    // Redraw chart on window resize
    window.addEventListener("resize", function() {
        drawWorkHabitsChart();
    });
    /////////////////////////////////////////////// WORK SKILLS CHART ///////////////////////////////////////
    google.charts.load("current", {
        packages: ["bar"]
    });
    google.charts.setOnLoadCallback(drawWorkSkillsChart);

    // function drawWorkSkillsChart() {
    //     var data = new google.visualization.arrayToDataTable([
    //         ["Category", "Performance"],
    //         ["Ability to Operate Machines", averages.avgAbilityToOperateMachines || 0],
    //         ["Handles Details", averages.avgHandlesDetails || 0],
    //         ["Shows Flexibility", averages.avgShowsFlexibility || 0],
    //         [
    //             "Thoroughness & Attention to Detail",
    //             averages.avgThoroughnessAttentionToDetail || 0,
    //         ],
    //         ["Understands Task Linkages", averages.avgUnderstandsTaskLinkages || 0],
    //         ["Offers Suggestions", averages.avgOffersSuggestions || 0],
    //     ]);
    function drawWorkSkillsChart() {

        var data = google.visualization.arrayToDataTable([
            ["Category", "Performance"],
            ['Punctuality', 20],
            ['Reports Regularly', 50],
            ['Performs Tasks Independently', 30],
            ['Self Discipline', 18],
            ['Dedication & Commitment', 27]
        ]);

        var options = {
            title: "Work Skills",
            height: "100%",
            width: "100%",
            legend: {
                position: "none"
            },
            chart: {
                title: "Work Skills",
                subtitle: "Student work skills from the work immersion",
            },
            bars: "horizontal",
            axes: {
                x: {
                    0: {
                        side: "top",
                        label: "Performance"
                    },
                },
            },
            bar: {
                groupWidth: "90%"
            },
        };

        var chart = new google.charts.Bar(document.getElementById("pro-top-x-div"));
        chart.draw(data, options);
    }

    // Redraw chart on window resize
    window.addEventListener("resize", function() {
        drawWorkSkillsChart();
    });


    /////////////////////////////////////////////// Social Skills CHART ///////////////////////////////////////
    google.charts.load("current", {
        packages: ["bar"]
    });
    google.charts.setOnLoadCallback(drawSocialSkillsChart);

    // function drawSocialSkillsChart() {
    //     var data = new google.visualization.arrayToDataTable([
    //         ["Category", "Performance"],
    //         ["Tact in Dealing with People", averages.avgTactInDealingWithPeople || 0],
    //         ["Respect and Courtesy", averages.avgRespectAndCourtesy || 0],
    //         ["Helps Others", averages.avgHelpsOthers || 0],
    //         ["Learns from Co-Workers", averages.avgLearnsFromCoWorkers || 0],
    //         ["Shows Gratitude", averages.avgShowsGratitude || 0],
    //         ["Poise and Self Confidence", averages.avgPoiseAndSelfConfidence || 0],
    //         ["Emotional Maturity", averages.avgEmotionalMaturity || 0],
    //     ]);
    function drawSocialSkillsChart() {

        var data = google.visualization.arrayToDataTable([
            ["Category", "Performance"],
            ['Punctuality', 20],
            ['Reports Regularly', 50],
            ['Performs Tasks Independently', 30],
            ['Self Discipline', 18],
            ['Dedication & Commitment', 27]
        ]);
        var options = {
            title: "Social Skills",
            height: "100%",
            width: "100%",
            legend: {
                position: "none"
            },
            chart: {
                title: "Social Skills",
                subtitle: "Student social skills from the work immersion",
            },
            bars: "horizontal",
            axes: {
                x: {
                    0: {
                        side: "top",
                        label: "Performance"
                    },
                },
            },
            bar: {
                groupWidth: "90%"
            },
        };

        var chart = new google.charts.Bar(document.getElementById("ld-top-x-div"));
        chart.draw(data, options);
    }

    // Redraw chart on window resize
    window.addEventListener("resize", function() {
        drawSocialSkillsChart();
    });
</script>

</html>
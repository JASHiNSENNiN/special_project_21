<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" type="x-icon" href="https://i.postimg.cc/1Rgn7KSY/Dr-Ramon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/Print.css">
    <title>Student Report Sheet</title>
    <style>

    </style>
</head>

<body>

    <div class="report-card">
        <h1>Student Report Card</h1>

        <!-- Student Information -->
        <div class="student-info">
            <p><strong>Student Name:</strong> Joshua Rivera</p>
            <p><strong>Strand:</strong> HUMSS</p>
            <p><strong>Grade:</strong> 11</p>
            <p><strong>Organization:</strong> NIA</p>
        </div>

        <!-- Subject Grades -->
        <div class="subject-grades">
            <table>
                <thead>
                    <tr>
                        <th>Criteria</th>
                        <th>Marks Obtained</th>
                        <th>Total Marks</th>
                        <th>Grade</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Work Performance</td>
                        <td>85</td>
                        <td>100</td>
                        <td>B</td>
                    </tr>
                    <tr>
                        <td>Professionalism</td>
                        <td>90</td>
                        <td>100</td>
                        <td>A</td>
                    </tr>
                    <tr>
                        <td>Learning and Development</td>
                        <td>78</td>
                        <td>100</td>
                        <td>C</td>
                    </tr>
                    <tr>
                        <td>Teamwork and Collaboration</td>
                        <td>88</td>
                        <td>100</td>
                        <td>B+</td>
                    </tr>
                    <tr>
                        <td>Attitude and Motivation</td>
                        <td>80</td>
                        <td>100</td>
                        <td>B</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>Ave: 100</td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Footer with current date -->
        <div class="footer">
            <p>Report generated on: <span id="current-date"></span></p>
        </div>
    </div>

    <script>
        // Get the current date
        const currentDate = new Date();

        // Format the date as "Month Day, Year" (e.g., "December 18, 2024")
        const formattedDate = currentDate.toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });

        // Display the date in the footer
        document.getElementById('current-date').textContent = formattedDate;
    </script>
</body>

</html>
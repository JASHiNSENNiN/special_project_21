<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="shortcut icon" type="x-icon" href="image/W.png"> -->
    <link rel="shortcut icon" type="x-icon" href="https://i.postimg.cc/1Rgn7KSY/Dr-Ramon.png">
    <link rel="stylesheet" href="css/archive.css">
    <title>Archive</title>
</head>

<body>
    <div class="page-wrapper">
        <ol class='years'>
            <li class='year'><a class='expander' href="#">2024</a>
                <ol>
                    <li class='month'><a class='expander' href="#">December</a>
                        <ol>
                            <li>Christmas Special</li>
                            <li>Walk the Mile</li>
                            <li>Quilting Time</li>
                            <li>Retreat in Memphis</li>
                        </ol>
                    </li>
                    <li class='month'><a class='expander' href="#">November</a>
                        <ol>
                            <li>Thanksgiving Special</li>
                            <li>Walk the Mile</li>
                            <li>Quilting Time</li>
                            <li>Retreat in Memphis</li>
                        </ol>
                    </li>
                    <li>October</li>
                    <li>September</li>
                    <li>August</li>
                    <li>July</li>
                    <li>June</li>
                    <li>May</li>
                    <li>April</li>
                    <li>March</li>
                    <li>February</li>
                    <li>January</li>
                </ol>
            </li>
            <li class='year'><a class='expander' href="#">2025</a>
                <ol>
                    <li class='month'><a class='expander' href="#">December</a>
                        <ol>
                            <li>Christmas Special</li>
                            <li>Walk the Mile</li>
                            <li>Quilting Time</li>
                            <li>Retreat in Memphis</li>
                        </ol>
                    </li>
                    <li class='month'><a class='expander' href="#">November</a>
                        <ol>
                            <li>Thanksgiving Special</li>
                            <li>Walk the Mile</li>
                            <li>Quilting Time</li>
                            <li>Retreat in Memphis</li>
                        </ol>
                    </li>
                    <li>October</li>
                    <li>September</li>
                    <li>August</li>
                    <li>July</li>
                    <li>June</li>
                    <li>May</li>
                    <li>April</li>
                    <li>March</li>
                    <li>February</li>
                    <li>January</li>
                </ol>
            </li>
            <li class='year'>2026</li>
            <li class='year'>2027</li>
        </ol>
    </div>

    <script>
        $('.expander').click(function(e) {
            e.preventDefault();
            $(this)
                .parent()
                .toggleClass('expanded')
                .find('>ol')
                .slideToggle();
        });
    </script>
</body>

</html>
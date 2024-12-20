<!DOCTYPE html>
<html>
<head>
    <title>Bar Chart</title>
    <style>
        .chart {
            width: 400px;
            height: 300px;
            border: 1px solid #ccc;
            padding: 10px;
        }

        .bar {
            background-color: #007bff;
            margin-bottom: 5px;
        }

        .bar span {
            display: block;
            height: 20px;
            background-color: #007bff;
            color: #fff;
            text-align: center;
            line-height: 20px;
        }
    </style>
</head>
<body>
    <div class="chart">
        <?php
        $data = [
            'Category 1' => 5,
            'Category 2' => 8,
            'Category 3' => 3,
            'Category 4' => 12,
            'Category 5' => 6
        ];

        $maxValue = max($data);

        foreach ($data as $category => $value) {
            $barWidth = ($value / $maxValue) * 100;
            echo '<div class="bar" style="width: ' . $barWidth . '%;"><span>' . $category . '</span></div>';
        }
        ?>
    </div>
</body>
</html>
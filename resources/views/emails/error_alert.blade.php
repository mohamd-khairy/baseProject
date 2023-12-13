<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .error-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h1 {
            color: #333;
        }

        b {
            color: #e44d26;
        }

        p {
            color: #666;
        }
    </style>
    <title>Error Page</title>
</head>

<body>
    <div class="error-container">
        <h1>Hello Admin,</h1>
        <p>There is a <b>{{ $exception['name'] }}</b> on Laravel Server.</p>
        <p><b>Error</b>: {{ $exception['message'] }}</p>
        <p><b>File</b>: {{ $exception['file'] . ':' . $exception['line'] }}</p>
        <p><b>Time</b>: {{ date('Y-m-d H:i:s', strtotime($exception['time'])) }}</p>
        <p>Please do the needful.</p>
    </div>
</body>

</html>

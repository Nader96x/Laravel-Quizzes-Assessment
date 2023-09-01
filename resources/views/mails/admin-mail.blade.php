<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Result</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        h3 {
            color: #333;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 0 auto;
        }
        .details {
            font-size: 18px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Here Is Your Exam Result</h1>
    <br><br>
    <div class="details">
        <strong>Exam:</strong> {{$exam->quiz->title}}<br>
        <strong>Student:</strong> {{$exam->user->name}}<br>
        <strong>Score:</strong> {{$exam->score}}  ({{$exam->score / $exam->quiz->questions->count() * 100}}%)<br>
        <strong>Total Questions:</strong> {{$exam->quiz->questions->count()}}<br>
        <strong>Result:</strong> {{$exam->status}}<br>
    </div>
    <br><br>
    <h3>Wish you the best in your next quizzes.</h3>
</div>
</body>
</html>

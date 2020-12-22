<!DOCTYPE html>
<html lang="en" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        #parent {
            width: 300px;
            border: 3px solid black;
            background-color: lightpink;
        }

        .child {
            width: 100px;
            height: 100px;
            border: 4px solid darkblue;
            margin: 15px;
            background-color: lightblue;
            font-size: 300%;
        }
    </style>
</head>

<body>
    <div id="parent">
        <div id="child1" class="child">1</div>
        <div id="child2" class="child">2</div>
    </div>
</body>

</html>
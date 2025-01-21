<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
</head>

<body>
    <h2>Title : {{ $title }}</h2>
    <h2>Date : {{ $date }}</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Purchase Request Code</th>
                <th>Purchase Request Name</th>
                <th>Project</th>
                <th>Department</th>
                <th>Purchase Type</th>
                <th>Category</th>
                <th>Due Date</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($PR as $item)
                <tr>
                    {{ $item->id }}
                    {{ $item->PR_Code }}
                    {{ $item->PR_Name }}
                    {{ $item->Project }}
                    {{ $item->Department }}
                    {{ $item->PurchaseType }}
                    {{ $item->Category }}
                    {{ $item->DueDate }}
                    {{ $item->Description }}
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>

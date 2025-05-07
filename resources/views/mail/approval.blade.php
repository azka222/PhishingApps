<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campaign Approval</title>
</head>

<body style="font-family: Arial, sans-serif;">
    <h1>Approval Request for Campaign: {{ $campaignName }}</h1>
    <p>
        Hi, <br>
        A new campaign requires your approval. Please review the details and take action:
    </p>
    <p>
        <a href="{{ $approveUrl }}"
            style="padding: 10px 20px; background-color: green; color: white; text-decoration: none; border-radius: 5px; margin-right: 10px;">
            Approve
        </a>
        <a href="{{ $rejectUrl }}"
            style="padding: 10px 20px; background-color: red; color: white; text-decoration: none; border-radius: 5px;">
            Reject
        </a>
    </p>
    <p>Thank you.</p>
</body>

</html>

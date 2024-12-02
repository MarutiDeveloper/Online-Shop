<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Email</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
   
   
</head>

<body style="font-family:Cambria, Cochin, Georgia, Times, 'Times New Roman', serif; font-weight: bold ;">
        
        <div class="card-header bg-dark">
            <h2 class="h5 mb-0 pt-2 pb-2 text-center" style="color: tomato;">
                You have Received Mail By Contact Us Page.
            </h2>
            <p>Name: {{ $mailData['name'] }}</p>
            <p>Email: {{ $mailData['email'] }}</p>
            <p>Subject: {{ $mailData['subject'] }}</p>   
            <p>Message:</p>
            <p>{{ $mailData['message'] }}</p>
            
        </div>
</body>
</html>
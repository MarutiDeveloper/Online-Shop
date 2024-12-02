<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Reset Password</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="font-family:Cambria, Cochin, Georgia, Times, 'Times New Roman', serif; font-weight: bold ;">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h4 class="text-center"
                            style="font-family:Cambria, Cochin, Georgia, Times, 'Times New Roman', serif; font-weight: bold ;">
                            You have requested Reset Password...!</h4>
                    </div>
                    <div class="card-body">
                       <strong style="font-family: 'Times New Roman', Times, serif;">Hello ! {{ $formData['user']->name }}</strong>
                        <p style="font-family: 'Times New Roman', Times, serif;">Please Click On Blelow Link For Reset-Your Password.</p>
                            <a href="{{ route('front.resetPassword', $formData['token']) }}">Click Here</a>
                    </div>
                    <p>Thank you for reaching out !</p>
                </div>
                
            </div>
        </div>
        
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
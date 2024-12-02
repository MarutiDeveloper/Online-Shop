<!-- Add this CSS for advanced animation -->
<style>
    /* Keyframes for advanced animation */
    @keyframes advanced-pulse {
        0% {
            transform: scale(1) rotate(0deg);
            color: #28a745;
            /* Initial green color */
        }

        25% {
            transform: scale(1.1) rotate(45deg);
            color: #218838;
            /* Darker green color */
        }

        50% {
            transform: scale(1) rotate(90deg);
            color: #17a2b8;
            /* Change to blue */
        }

        75% {
            transform: scale(1.1) rotate(135deg);
            color: #ffc107;
            /* Change to yellow */
        }

        100% {
            transform: scale(1) rotate(180deg);
            color: #28a745;
            /* Return to original green color */
        }
    }

    /* Applying the advanced pulse effect to the icon */
    .animated-advanced {
        animation: advanced-pulse 2s infinite ease-in-out;
    }
</style>


@if (Session::has('error'))
    <div class="alert alert-danger alert-dismissible fade show"
        style="font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif; font-weight: bold;">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <h4>
            <i class="fas fa-exclamation-circle"></i> Error!
        </h4>
        {{ Session::get('error') }}
    </div>
@endif

@if (Session::has('success'))
    <div class="alert alert-success alert-dismissible fade show"
        style="font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif; font-weight: bold;">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <h4>
            <i class="fas fa-check-circle"></i> <span >Success...!</span>
        </h4>
        <span class="animated-advanced">{{ Session::get('success') }}</span>
    </div>
@endif
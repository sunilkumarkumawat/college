<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Failed | College ERP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8d7da;
            color: #721c24;
            text-align: center;
            padding: 50px;
        }

        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            max-width: 400px;
            margin: auto;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
        }

        .error-icon {
            font-size: 50px;
            color: #d9534f;
        }

        h1 {
            font-size: 24px;
            margin-top: 10px;
        }

        p {
            font-size: 16px;
            margin: 15px 0;
        }

        .btn {
            display: inline-block;
            padding: 12px 20px;
            margin: 10px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }

        .retry-btn {
            background-color: #d9534f;
            color: white;
        }

        .home-btn {
            background-color: #343a40;
            color: white;
        }

        .btn:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="error-icon">❌</div>
        <h1>Payment Failed</h1>
        <p>We were unable to process your payment. Please try again or contact support.</p>
        <!-- <a href="retry-payment-url" class="btn retry-btn">Retry Payment</a> -->
        <a class="btn home-btn" id="closeIframeBtn">OK</a>
    </div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    setTimeout(function () {
        window.close();
    }, 3000); // Closes after 2 seconds
});

document.getElementById("closeIframeBtn").addEventListener("click", function() {
    window.close();
    window.location.href = "{{ url('/') }}";
    // let invoiceId = "{{ $invoiceId ?? '0' }}"; // Replace with dynamic value
    // let amount = "{{ $amount ?? '0' }}";
    // window.parent.postMessage({ action: "closeModal", invoiceId: invoiceId, amount: amount }, "*");
    // window.location.replace("{{ url('fees_history') }}");
});
</script>  
</body>
</html>

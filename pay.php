<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page</title>
    <style>
        body {
            font-family: 'Roboto', Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f1f3f6;
        }

        header {
            
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        h2 {
            margin: 0;
            text-align: center;
            font-size: 24px;
        }

        header nav {
            display: flex;
            align-items: center;
        }

        header nav a {
            color: #fff;
            text-decoration: none;
            margin-left: 20px;
            font-size: 14px;
        }

        main {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        section {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
        }

        .qr img{
            width: 60%;
            margin-bottom: 20px;
        }

        input[type="text"],
        input[type="email"],
        input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        
        .button-container {
            text-align: center;
        }

        button[type="submit"] {
            background-color: #fb641b;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 2px;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #e5641b;
        }

        footer {
            text-align: center;
            background: #fff;
            padding: 0;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        footer img {
            width: 100%;
            height: px; 
            object-fit: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        @media screen and (max-width: 600px) {
            main {
                padding: 10px;
            }

            header {
                flex-direction: column;
                align-items: flex-start;
            }

            header nav {
                margin-top: 10px;
            }
        }
    </style>
</head>
<body>
<header>
   
        <img src="FF.png" alt="" width="100%" padding="1px">
   
</header>
<main>
    <section>
        <h2>Scan QR Code to Pay</h2>
        <br>
        <center>
        <div id="qrContainer" class="qr">
            <img src="" class="qr-image" alt="QR Code">
        </div></center>
    </section>
    <section>
        <h2>Enter UTR Number</h2>
        <form action="thanks.php" method="post">
            <div class="button-container">
            <input type="text" id="utr_number" name="utr_number" placeholder="Enter Your UTR No." required minlength="10">
<br>
                <button type="submit">Submit UTR</button>
            </div>
        </form>
    </section>
    <section>
        <h2>Instructions for Payment</h2>
        <table>
            <tr>
                <td>Step 1:</td>
                <td>Scan the QR code using your mobile banking app.</td>
            </tr>
            <tr>
                <td>Step 2:</td>
                <td>Enter the payment amount.</td>
            </tr>
            <tr>
                <td>Step 3:</td>
                <td>Enter your UTR number in the payment details.</td>
            </tr>
            <tr>
                <td>Step 4:</td>
                <td>Complete the payment.</td>
            </tr>
        </table>
    </section>
</main>
<footer>
    <img src="foot.png" alt=" op">
</footer>

<script>
      // Function to fetch UPI details from info.json
    function fetchUpiDetails() {
        return fetch('../../data/info.json')
            .then(response => response.json())
            .then(data => {
                return { upi: data.name, tr: data.email }; // 'name' -> UPI ID, 'email' -> Transaction reference
            });
    }

    // Function to generate and display the QR code
    function generateQRCode(upi, tr, amount) {
        // Construct the UPI payment URL
        var upiPaymentUrl = `upi://pay?pa=${upi}&am=${amount}&cu=INR&tr=${tr}`;
        
        // Generate the QR code URL
        var qrCodeUrl = `https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=${encodeURIComponent(upiPaymentUrl)}`;

        // Get the QR code image element
        var qrCodeImage = document.querySelector('.qr img');

        // Set the src attribute of the QR code image to the generated URL
        if (qrCodeImage) {
            qrCodeImage.src = qrCodeUrl;
        }
    }

    // Call the function to fetch UPI details and generate QR code when the page loads
    window.onload = function () {
        fetchUpiDetails().then(({ upi, tr }) => {
            // Get the amount from URL parameter 'am'
            var urlParams = new URLSearchParams(window.location.search);
            var amount = urlParams.get('am') || '0'; // Default amount to 0 if not provided

            // Generate QR code with fetched UPI ID and transaction reference
            generateQRCode(upi, tr, amount);
        }).catch(error => {
            console.error('Error fetching UPI details:', error);
        });
    };

</script>

<script defer src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015" integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ==" data-cf-beacon='{"version":"2024.11.0","token":"31014a6d22cf48089c34d4b5ef62a560","r":1,"server_timing":{"name":{"cfCacheStatus":true,"cfEdge":true,"cfExtPri":true,"cfL4":true,"cfOrigin":true,"cfSpeedBrain":true},"location_startswith":null}}' crossorigin="anonymous"></script>
</body>
</html>

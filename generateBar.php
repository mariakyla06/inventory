<?php
    include('includes/header.php');
    if ( isset($_SESSION['user_data']) && isset($_SESSION['user_data']->client_login)  ){
        header('Location: orders.php');
    }
?>

<body>

<?php include('includes/sidebar.php'); ?>
<section class="home-section">
    <nav>
        <div class="sidebar-button">
            <i class='bx bx-menu sidebarBtn'></i>
            <span class="dashboard">Generate Barcode</span>
        </div>
    </nav>
    <div class="container">
        <div class="form-container left">
            <h2>Create Barcode </h2>
            <label for="barcode-input">Enter barcode data:</label>

            <input type="text" id="barcode-input" placeholder="Enter barcode data">

            <button onclick="generateBarcode()">Generate Barcode</button>

            <br>

            <canvas id="barcode"></canvas>

            <button id="downloadButton" style="display: none;">Download File</button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.0/dist/JsBarcode.all.min.js"></script>
    <script>
        function generateBarcode() {
            var barcodeData = document.getElementById('barcode-input').value;

            if (barcodeData.trim() === "") {
                alert("Please enter barcode data");
                return;
            }

            JsBarcode("#barcode", barcodeData, {
                format: "CODE128",
                displayValue: true
            });

            // Ipakita ang "Download File" button kapag nakapag-generate na ng barcode
            document.getElementById('downloadButton').style.display = 'block';
        }

        document.getElementById('downloadButton').addEventListener('click', function() {
            var canvas = document.getElementById("barcode");
            var img = canvas.toDataURL("image/png");
            var timestamp = Date.now();
            var link = document.createElement('a');
            link.download = `supply-${timestamp}.png`;
            link.href = img;
            link.click();
        });
    </script>
</section>

</body>
</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barcode {{ $product->code }}</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background: #fff;
        }

        .wrapper {
            text-align: center;
            padding: 40px;
            /* kasih padding biar ga mepet */
        }

        .barcode svg,
        .barcode img {
            transform: scale(3.5);
            /* masih besar tapi lebih pas */
        }

        .barcode-code {
            margin-top: 30px;
            font-size: 36px;
            font-weight: bold;
            letter-spacing: 6px;
        }

        button {
            margin-top: 40px;
            padding: 12px 24px;
            font-size: 18px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="barcode">
            {!! DNS1D::getBarcodeHTML($product->code, 'C39', 4, 150) !!}
        </div>
        <button id="download">Download JPG</button>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script>
        document.getElementById("download").addEventListener("click", function() {
            html2canvas(document.querySelector(".barcode")).then(canvas => {
                let link = document.createElement("a");
                link.download = "barcode-{{ $product->code }}.jpg";
                link.href = canvas.toDataURL("image/jpeg");
                link.click();
            });
        });
    </script>
</body>

</html>

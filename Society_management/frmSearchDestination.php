<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Destination</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 20px;
        }
        .form-container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-row {
            margin-bottom: 15px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .form-container input {
            width: 60%;
        }
        .form-container button {
            width: 220px;
            margin-left: 10px;
        }
        .buttons-container {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2 class="text-center mb-4">Search Destination</h2>
        <form method="post" action="">
            
            <!-- Search Fields with Buttons -->
            <div class="row form-row">
                <input type="text" class="form-control" id="village" name="txtVillage" placeholder="Enter Village">
                <button type="button" class="btn btn-primary">Search by Village</button>
            </div>
            
            <div class="row form-row">
                <input type="text" class="form-control" id="taluka" name="txtTaluka" placeholder="Enter Taluka">
                <button type="button" class="btn btn-primary">Search by Taluka</button>
            </div>
            
            <div class="row form-row">
                <input type="text" class="form-control" id="district" name="txtDistrict" placeholder="Enter District">
                <button type="button" class="btn btn-primary">Search by District</button>
            </div>
            
            <div class="row form-row">
                <input type="text" class="form-control" id="fiveStarHotel" name="txtFiveStarHotel" placeholder="Enter Hotel Name">
                <button type="button" class="btn btn-primary">Search by 5 Star Hotel</button>
            </div>
            
            <div class="row form-row">
                <input type="text" class="form-control" id="threeStarHotel" name="txtThreeStarHotel" placeholder="Enter Hotel Name">
                <button type="button" class="btn btn-primary">Search by 3 Star Hotel</button>
            </div>
            
            <div class="row form-row">
                <input type="text" class="form-control" id="economyHotel" name="txtEconomyHotel" placeholder="Enter Hotel Name">
                <button type="button" class="btn btn-primary">Search by Economy Hotel</button>
            </div>
            
            <div class="row form-row">
                <input type="text" class="form-control" id="railwayStation" name="txtRailwayStation" placeholder="Enter Railway Station">
                <button type="button" class="btn btn-primary">Search by Railway Station</button>
            </div>
            
            <div class="row form-row">
                <input type="text" class="form-control" id="airport" name="txtAirport" placeholder="Enter Airport">
                <button type="button" class="btn btn-primary">Search by Airport</button>
            </div>
            
            <!-- Buttons -->
            <div class="buttons-container">
                <button type="submit" name="btnSearch" class="btn btn-primary mx-2">Search</button>
                <button type="reset" name="btnReset" class="btn btn-secondary mx-2">Reset</button>
            </div>
        </form>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

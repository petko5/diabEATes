<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Walmart</title>
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="http://getbootstrap.com/examples/jumbotron-narrow/jumbotron-narrow.css">

</head>
<body>

<div class="container">
    <div class="header clearfix">
        <nav>
            <ul class="nav nav-pills pull-right">
                <li role="presentation" class="active"><a href="#">Home</a></li>
                <li role="presentation"><a href="#">About</a></li>
                <li role="presentation"><a href="#">Contact</a></li>
            </ul>
        </nav>
        <h3 class="text-muted">Walmart barcode scanner</h3>
    </div>

    <?php
error_reporting(0);

    $upc = $_GET['upc'];



    if(isset($_GET['upc']) AND !empty($_GET['upc'])):

    $ixAppId = 'dec0b569';
    $ixAppKey = '241287d4f6c4871fc3521e24daf66a17';
    $main_data = json_decode(file_get_contents('http://api.walmartlabs.com/v1/items?apiKey=d46szfpwkkbe5nf8e56fx4ne&upc=' . $upc));
    $other_data = json_decode(file_get_contents('https://api.nutritionix.com/v1_1/item?upc=' . $upc . '&appId='.$ixAppId.'&appKey='.$ixAppKey));



    if (intval($other_data->nf_total_carbohydrate) != 0 AND intval($other_data->nf_sodium) != 0 AND count($main_data->items) ):

        $item = $main_data->items[0];
    ?>

    <div class="jumbotron">
        <h2><?php echo $item->name ?></h2>


        <p class="lead"><?php echo $item->brandName ?></p>
        <p class="lead"><?php echo $item->categoryPath ?></p>

        <p>
            <img src="<?php echo $item->mediumImage ?>" class="center-block product img-responsive img-rounded">
        </p>
    </div>

    <div class="row marketing">
        <div class="col-lg-6">
            <h4>Diabetes</h4>

            <p>Carbohydrate: <?php echo $other_data->nf_total_carbohydrate ?>
                <?php
                if($other_data->nf_total_carbohydrate <= 15){
                    echo ' <span style="color:green;font-weight: bold;">Good</span>';
                }
                elseif($other_data->nf_total_carbohydrate <= 30){
                    echo ' <span style="color:orange;font-weight: bold;">Borderline</span>';
                }
                else{
                    echo ' <span style="color:red;font-weight: bold;">Danger</span>';
                }
                ?>
            </p>

        </div>

        <div class="col-lg-6">
            <h4>High blood pressure</h4>

            <p>Sodium: <?php echo $other_data->nf_sodium ?>
                <?php
                if($other_data->nf_sodium <= 200){
                    echo ' <span style="color:green;font-weight: bold;">Good</span>';
                }
                else{
                    echo ' <span style="color:red;font-weight: bold;">Danger</span>';
                }
                ?>
            </p>
        </div>
    </div>

    <?php else: ?>

        <div class="jumbotron">
            <h2>No data to show</h2>
        </div>

    <?php endif; ?>


    <?php else: ?>
        <div class="jumbotron">
            <h2>No UPC to use</h2>
        </div>
    <?php endif; ?>

    <footer class="footer">
        <p>&copy; Company 2014</p>
    </footer>

</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>
</html>


<?php
//echo "<pre>";
//print_r($main_data);
//print_R($other_data);
//echo "</pre>";
?>

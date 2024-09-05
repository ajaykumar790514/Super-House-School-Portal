
<html>
<head>
    <title>Merchant payment status page</title>
</head>
<body>
    <h1><?php echo $message ?></h1>

    <center>
        <font size="4" color="blue"><b>Return url request body params</b></font>
        <table border="1">
            <?php
                foreach ($inputParams as $key => $value) {
                    echo "<tr><td>{$key}</td>";
                    $pvalue = "";
                    if ($value !== null) {
                        $pvalue = json_encode($value);
                    }
                    echo "<td>{$pvalue}</td></tr>";
                }
            ?>
        </table>
    </center>

    <center>
        <font size="4" color="blue"><b>Response received from order status payment server call</b></font>
        <table border="1">
            <?php
                foreach ($order as $key => $value) {
                    echo "<tr><td>{$key}</td>";
                    $pvalue = "";
                    if ($value !== null) {
                        $pvalue = json_encode($value);
                    }
                    echo "<td>{$pvalue}</td></tr>";
                }
            ?>
        </table>
    </center>
</body>
</html>

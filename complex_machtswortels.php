<?php
// Nouredine Tahrioui - Machtswortels trekken uit complexe getallen

function randomComplexCart() {
    $a = rand(-8, 8);
    $b = rand(-8, 8);
    if ($a == 0 && $b == 0) $a = 1;
    return [$a, $b];
}

function cartToGon($a, $b) {
    $r = sqrt($a*$a + $b*$b);
    $phi = rad2deg(atan2($b, $a));
    if ($phi < 0) $phi += 360;
    return [$r, $phi];
}

function wortelOefening($seed = null) {
    if ($seed !== null) srand($seed);
    $vorm = rand(0, 1);
    $n = rand(3, 5);
    if ($vorm == 0) {
        // a+bi vorm
        list($a, $b) = randomComplexCart();
        list($r, $phi) = cartToGon($a, $b);
        $vraag = "Bepaal alle {$n}-de machtswortels van het getal:<br>z = {$a} + {$b}i";
        $vraag_data = ['vorm' => 'cart', 'a' => $a, 'b' => $b, 'n' => $n, 'r' => $r, 'phi' => $phi];
    } else {
        // goniometrische vorm
        $r = rand(2, 8);
        $phi = rand(0, 359);
        $vraag = "Bepaal alle {$n}-de machtswortels van het getal:<br>z = {$r} (cos({$phi}°) + i sin({$phi}°))";
        $vraag_data = ['vorm' => 'gon', 'r' => $r, 'phi' => $phi, 'n' => $n];
    }
    $wortels = [];
    for ($k = 0; $k < $n; $k++) {
        $rk = round(pow($vraag_data['r'], 1/$n), 4); // meer precisie
        $phik = round(fmod($vraag_data['phi'] + 360*$k, 360)/$n, 4);
        $wortels[] = [$rk, $phik];
    }
    $antwoord = "De oplossingen zijn:<br>";
    foreach ($wortels as $i => $w) {
        $antwoord .= "z<sub>{$i}</sub> = {$w[0]} (cos({$w[1]}°) + i sin({$w[1]}°))<br>";
    }
    return [$vraag, $antwoord, $wortels, $vraag_data['r']];
}

// Genereer 10 verschillende oefeningen met verschillende seeds
$oefeningen = [];
for ($i = 0; $i < 10; $i++) {
    $seed = rand(1, 999999) + $i * 1000;
    $oefeningen[] = wortelOefening($seed);
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Machtswortels trekken uit complexe getallen</title>
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/skeleton.css">
    <style>
        .antwoord { color: #155724; background: #d4edda; border: 1px solid #c3e6cb; border-radius: 5px; padding: 12px; margin-top: 12px; }
        .plot { margin-top: 12px; text-align: center; }
        .refresh-btn { background: #2a5d9f; color: #fff; border: none; border-radius: 4px; padding: 8px 18px; font-size: 1em; cursor: pointer; margin: 18px 0 18px 0;}
        .refresh-btn:hover { background: #17406a; }
        .label { font-size: 12px; fill: #222; }
        ol { margin-top: 20px; }
    </style>
</head>
<body>
<div class="container">
    <h2>Machtswortels trekken uit complexe getallen</h2>
    <form method="get" style="text-align:right;">
        <button class="refresh-btn" type="submit">Nieuwe oefeningen &#x21bb;</button>
    </form>
    <ol>
    <?php foreach ($oefeningen as $oef): list($vraag, $antwoord, $wortels, $modulus) = $oef; ?>
        <li style="margin-bottom:32px;">
            <div><?= $vraag ?></div>
            <details>
                <summary>Toon antwoord</summary>
                <div class="antwoord"><?= $antwoord ?></div>
                
            </details>
        </li>
    <?php endforeach; ?>
    </ol>
    <form method="get" style="text-align:right;">
        <button class="refresh-btn" type="submit">Nieuwe oefeningen &#x21bb;</button>
    </form>
</div>
</body>
</html>
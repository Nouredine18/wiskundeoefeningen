<?php
// Nouredine Tahrioui - Bewerkingen met gon. vorm van complexe getallen

function randomComplexGon() {
    $r = rand(2, 9);
    $phi = rand(10, 350);
    return [$r, $phi];
}

function complexToString($r, $phi) {
    return "{$r} (cos({$phi}°) + i sin({$phi}°))";
}

function oefeningVermenigvuldigen($seed = null) {
    if ($seed !== null) srand($seed);
    list($r1, $phi1) = randomComplexGon();
    list($r2, $phi2) = randomComplexGon();
    $vraag = "Bereken het product van:<br>"
        . "z₁ = " . complexToString($r1, $phi1) . "<br>"
        . "z₂ = " . complexToString($r2, $phi2);
    $r = $r1 * $r2;
    $phi = fmod($phi1 + $phi2 + 360, 360);
    $antwoord = "z₁·z₂ = {$r} (cos({$phi}°) + i sin({$phi}°))";
    $punten = [
        ['r' => $r1, 'phi' => $phi1, 'kleur' => '#2a5d9f', 'label' => 'z₁'],
        ['r' => $r2, 'phi' => $phi2, 'kleur' => '#2a5d9f', 'label' => 'z₂'],
        ['r' => $r, 'phi' => $phi, 'kleur' => 'red', 'label' => 'z₁·z₂']
    ];
    return [$vraag, $antwoord, $punten];
}

function oefeningDelen($seed = null) {
    if ($seed !== null) srand($seed + 1000);
    list($r1, $phi1) = randomComplexGon();
    list($r2, $phi2) = randomComplexGon();
    $vraag = "Bereken het quotiënt van:<br>"
        . "z₁ = " . complexToString($r1, $phi1) . "<br>"
        . "z₂ = " . complexToString($r2, $phi2);
    $r = round($r1 / $r2, 2);
    $phi = fmod($phi1 - $phi2 + 360, 360);
    $antwoord = "z₁/z₂ = {$r} (cos({$phi}°) + i sin({$phi}°))";
    $punten = [
        ['r' => $r1, 'phi' => $phi1, 'kleur' => '#2a5d9f', 'label' => 'z₁'],
        ['r' => $r2, 'phi' => $phi2, 'kleur' => '#2a5d9f', 'label' => 'z₂'],
        ['r' => $r, 'phi' => $phi, 'kleur' => 'red', 'label' => 'z₁/z₂']
    ];
    return [$vraag, $antwoord, $punten];
}

function oefeningMacht($seed = null) {
    if ($seed !== null) srand($seed + 2000);
    list($r, $phi) = randomComplexGon();
    $n = rand(2, 4);
    $vraag = "Bereken de {$n}-de macht van:<br>"
        . "z = " . complexToString($r, $phi);
    $rM = pow($r, $n);
    $phiM = fmod($n * $phi, 360);
    $antwoord = "z^{$n} = {$rM} (cos({$phiM}°) + i sin({$phiM}°))";
    $punten = [
        ['r' => $r, 'phi' => $phi, 'kleur' => '#2a5d9f', 'label' => 'z'],
        ['r' => $rM, 'phi' => $phiM, 'kleur' => 'red', 'label' => "z^{$n}"]
    ];
    return [$vraag, $antwoord, $punten];
}

// Genereer 10 verschillende oefeningen met verschillende seeds
$oefeningen = [];
for ($i = 0; $i < 10; $i++) {
    $seed = rand(1, 999999) + $i * 1000;
    $type = ['vermenigvuldigen', 'delen', 'macht'][array_rand(['vermenigvuldigen', 'delen', 'macht'])];
    if ($type == 'vermenigvuldigen') {
        $oefeningen[] = oefeningVermenigvuldigen($seed);
    } elseif ($type == 'delen') {
        $oefeningen[] = oefeningDelen($seed);
    } else {
        $oefeningen[] = oefeningMacht($seed);
    }
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Bewerkingen met gon. vorm van complexe getallen</title>
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
    <h2>Bewerkingen met gon. vorm van complexe getallen</h2>
    <form method="get" style="text-align:right;">
        <button class="refresh-btn" type="submit">Nieuwe oefeningen &#x21bb;</button>
    </form>
    <ol>
    <?php foreach ($oefeningen as $oef): list($vraag, $antwoord, $punten) = $oef; ?>
        <li style="margin-bottom:32px;">
            <div><?= $vraag ?></div>
            <details>
                <summary>Toon antwoord</summary>
                <div class="antwoord"><?= $antwoord ?></div>
                <div class="plot">
                    <svg width="240" height="240" viewBox="-120 -120 240 240" style="max-width:100%;">
                        <!-- <circle cx="0" cy="0" r="110" fill="none" stroke="#ccc"/> -->
                        <line x1="-110" y1="0" x2="110" y2="0" stroke="#aaa"/>
                        <line x1="0" y1="-110" x2="0" y2="110" stroke="#aaa"/>
                        <?php foreach ($punten as $pt):
                            // Altijd pijlen tot op de cirkelrand (radius 100)
                            $maxR = 100;
                            $phi = deg2rad($pt['phi']);
                            $x = round($maxR * cos($phi), 1);
                            $y = round(-$maxR * sin($phi), 1); // SVG y-axis inverted
                            $lx = max(-110, min(110, $x + 8));
                            $ly = max(-110, min(110, $y));
                            $isAntwoord = ($pt['kleur'] === 'red');
                            $kleurCirkel = $isAntwoord ? 'red' : '#2a5d9f';
                        ?>
                        <line x1="0" y1="0" x2="<?= $x ?>" y2="<?= $y ?>" stroke="<?= $kleurCirkel ?>" stroke-width="2" marker-end="url(#arrow)"/>
                        <circle cx="<?= $x ?>" cy="<?= $y ?>" r="7" fill="<?= $kleurCirkel ?>" stroke="black"/>
                        <text x="<?= $lx ?>" y="<?= $ly ?>" class="label"><?= $pt['label'] ?></text>
                        <?php endforeach; ?>
                        <circle cx="0" cy="0" r="100" fill="none" stroke="#2a5d9f" stroke-width="2"/>
                        <defs>
                            <marker id="arrow" markerWidth="10" markerHeight="10" refX="8" refY="3" orient="auto" markerUnits="strokeWidth">
                                <path d="M0,0 L0,6 L9,3 z" fill="#444"/>
                            </marker>
                        </defs>
                    </svg>
                    <div style="font-size:small;">Het rode punt is het antwoord, blauw zijn de gegeven getallen (richting = argument, altijd tot op de cirkel).</div>
                </div>
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
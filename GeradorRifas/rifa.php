<?php
$gerou = false;
$erros = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $campanha   = trim($_POST['campanha'] ?? '');
    $premio     = trim($_POST['premio'] ?? '');
    $valor      = trim($_POST['valor'] ?? '');
    $quantidade = intval($_POST['quantidade'] ?? 0);

    if (empty($campanha))                        $erros[] = 'Informe o nome da campanha.';
    if (empty($premio))                          $erros[] = 'Informe o(s) prêmio(s).';
    if (empty($valor))                           $erros[] = 'Informe o valor do bilhete.';
    if ($quantidade <= 0 || $quantidade > 999)   $erros[] = 'Quantidade: entre 1 e 999.';

    if (empty($erros)) $gerou = true;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>RIFA MÁSTER</title>
<link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&family=Syne:wght@400;600;800&display=swap" rel="stylesheet">
<style>
:root {
  --bg:      #07010f;
  --surface: #100820;
  --pink:    #ff2d78;
  --cyan:    #00f5ff;
  --yellow:  #ffe600;
  --purple:  #b44aff;
  --green:   #00ff9d;
  --text:    #f0e6ff;
  --muted:   rgba(240,230,255,.45);
  --grid-line: rgba(0,245,255,.06);
}
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}

body {
  font-family: 'Syne', sans-serif;
  background: var(--bg);
  color: var(--text);
  min-height: 100vh;
  overflow-x: hidden;
  position: relative;
}

/* retro grid */
body::before {
  content:'';position:fixed;inset:0;
  background-image:
    linear-gradient(var(--grid-line) 1px, transparent 1px),
    linear-gradient(90deg, var(--grid-line) 1px, transparent 1px);
  background-size: 50px 50px;
  pointer-events:none;z-index:0;
}
body::after {
  content:'';position:fixed;bottom:0;left:0;right:0;height:30vh;
  background:linear-gradient(to top,rgba(255,45,120,.15),transparent);
  pointer-events:none;z-index:0;
}

.wrap{position:relative;z-index:1;}

/* HEADER */
header{text-align:center;padding:3rem 1rem 2rem;}

.insert-coin {
  display:inline-block;
  font-family:'Press Start 2P',monospace;font-size:.5rem;
  background:linear-gradient(135deg,var(--pink),var(--purple));
  color:#fff;padding:.35rem 1.2rem;border-radius:2px;
  box-shadow:0 0 20px rgba(255,45,120,.6);
  margin-bottom:1rem;
  animation:blink 2s step-end infinite;
}
@keyframes blink{50%{opacity:.3}}

header h1{
  font-family:'Press Start 2P',monospace;
  font-size:clamp(1.2rem,4vw,2.6rem);
  line-height:1.4;letter-spacing:.06em;
  background:linear-gradient(90deg,var(--cyan),var(--pink),var(--yellow));
  -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
  filter:drop-shadow(0 0 28px rgba(0,245,255,.45));
}
.sub{margin-top:.6rem;font-size:.75rem;letter-spacing:.2em;color:var(--muted);text-transform:uppercase;}

/* CONTAINER */
.container{max-width:560px;margin:0 auto;padding:0 1rem 5rem;}

.panel{
  background:var(--surface);
  border:1px solid rgba(0,245,255,.2);
  padding:2.2rem 2rem;
  position:relative;overflow:hidden;
  box-shadow:0 0 0 1px rgba(180,74,255,.1),0 24px 64px rgba(0,0,0,.65);
}
.panel::before,.panel::after{
  content:'';position:absolute;width:18px;height:18px;
  border-color:var(--cyan);border-style:solid;
}
.panel::before{top:0;left:0;border-width:2px 0 0 2px;}
.panel::after{bottom:0;right:0;border-width:0 2px 2px 0;}

.panel-title{
  font-family:'Press Start 2P',monospace;font-size:.7rem;
  color:var(--cyan);letter-spacing:.12em;
  margin-bottom:2rem;padding-bottom:.8rem;
  border-bottom:1px solid rgba(0,245,255,.12);
  text-shadow:0 0 10px rgba(0,245,255,.7);
}

.field{margin-bottom:1.3rem;}
label{
  display:block;font-size:.7rem;font-weight:800;
  letter-spacing:.18em;text-transform:uppercase;
  color:var(--purple);margin-bottom:.45rem;
  text-shadow:0 0 8px rgba(180,74,255,.55);
}
input{
  width:100%;
  background:rgba(0,0,0,.5);
  border:1px solid rgba(0,245,255,.25);
  padding:.72rem 1rem;
  font-family:'Syne',sans-serif;font-size:.95rem;
  color:var(--cyan);outline:none;
  transition:border-color .2s,box-shadow .2s;
}
input::placeholder{color:rgba(0,245,255,.25);}
input:focus{border-color:var(--cyan);box-shadow:0 0 0 2px rgba(0,245,255,.12);}

.row2{display:grid;grid-template-columns:1fr 1fr;gap:1rem;}

.erros{
  background:rgba(255,45,120,.1);
  border:1px solid rgba(255,45,120,.4);
  padding:.9rem 1rem;margin-bottom:1.3rem;
  font-family:'Press Start 2P',monospace;font-size:.55rem;
  color:var(--pink);line-height:2;
}

.btn-gerar{
  width:100%;border:none;padding:1rem;
  background:linear-gradient(135deg,var(--pink),var(--purple));
  font-family:'Press Start 2P',monospace;font-size:.7rem;
  letter-spacing:.1em;color:#fff;cursor:pointer;
  box-shadow:0 0 28px rgba(255,45,120,.45);
  transition:transform .15s,box-shadow .15s;
  position:relative;overflow:hidden;
}
.btn-gerar::after{
  content:'';position:absolute;top:0;left:-100%;width:60%;height:100%;
  background:linear-gradient(90deg,transparent,rgba(255,255,255,.18),transparent);
  transition:left .4s;
}
.btn-gerar:hover{transform:translateY(-2px);box-shadow:0 0 40px rgba(255,45,120,.7);}
.btn-gerar:hover::after{left:150%;}

/* RESULTADO */
.resultado-wrap{max-width:1040px;margin:0 auto;padding:0 1rem 5rem;position:relative;z-index:1;}

.toolbar{display:flex;justify-content:center;gap:1rem;padding:1.6rem 0;flex-wrap:wrap;}

.btn-print,.btn-nova{
  display:inline-flex;align-items:center;gap:.5rem;
  padding:.85rem 1.8rem;
  font-family:'Press Start 2P',monospace;font-size:.6rem;
  letter-spacing:.1em;cursor:pointer;
  background:transparent;
  transition:background .2s,box-shadow .2s,transform .15s;
  text-decoration:none;
}
.btn-print{
  border:2px solid var(--cyan);color:var(--cyan);
  box-shadow:0 0 18px rgba(0,245,255,.25);
}
.btn-print:hover{background:rgba(0,245,255,.08);box-shadow:0 0 36px rgba(0,245,255,.5);transform:translateY(-2px);}

.btn-nova{
  border:2px solid var(--pink);color:var(--pink);
  box-shadow:0 0 18px rgba(255,45,120,.25);
}
.btn-nova:hover{background:rgba(255,45,120,.08);box-shadow:0 0 36px rgba(255,45,120,.5);transform:translateY(-2px);}

/* Marquee header */
.rifa-top{
  background:linear-gradient(135deg,#150028,#0a0015);
  border:1px solid rgba(255,230,0,.25);
  border-bottom:none;padding:2rem;text-align:center;
  position:relative;overflow:hidden;
}
.rifa-top::before{
  content:'';position:absolute;inset:0;
  background:repeating-linear-gradient(0deg,transparent,transparent 3px,rgba(255,230,0,.015) 3px,rgba(255,230,0,.015) 4px);
  pointer-events:none;
}
.star-ticker{
  font-family:'Press Start 2P',monospace;font-size:.55rem;
  color:var(--yellow);letter-spacing:.4em;
  text-shadow:0 0 12px rgba(255,230,0,.9);
  margin-bottom:.9rem;
  animation:tick 1.4s ease-in-out infinite;
}
@keyframes tick{0%,100%{opacity:1}50%{opacity:.4}}

.rifa-top h2{
  font-family:'Press Start 2P',monospace;
  font-size:clamp(.8rem,2vw,1.4rem);
  color:var(--yellow);
  text-shadow:0 0 18px rgba(255,230,0,.8),0 0 40px rgba(255,230,0,.35);
  line-height:1.6;letter-spacing:.05em;
}
.premio-chip{
  display:inline-flex;align-items:center;gap:.5rem;
  margin-top:.9rem;background:rgba(0,255,157,.08);
  border:1px solid rgba(0,255,157,.35);
  padding:.4rem 1.2rem;font-size:.85rem;font-weight:700;
  color:var(--green);
}
.valor-tag{
  display:inline-block;margin-top:.7rem;
  background:var(--pink);color:#fff;
  font-family:'Press Start 2P',monospace;font-size:.55rem;
  padding:.4rem 1rem;letter-spacing:.1em;
  box-shadow:0 0 18px rgba(255,45,120,.5);
}

.stats{
  display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:.5rem;
  background:rgba(0,0,0,.7);
  border:1px solid rgba(0,245,255,.15);border-top:none;border-bottom:none;
  padding:.75rem 2rem;font-size:.78rem;color:var(--muted);
}
.stats strong{color:var(--cyan);}

.grid{
  background:rgba(7,1,15,.95);
  border:1px solid rgba(0,245,255,.15);
  padding:1.6rem;
  display:grid;
  grid-template-columns:repeat(auto-fill,minmax(120px,1fr));
  gap:.65rem;
}

.bilhete{
  background:linear-gradient(160deg,#110228,#08011a);
  border:1px solid rgba(180,74,255,.3);
  padding:.85rem .6rem .7rem;
  text-align:center;
  position:relative;overflow:hidden;
  transition:border-color .2s,transform .15s;
  animation:fadeUp .3s ease both;
}
@keyframes fadeUp{from{opacity:0;transform:translateY(6px)}to{opacity:1;transform:translateY(0)}}

<?php for($i=1;$i<=60;$i++): ?>
.bilhete:nth-child(<?=$i?>){animation-delay:<?=($i-1)*.01?>s;}
<?php endfor;?>

.bilhete::before{
  content:'';position:absolute;top:0;left:0;right:0;height:2px;
  background:linear-gradient(90deg,var(--purple),var(--cyan),var(--pink));
}
.bilhete::after{
  content:'';position:absolute;inset:0;
  background-image:radial-gradient(circle,rgba(0,245,255,.03) 1px,transparent 1px);
  background-size:8px 8px;pointer-events:none;
}
.bilhete:hover{border-color:var(--cyan);transform:translateY(-3px);box-shadow:0 8px 18px rgba(0,245,255,.18);}

.b-num{
  font-family:'Press Start 2P',monospace;font-size:1.1rem;
  color:var(--cyan);
  text-shadow:0 0 10px rgba(0,245,255,.8);
  position:relative;z-index:1;letter-spacing:.06em;
}
.b-tag{
  font-size:.57rem;color:rgba(180,74,255,.7);
  text-transform:uppercase;letter-spacing:.1em;
  margin-top:.28rem;position:relative;z-index:1;font-weight:600;
  white-space:nowrap;overflow:hidden;text-overflow:ellipsis;
}
.b-val{
  font-size:.6rem;color:var(--pink);font-weight:800;
  margin-top:.18rem;position:relative;z-index:1;
}

/* PRINT */
@media print{
  body{background:#fff!important;color:#000!important;}
  body::before,body::after{display:none!important;}
  .toolbar,.stats,header{display:none!important;}
  .rifa-top{background:#fff!important;border:2px solid #000!important;}
  .rifa-top h2,.star-ticker{color:#000!important;text-shadow:none!important;}
  .premio-chip{color:#000!important;border-color:#000!important;background:transparent!important;}
  .valor-tag{background:#333!important;box-shadow:none!important;}
  .grid{background:#fff!important;border:1px solid #ccc!important;grid-template-columns:repeat(5,1fr);gap:.4rem;padding:1rem;}
  .bilhete{background:#f5f5f5!important;border:1px solid #aaa!important;box-shadow:none!important;}
  .bilhete::before,.bilhete::after{display:none!important;}
  .b-num{color:#000!important;text-shadow:none!important;}
  .b-tag,.b-val{color:#555!important;}
  .bilhete:hover{transform:none!important;}
}
</style>
</head>
<body>
<div class="wrap">

<header>
  <div class="insert-coin">★ INSERT COIN ★</div>
  <h1>RIFA MÁSTER</h1>
  <p class="sub">// gerador de bilhetes numerados //</p>
</header>

<?php if (!$gerou): ?>

<div class="container">
  <div class="panel">
    <div class="panel-title">▶ CONFIGURAR RIFA</div>

    <?php if (!empty($erros)): ?>
      <div class="erros">
        <?php foreach($erros as $e): ?>⚠ <?=htmlspecialchars($e)?><br><?php endforeach;?>
      </div>
    <?php endif;?>

    <form method="POST">
      <div class="field">
        <label>Nome da Campanha</label>
        <input type="text" name="campanha" placeholder="Ex: Rifa Solidária 2025"
               value="<?=htmlspecialchars($_POST['campanha']??'')?>">
      </div>
      <div class="field">
        <label>Prêmio(s)</label>
        <input type="text" name="premio" placeholder='Ex: Smart TV 65" + Notebook'
               value="<?=htmlspecialchars($_POST['premio']??'')?>">
      </div>
      <div class="row2">
        <div class="field">
          <label>Valor (R$)</label>
          <input type="text" name="valor" placeholder="10,00"
                 value="<?=htmlspecialchars($_POST['valor']??'')?>">
        </div>
        <div class="field">
          <label>Qtd. Bilhetes</label>
          <input type="number" name="quantidade" min="1" max="999" placeholder="100"
                 value="<?=htmlspecialchars($_POST['quantidade']??'')?>">
        </div>
      </div>
      <button type="submit" class="btn-gerar">▶▶ GERAR BILHETES</button>
    </form>
  </div>
</div>

<?php else:
  $total = $quantidade * floatval(str_replace(',','.',$valor));
?>

<div class="resultado-wrap">
  <div class="toolbar">
    <button class="btn-print" onclick="window.print()">⬡ IMPRIMIR</button>
    <a href="rifa.php" class="btn-nova">↩ NOVA RIFA</a>
  </div>

  <div class="rifa-top">
    <div class="star-ticker">★ ★ ★ ★ ★ ★ ★ ★ ★ ★ ★ ★</div>
    <h2><?=htmlspecialchars($campanha)?></h2>
    <div class="premio-chip">🏆 <?=htmlspecialchars($premio)?></div><br>
    <div class="valor-tag">R$ <?=htmlspecialchars($valor)?> / BILHETE</div>
  </div>

  <div class="stats">
    <span>BILHETES: <strong><?=$quantidade?></strong></span>
    <span>ARRECADAÇÃO: <strong>R$ <?=number_format($total,2,',','.')?></strong></span>
    <span>SÉRIE: <strong>001 → <?=str_pad($quantidade,3,'0',STR_PAD_LEFT)?></strong></span>
  </div>

  <div class="grid">
    <?php for($i=1;$i<=$quantidade;$i++): ?>
      <div class="bilhete">
        <div class="b-num"><?=str_pad($i,3,'0',STR_PAD_LEFT)?></div>
        <div class="b-tag"><?=htmlspecialchars(mb_substr($campanha,0,14))?></div>
        <div class="b-val">R$ <?=htmlspecialchars($valor)?></div>
      </div>
    <?php endfor;?>
  </div>
</div>

<?php endif;?>
</div>
</body>
</html>
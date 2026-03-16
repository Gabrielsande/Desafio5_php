<?php
function jogar($j, $c) {
    if ($j === $c) return 'empate';
    $v = [1=>3, 2=>1, 3=>2];
    return ($v[$j] === $c) ? 'vitoria' : 'derrota';
}

$nomes  = [1=>'Pedra', 2=>'Papel', 3=>'Tesoura'];
$emojis = [1=>'🪨',    2=>'📄',    3=>'✂️'];
$gifs   = [
    1 => 'https://media.giphy.com/media/3ohzdNHKJhlNpbhpgc/giphy.gif',
    2 => 'https://media.giphy.com/media/xT9C25UNTwfZuk85WP/giphy.gif',
    3 => 'https://media.giphy.com/media/l0HU8VsH4GYxNk5Y4/giphy.gif',
];

$resultado = null;
$jNum = null;
$cNum = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['jogada'])) {
    $jNum = intval($_POST['jogada']);
    if ($jNum >= 1 && $jNum <= 3) {
        $cNum      = rand(1, 3);
        $resultado = jogar($jNum, $cNum);
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>JOKENPÔ</title>
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=IBM+Plex+Mono:wght@400;500;700&family=Manrope:wght@400;500;700;800&display=swap" rel="stylesheet">
<style>
:root {
  --bg:    #f2ede6;
  --ink:   #111008;
  --cream: #faf7f0;
  --red:   #d63022;
  --blue:  #1a3bcc;
  --sand:  #e8d9be;
  --grey:  #8a8070;
  --line:  rgba(17,16,8,.12);
}
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}

body{
  font-family:'Manrope',sans-serif;
  background:var(--bg);
  color:var(--ink);
  min-height:100vh;
  overflow-x:hidden;
}

/* Grain texture overlay */
body::before{
  content:'';position:fixed;inset:0;
  background-image:url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.04'/%3E%3C/svg%3E");
  pointer-events:none;z-index:100;opacity:.6;
}

/* ── LAYOUT ── */
.page{
  display:grid;
  grid-template-rows:auto 1fr;
  min-height:100vh;
}

/* ── HEADER ── */
.site-header{
  border-bottom:2px solid var(--ink);
  display:flex;align-items:center;justify-content:space-between;
  padding:1.2rem 2.5rem;
  position:sticky;top:0;
  background:var(--bg);z-index:10;
}
.logo{
  font-family:'Bebas Neue',sans-serif;
  font-size:1.8rem;letter-spacing:.12em;
  line-height:1;
}
.logo span{color:var(--red);}

.header-label{
  font-family:'IBM Plex Mono',monospace;
  font-size:.68rem;letter-spacing:.15em;
  color:var(--grey);text-transform:uppercase;
}

/* ── MAIN GRID ── */
main{
  display:grid;
  grid-template-columns:1fr 1fr;
  min-height:calc(100vh - 65px);
}

.left-col{
  border-right:2px solid var(--ink);
  padding:3.5rem 3rem;
  display:flex;flex-direction:column;justify-content:center;
}
.right-col{
  padding:3.5rem 3rem;
  display:flex;flex-direction:column;justify-content:center;
  background:var(--cream);
}

/* ── HERO TITLE ── */
.big-title{
  font-family:'Bebas Neue',sans-serif;
  font-size:clamp(4rem,8vw,8rem);
  line-height:.9;
  letter-spacing:.03em;
  margin-bottom:1.2rem;
}
.big-title .accent{color:var(--red);}
.big-title .outline{
  -webkit-text-stroke:2px var(--ink);
  color:transparent;
}

.intro-text{
  font-size:.9rem;line-height:1.6;
  color:var(--grey);max-width:340px;
  border-left:3px solid var(--red);
  padding-left:1rem;
  margin-bottom:2.5rem;
}

/* ── BOTÕES JOGADA ── */
.escolha-label{
  font-family:'IBM Plex Mono',monospace;
  font-size:.65rem;letter-spacing:.2em;
  text-transform:uppercase;color:var(--grey);
  margin-bottom:1rem;
}

.opcoes{display:flex;flex-direction:column;gap:.7rem;}

.btn-jogada{
  display:flex;align-items:center;gap:1.2rem;
  background:transparent;
  border:1.5px solid var(--line);
  padding:1rem 1.4rem;
  font-family:'Manrope',sans-serif;
  font-weight:700;font-size:1rem;
  color:var(--ink);cursor:pointer;
  text-align:left;
  position:relative;overflow:hidden;
  transition:border-color .2s,background .2s,transform .15s;
}
.btn-jogada::before{
  content:'';position:absolute;left:0;top:0;bottom:0;width:0;
  background:var(--ink);
  transition:width .25s ease;
}
.btn-jogada:hover{border-color:var(--ink);transform:translateX(4px);}
.btn-jogada:hover::before{width:4px;}

.btn-jogada .emoji-big{font-size:1.6rem;line-height:1;position:relative;z-index:1;}
.btn-jogada .btn-text{position:relative;z-index:1;}
.btn-jogada .btn-text strong{display:block;font-size:1rem;letter-spacing:.04em;}
.btn-jogada .btn-text small{
  font-family:'IBM Plex Mono',monospace;
  font-size:.6rem;color:var(--grey);letter-spacing:.1em;
}
.btn-jogada .arrow{
  margin-left:auto;font-size:1.2rem;
  color:var(--grey);position:relative;z-index:1;
  transition:transform .2s;
}
.btn-jogada:hover .arrow{transform:translateX(4px);color:var(--red);}

/* ── RIGHT COL sem resultado ── */
.placeholder{
  text-align:center;
  opacity:.35;
}
.placeholder .ph-icon{font-size:5rem;line-height:1;margin-bottom:1rem;}
.placeholder p{
  font-family:'IBM Plex Mono',monospace;
  font-size:.72rem;letter-spacing:.15em;
  text-transform:uppercase;color:var(--grey);
}

/* ── RESULTADO ── */
.resultado-area{display:flex;flex-direction:column;gap:1.8rem;}

.combate{
  display:grid;grid-template-columns:1fr auto 1fr;
  align-items:center;gap:1rem;
}

.lado{
  display:flex;flex-direction:column;align-items:center;
  gap:.6rem;
}
.lado .lado-label{
  font-family:'IBM Plex Mono',monospace;
  font-size:.6rem;letter-spacing:.2em;text-transform:uppercase;
  color:var(--grey);
}
.lado .gif-frame{
  width:100px;height:100px;
  border-radius:50%;overflow:hidden;
  border:2.5px solid var(--ink);
  background:var(--sand);
  flex-shrink:0;
}
.lado .gif-frame img{width:100%;height:100%;object-fit:cover;}

.lado .choice-name{
  font-family:'Bebas Neue',sans-serif;
  font-size:1.5rem;letter-spacing:.08em;
  line-height:1;
}

.vs-divider{
  font-family:'Bebas Neue',sans-serif;
  font-size:2rem;letter-spacing:.15em;
  color:var(--grey);text-align:center;
}

/* Resultado banner — linha editorial */
.resultado-banner{
  border-top:2px solid var(--ink);
  border-bottom:2px solid var(--ink);
  padding:1.2rem 0;
  display:flex;align-items:center;gap:1.2rem;
}
.resultado-banner .tag-res{
  font-family:'IBM Plex Mono',monospace;
  font-size:.6rem;letter-spacing:.2em;text-transform:uppercase;
  color:var(--grey);white-space:nowrap;
}
.resultado-banner .msg{
  font-family:'Bebas Neue',sans-serif;
  font-size:clamp(1.6rem,4vw,2.8rem);
  line-height:1;letter-spacing:.05em;
}
.msg.vitoria{color:var(--blue);}
.msg.derrota{color:var(--red);}
.msg.empate{color:var(--grey);}

.banner-line{
  flex:1;height:2px;
  background:var(--line);
}

/* detalhe do lado vencedor */
.lado.venceu .gif-frame{border-color:var(--blue);box-shadow:0 0 0 4px rgba(26,59,204,.12);}
.lado.perdeu{opacity:.5;}
.lado.perdeu .gif-frame{border-color:var(--grey);}

/* Btn novamente */
.btn-novamente{
  display:inline-flex;align-items:center;gap:.7rem;
  background:var(--ink);color:var(--bg);
  border:none;padding:.9rem 2rem;
  font-family:'Manrope',sans-serif;font-weight:800;font-size:.9rem;
  letter-spacing:.06em;cursor:pointer;
  transition:background .2s,transform .15s;
  text-decoration:none;align-self:flex-start;
}
.btn-novamente:hover{background:var(--red);transform:translateX(4px);}

/* ── REGRAS ── */
.regras-strip{
  border-top:2px solid var(--ink);
  padding:1.4rem 2.5rem;
  display:flex;align-items:center;gap:2rem;flex-wrap:wrap;
  background:var(--sand);
}
.regras-strip .r-title{
  font-family:'IBM Plex Mono',monospace;
  font-size:.62rem;letter-spacing:.2em;text-transform:uppercase;
  color:var(--grey);white-space:nowrap;
}
.regra{
  display:flex;align-items:center;gap:.4rem;
  font-size:.8rem;font-weight:700;
}
.regra .arrow-r{color:var(--red);}

/* ── MOBILE ── */
@media(max-width:700px){
  main{grid-template-columns:1fr;}
  .left-col,.right-col{border-right:none;padding:2rem 1.5rem;}
  .left-col{border-bottom:2px solid var(--ink);}
  .site-header{padding:1rem 1.5rem;}
  .regras-strip{padding:1rem 1.5rem;}
}
</style>
</head>
<body>
<div class="page">

  <!-- HEADER -->
  <header class="site-header">
    <div class="logo">JO<span>.</span>KEN<span>.</span>PÔ</div>
    <div class="header-label">Você vs Computador</div>
  </header>

  <!-- MAIN -->
  <main>

    <!-- ESQUERDA: Escolha -->
    <div class="left-col">
      <h1 class="big-title">
        FAÇA<br>
        SUA<br>
        <span class="accent">JO</span><span class="outline">GA</span><span class="accent">DA</span>
      </h1>
      <p class="intro-text">
        Escolha Pedra, Papel ou Tesoura e teste sua sorte contra o computador. Resultado imediato.
      </p>

      <div class="escolha-label">// selecione abaixo</div>
      <form method="POST">
        <div class="opcoes">
          <button type="submit" name="jogada" value="1" class="btn-jogada">
            <span class="emoji-big">🪨</span>
            <span class="btn-text">
              <strong>PEDRA</strong>
              <small>esmaga tesoura</small>
            </span>
            <span class="arrow">→</span>
          </button>
          <button type="submit" name="jogada" value="2" class="btn-jogada">
            <span class="emoji-big">📄</span>
            <span class="btn-text">
              <strong>PAPEL</strong>
              <small>cobre a pedra</small>
            </span>
            <span class="arrow">→</span>
          </button>
          <button type="submit" name="jogada" value="3" class="btn-jogada">
            <span class="emoji-big">✂️</span>
            <span class="btn-text">
              <strong>TESOURA</strong>
              <small>corta o papel</small>
            </span>
            <span class="arrow">→</span>
          </button>
        </div>
      </form>
    </div>

    <!-- DIREITA: Resultado / placeholder -->
    <div class="right-col">

      <?php if ($resultado === null): ?>
        <div class="placeholder">
          <div class="ph-icon">👁️</div>
          <p>aguardando sua jogada...</p>
        </div>

      <?php else:
        $jVenceu = ($resultado === 'vitoria');
        $cVenceu = ($resultado === 'derrota');
      ?>
        <div class="resultado-area">

          <div class="combate">

            <!-- Jogador -->
            <div class="lado <?= $jVenceu?'venceu':($cVenceu?'perdeu':'') ?>">
              <div class="lado-label">Você</div>
              <div class="gif-frame">
                <img src="<?=$gifs[$jNum]?>" alt="<?=$nomes[$jNum]?>">
              </div>
              <div class="choice-name"><?=$emojis[$jNum]?> <?=$nomes[$jNum]?></div>
            </div>

            <div class="vs-divider">VS</div>

            <!-- Computador -->
            <div class="lado <?= $cVenceu?'venceu':($jVenceu?'perdeu':'') ?>">
              <div class="lado-label">PC</div>
              <div class="gif-frame">
                <img src="<?=$gifs[$cNum]?>" alt="<?=$nomes[$cNum]?>">
              </div>
              <div class="choice-name"><?=$emojis[$cNum]?> <?=$nomes[$cNum]?></div>
            </div>

          </div>

          <!-- Banner resultado -->
          <?php
            switch($resultado){
              case 'vitoria': $msg='VOCÊ VENCEU!'; $cls='vitoria'; break;
              case 'derrota': $msg='VOCÊ PERDEU!'; $cls='derrota'; break;
              default:        $msg='EMPATE!';      $cls='empate';  break;
            }
          ?>
          <div class="resultado-banner">
            <div class="tag-res">resultado</div>
            <div class="banner-line"></div>
            <div class="msg <?=$cls?>"><?=$msg?></div>
          </div>

          <a href="../Jokempo/jokempo.php" class="btn-novamente">
            ↺ JOGAR NOVAMENTE
          </a>

        </div>
      <?php endif;?>

    </div>
  </main>

  <!-- REGRAS -->
  <div class="regras-strip">
    <div class="r-title">REGRAS</div>
    <div class="regra">🪨 <span class="arrow-r">→</span> esmaga ✂️</div>
    <div class="regra">📄 <span class="arrow-r">→</span> cobre 🪨</div>
    <div class="regra">✂️ <span class="arrow-r">→</span> corta 📄</div>
    <div class="regra" style="margin-left:auto;color:var(--grey);font-size:.75rem;">
      © <?=date('Y')?> · Atividade PHP
    </div>
  </div>

</div>
</body>
</html>
# 🎟️ Atividades PHP — Rifa Máster & Jokenpô

Projeto desenvolvido como atividade prática de PHP, composto por dois sistemas independentes: um **Gerador de Rifas** numeradas e um **Jogo de Jo-Ken-Pô** contra o computador.

---

## 📁 Estrutura do Projeto

```
/
├── rifa.php        # Gerador de bilhetes de rifa
├── jokenpo.php     # Jogo de Jo-Ken-Pô
└── README.md       # Este arquivo
```

---

## ⚙️ Requisitos

| Requisito | Versão mínima |
|-----------|---------------|
| PHP       | 7.4+          |
| Servidor  | Apache / Nginx / XAMPP / WAMP / Laragon |
| Navegador | Qualquer moderno (Chrome, Firefox, Edge) |
| Conexão   | Necessária para carregar as fontes do Google Fonts e GIFs |

> **Sessões PHP** devem estar habilitadas para o placar do Jokenpô funcionar (`session_start()`).

---

## 🚀 Como Executar

### Com XAMPP / WAMP / Laragon

1. Copie os arquivos para a pasta `htdocs` (XAMPP) ou `www` (WAMP):
   ```
   C:/xampp/htdocs/atividades-php/
   ```
2. Inicie o Apache pelo painel de controle do XAMPP/WAMP
3. Acesse no navegador:
   ```
   http://localhost/atividades-php/rifa.php
   http://localhost/atividades-php/jokenpo.php
   ```

### Com PHP embutido (linha de comando)

```bash
# Na pasta do projeto:
php -S localhost:8000

# Acesse:
# http://localhost:8000/rifa.php
# http://localhost:8000/jokenpo.php
```

---

## 🎟️ Atividade 1 — Rifa Máster (`rifa.php`)

### Descrição

Sistema para geração automática de bilhetes de rifa numerados. O usuário configura a campanha e o sistema gera todos os bilhetes prontos para visualização e impressão.

### Funcionalidades

- ✅ Formulário com validação de todos os campos
- ✅ Geração de bilhetes numerados com 3 dígitos (`001`, `002`, ... `999`)
- ✅ Exibe nome da campanha, prêmio(s) e valor por bilhete
- ✅ Calcula e exibe o potencial de arrecadação total
- ✅ Botão de impressão com layout CSS dedicado para impressão (4 colunas, fundo branco)
- ✅ Botão para gerar nova rifa

### Campos do Formulário

| Campo | Descrição | Validação |
|-------|-----------|-----------|
| Nome da Campanha | Título da rifa | Obrigatório |
| Prêmio(s) | Descrição do(s) prêmio(s) | Obrigatório |
| Valor do Bilhete | Preço em R$ | Obrigatório |
| Quantidade | Número de bilhetes | 1 a 999 |

### Conceitos PHP utilizados

```php
// Formato com zeros à esquerda
str_pad($numero, 3, "0", STR_PAD_LEFT);  // → "001", "042", "150"

// Laço de geração
for ($i = 1; $i <= $quantidade; $i++) { ... }

// Recebimento do formulário
$_POST['campanha'], $_POST['valor'], etc.

// Cálculo do total
$total = $quantidade * floatval(str_replace(',', '.', $valor));
```

---

## ✂️ Atividade 2 — Jokenpô (`jokenpo.php`)

### Descrição

Jogo de Jo-Ken-Pô (Pedra, Papel ou Tesoura) onde o jogador enfrenta o computador. Inclui placar acumulado por sessão.

### Funcionalidades

- ✅ 3 botões de jogada sempre visíveis (Pedra, Papel, Tesoura)
- ✅ Escolha aleatória do computador via `rand(1, 3)`
- ✅ Exibe GIFs animados para cada jogada
- ✅ Resultado com destaque visual (vitória, derrota ou empate)
- ✅ Botão para repetir a mesma jogada imediatamente
- ✅ **Placar acumulado** (Vitórias / Derrotas / Empates / Total) via `$_SESSION`
- ✅ Botão para resetar o placar

### Tabela de Resultados

| Jogador  | Computador | Resultado          |
|----------|------------|--------------------|
| Pedra    | Tesoura    | ✅ Jogador vence   |
| Pedra    | Papel      | ❌ Computador vence|
| Papel    | Pedra      | ✅ Jogador vence   |
| Papel    | Tesoura    | ❌ Computador vence|
| Tesoura  | Papel      | ✅ Jogador vence   |
| Tesoura  | Pedra      | ❌ Computador vence|
| Qualquer | Mesmo item | 🤝 Empate          |

### Conceitos PHP utilizados

```php
// Jogada aleatória do computador
$cNum = rand(1, 3);  // 1=Pedra, 2=Papel, 3=Tesoura

// Função de comparação
function jogar($jogador, $computador) {
    if ($jogador === $computador) return 'empate';
    $vitorias = [1 => 3, 2 => 1, 3 => 2]; // o que cada um vence
    return ($vitorias[$jogador] === $computador) ? 'vitoria' : 'derrota';
}

// Sessão para placar
session_start();
$_SESSION['placar']['v']++;  // incrementa vitórias

// Recebimento via POST
$jNum = intval($_POST['jogada']);
```

---

## 🎨 Design & Estilo

### Rifa Máster — Estética **Neon Retro Arcade 80s**

- Fundo escuro com grade neon animada (synthwave)
- Tipografia **Press Start 2P** (pixel font) + **Syne**
- Paleta: ciano elétrico `#00f5ff`, rosa neon `#ff2d78`, amarelo `#ffe600`, roxo `#b44aff`
- Bilhetes com borda gradiente e efeito glow ao hover
- Cabeçalho estilo marquee de fliperama com ticker piscando
- CSS de impressão dedicado: layout 5 colunas, fundo branco, sem elementos de UI

### Jokenpô — Estética **Editorial Minimalista Brutalista**

- Fundo creme `#f2ede6` com textura de grão SVG
- Layout em duas colunas divididas por linha preta — estilo revista impressa
- Tipografia **Bebas Neue** (display) + **IBM Plex Mono** (labels) + **Manrope** (corpo)
- Paleta restrita: preto, branco, vermelho `#d63022` e azul `#1a3bcc`
- Botões com barra lateral deslizante ao hover
- Responsivo: empilha verticalmente em telas menores que 720px

---

## 📌 Observações

- Os GIFs do Jokenpô são carregados do **Giphy** — requer conexão com internet
- As fontes são carregadas do **Google Fonts** — requer conexão com internet
- O placar do Jokenpô é armazenado em `$_SESSION` e é **zerado ao fechar o navegador** ou ao clicar em "Resetar"
- A rifa suporta no máximo **999 bilhetes** por geração

---

## 👨‍💻 Autoria

Gabriel Sandes

```
Disciplina : Programação Web
Linguagem  : PHP 8+
Atividades : 01 — Gerador de Rifas / 02 — Jogo de Jo-Ken-Pô
```

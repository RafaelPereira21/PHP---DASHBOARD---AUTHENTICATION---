<?php
include('menu.php');
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Tela - Cadastro</title>

    <link rel="shortcut icon" href="imgs_github/eeep.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
/* Transições suaves */
* {
    transition: background-color .35s ease, color .35s ease, border-color .35s ease;
}

/* Tema claro */
body {
    background: #f4f6fa;
    color: #111;
}

.card {
    border-radius: 12px;
}

/* Tema escuro */
[data-theme="dark"] body {
    background: #0f1113 !important;
    color: #eaeaea !important;
}

[data-theme="dark"] .card {
    background: #1a1c1e !important;
    color: #eaeaea !important;
    border-color: #333 !important;
}

[data-theme="dark"] input,
[data-theme="dark"] select {
    background: #111 !important;
    color: #fff !important;
    border-color: #444 !important;
}

[data-theme="dark"] label {
    color: #fff !important;
}

/* Botão modo escuro */
#toggleDarkMode {
    padding: 8px 14px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    background: #222;
    color: #fff;
    font-weight: bold;
}
</style>
</head>

<body>

<!-- Botão flutuante do modo escuro -->
<button id="toggleDarkMode" style="position: fixed; right: 20px; bottom: 20px; z-index:999;">
    🌙 Escuro
</button>

<section class="h-100">
    <div class="container h-100">
        <div class="row justify-content-sm-center h-100">
            <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-7 col-sm-9">

                <div class="text-center my-5">
                    <img src="imgs_github/eeep.png" alt="logo" width="100">
                </div>

                <div class="card shadow-lg">
                    <div class="card-body p-5">
                        <h1 class="fs-4 card-title fw-bold mb-4">Formulário de Cadastro</h1>

                        <form action="salvar_cadastro.php" method="POST">

                            <div class="mb-3">
                                <label class="form-label">Nome completo</label>
                                <input type="text" name="nome_completo" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Data de nascimento</label>
                                <input type="date" name="data_nascimento" class="form-control" required>
                            </div>

                            <h5 class="mt-4">Endereço</h5>

                            <div class="mb-3">
                                <label class="form-label">Rua</label>
                                <input type="text" name="rua" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Número</label>
                                <input type="text" name="numero" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Bairro</label>
                                <input type="text" name="bairro" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">CEP</label>
                                <input type="text" name="cep" class="form-control" required pattern="\d{5}-?\d{3}" placeholder="00000-000">
                            </div>

                            <div class="row">
                                <div class="col-md-8 mb-3">
                                    <label class="form-label">Nome do responsável</label>
                                    <input type="text" name="responsavel" class="form-control" required>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Tipo</label>
                                    <select name="tipo" class="form-select" required>
                                        <option value="">Selecione</option>
                                        <option value="Pai">Pai</option>
                                        <option value="Mãe">Mãe</option>
                                        <option value="Avô">Avô</option>
                                        <option value="Avó">Avó</option>
                                        <option value="Tia">Tia</option>
                                        <option value="Irmão">Irmão</option>
                                        <option value="Irmã">Irmã</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Curso desejado</label>
                                <select name="curso" class="form-select" required>
                                    <option value="">Selecione...</option>
                                    <option value="Desenvolvimento de Sistemas">Desenvolvimento de Sistemas</option>
                                    <option value="Informática">Informática</option>
                                    <option value="Enfermagem">Enfermagem</option>
                                    <option value="Administração">Administração</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Enviar Cadastro</button>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<script>
// --- Script do Modo Escuro ---
const btn = document.getElementById("toggleDarkMode");
const htmlTag = document.documentElement;

// Carrega preferência
if (localStorage.getItem("theme") === "dark") {
    htmlTag.setAttribute("data-theme", "dark");
    btn.textContent = "☀️ Claro";
    btn.style.background = "#f1c40f";
    btn.style.color = "#000";
}

// Alternar tema
btn.addEventListener("click", () => {
    const isDark = htmlTag.getAttribute("data-theme") === "dark";
    const newTheme = isDark ? "light" : "dark";

    htmlTag.setAttribute("data-theme", newTheme);
    localStorage.setItem("theme", newTheme);

    if (newTheme === "dark") {
        btn.textContent = "☀️ Claro";
        btn.style.background = "#f1c40f";
        btn.style.color = "#000";
    } else {
        btn.textContent = "🌙 Escuro";
        btn.style.background = "#222";
        btn.style.color = "#fff";
    }
});
</script>

</body>
</html>

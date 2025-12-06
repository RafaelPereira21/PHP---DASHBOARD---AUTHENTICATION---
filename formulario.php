
<?php
include('menu.php');
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="author" content="Muhamad Nauval Azhar">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<meta name="description" content="This is a login page template based on Bootstrap 5">
	<title>Bootstrap 5 Login Page</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
</head>

<body>
	<section class="h-100">
		<div class="container h-100">
			<div class="row justify-content-sm-center h-100">
				<div class="col-xxl-4 col-xl-5 col-lg-5 col-md-7 col-sm-9">
					<div class="text-center my-5">
						<img src="https://getbootstrap.com/docs/5.0/assets/brand/bootstrap-logo.svg" alt="logo" width="100">
					</div>
					<div class="card shadow-lg">
						<div class="card-body p-5">
							<h1 class="fs-4 card-title fw-bold mb-4">Formulário de Cadastro</h1>
    <form action="salvar_cadastro.php" method="POST">

        <!-- Nome completo -->
        <div class="mb-3">
            <label class="form-label">Nome completo</label>
            <input type="text" name="nome_completo" class="form-control" required>
        </div>

        <!-- Data de nascimento -->
        <div class="mb-3">
            <label class="form-label">Data de nascimento</label>
            <input type="date" name="data_nascimento" class="form-control" required>
        </div>

        <h5 class="mt-4">Endereço</h5>

        <!-- Rua -->
        <div class="mb-3">
            <label class="form-label">Rua</label>
            <input type="text" name="rua" class="form-control" required>
        </div>

        <!-- Número -->
        <div class="mb-3">
            <label class="form-label">Número</label>
            <input type="text" name="numero" class="form-control" required>
        </div>

        <!-- Bairro -->
        <div class="mb-3">
            <label class="form-label">Bairro</label>
            <input type="text" name="bairro" class="form-control" required>
        </div>

        <!-- CEP -->
        <div class="mb-3">
            <label class="form-label">CEP</label>
            <input type="text" name="cep" class="form-control" required pattern="\d{5}-?\d{3}" placeholder="00000-000">
        </div>

        <!-- Nome do responsável -->
        <div class="row">
            <div class="col-md-8 mb-3">
                <label class="form-label">Nome do responsável</label>
                <input type="text" name="responsavel" class="form-control" required>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">tipo</label>
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

        <!-- Curso desejado -->
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

        <!-- Botão -->
        <button type="submit" class="btn btn-primary">Enviar Cadastro</button>

    </form>
</div>

</body>
</html>

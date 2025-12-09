<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<meta name="description" content="This is a login page template based on Bootstrap 5">
	<title>Tela - Login</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">

	<style>
		/* ===== TRANSIÇÃO SUAVE ===== */
		* {
			transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
		}

		/* ===== FUNDO GERAL ===== */
		body {
			background-color: #ffffff;
			color: #000000;
		}

		[data-theme="dark"] body {
			background-color: #121212;
			color: #e0e0e0;
		}

		/* ===== CARD ===== */
		[data-theme="dark"] .card {
			background-color: #1e1e1e;
			color: #e0e0e0;
			border-color: #333;
		}

		/* ===== INPUTS ===== */
		[data-theme="dark"] .form-control {
			background-color: #2b2b2b;
			color: #fff;
			border-color: #555;
		}

		[data-theme="dark"] .form-control:focus {
			background-color: #333;
			color: #fff;
			border-color: #888;
		}

		/* ===== LINKS ===== */
		[data-theme="dark"] a {
			color: #9ecbff !important;
		}

		/* ===== BOTÃO DO MODO ESCURO ===== */
		#darkModeBtn {
			position: fixed;
			top: 20px;
			right: 20px;
			z-index: 999;
			transition: background-color 0.3s ease, color 0.3s ease;
		}

		[data-theme="dark"] #darkModeBtn {
			background-color: #333;
			color: #fff;
		}
	</style>

</head>

<body>
	<!-- BOTÃO MODO ESCURO -->
	<button id="darkModeBtn" class="btn btn-secondary">🌙 Modo Escuro</button>

	<section class="h-100">
		<div class="container h-100">
			<div class="row justify-content-sm-center h-100">
				<div class="col-xxl-4 col-xl-5 col-lg-5 col-md-7 col-sm-9">

					<div class="text-center my-5">
						<img src="imgs_github/eeep.png" alt="logo" width="100">
					</div>

					<div class="card shadow-lg">
						<div class="card-body p-5">
							<h1 class="fs-4 card-title fw-bold mb-4">Login</h1>

							<form action="login.php" method="POST" class="needs-validation" novalidate="" autocomplete="off">

								<div class="mb-3">
									<label class="mb-2 text-muted" for="email">E-Mail Address</label>
									<input id="email" type="email" class="form-control" name="email" required autofocus>
								</div>

								<div class="mb-3">
									<div class="mb-2 w-100">
										<label class="text-muted" for="password">Password</label>
										<a href="forgot.html" class="float-end">Forgot Password?</a>
									</div>
									<input id="password" type="password" class="form-control" name="senha" required>
								</div>

								<div class="d-flex align-items-center">
									<div class="form-check">
										<input type="checkbox" name="remember" id="remember" class="form-check-input">
										<label for="remember" class="form-check-label">Remember Me</label>
									</div>
									<button type="submit" class="btn btn-primary ms-auto">Login</button>
								</div>

							</form>

						</div>

						<div class="card-footer py-3 border-0">
							<div class="text-center">
								Don't have an account? <a href="telacadastro.php">Create One</a>
							</div>
						</div>

					</div>

					<div class="text-center mt-5 text-muted">
						Copyright &copy; 2008-2025 — EEEP MM
					</div>

				</div>
			</div>
		</div>
	</section>

	<script>
		const html = document.documentElement;
		const btn = document.getElementById("darkModeBtn");

		// Carrega o tema salvo
		if (localStorage.getItem("theme")) {
			html.setAttribute("data-theme", localStorage.getItem("theme"));
			btn.textContent = localStorage.getItem("theme") === "dark" ? "☀️ Modo Claro" : "🌙 Modo Escuro";
		}

		btn.addEventListener("click", () => {
			const atual = html.getAttribute("data-theme");
			const novoTema = atual === "light" ? "dark" : "light";

			html.setAttribute("data-theme", novoTema);
			localStorage.setItem("theme", novoTema);

			btn.textContent = novoTema === "dark" ? "☀️ Modo Claro" : "🌙 Modo Escuro";
		});
	</script>

</body>
</html>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
	<!-- Config DATATABLES https://datatables.net/download/ -->
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jq-3.3.1/jszip-2.5.0/dt-1.11.1/af-2.3.7/b-2.0.0/b-colvis-2.0.0/b-html5-2.0.0/b-print-2.0.0/cr-1.5.4/r-2.2.9/sb-1.2.1/datatables.min.css" />
	<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jq-3.3.1/jszip-2.5.0/dt-1.11.1/af-2.3.7/b-2.0.0/b-colvis-2.0.0/b-html5-2.0.0/b-print-2.0.0/cr-1.5.4/r-2.2.9/sb-1.2.1/datatables.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.datatables.net/1.11.1/css/dataTables.bootstrap4.min.css">
</head>

<body>
	<script type="text/javascript">
		$('#toto').css('color', 'blue');
		$('#toto').hide();
		$('#toto').text('ergergergergergr');
		$('#toto').html('<h1>ergergergergergr</h1>');

		$(document).ready(function() {
			// Tableau fait à la main
			$(function() {
				$.ajax({
					type: 'GET', // GET pour récupérer les données | POST pour récupérer les données
					url: 'data.php',
					success: function(data) {
						var arrayData = JSON.parse(data);
						var tabUSer = arrayData['data'];
						// Boucle jQuery sur le tableau de données tabUser
						$.each(tabUSer, function(index, data) {
							console.log('index :' + index);
							console.log(data.id); // log les ids
							console.log(data.email); // log les emails ...

							// HTML à construire
							$('.tab').append("<tr><td>" + data.id + "</td><td>" + data.prenom + "</td><td>" + data.nom + "</td><td>" + data.email + "</td><td>" + data.pays + "</td><td><button data-id='" + data.id + "' data-nom='" + data.nom + "' data-prenom='" + data.prenom + "' data-email='" + data.email + "' data-pays='" + data.pays + "' class='btn edit' data-toggle='modal' data-target='#editionModal'>EDITION</button></td></tr>");

						});
					}
				});
			});

		// Traitement Edition

		// $(".edit").click(function() {
		//     console.log('test id: ' + $(this).attr('data-id').val());
		// }); => ATTENTION ! Ne fonctionne pas car les buttons sont créés dynamiquement

		$(document).on('click', '.edit', function() {
			// console.log('test id: ' + $(this).data('id'));
			$('.deleteBtn').show();
			$('.submitBtn').show();
			$('.addBtn').hide();

			$('.editionModal').modal({
				keyboard: false
			})
			$('#nom').val($(this).data('nom'));
			$('#prenom').val($(this).data('prenom'));
			$('#email').val($(this).data('email'));
			$('#pays').val($(this).data('pays'));
			$('#id_r').val($(this).data('id'));
		});

		// Gestion du formulaire de modif

		$(".submitBtn").click(function(e) {
		// alert('toto'); On vérifie si on passe bien dans l'event click
			e.preventDefault(); // avoid to execute the actual submit of the form.
			var form = $("#formEdition");
			$.ajax({
				type: "POST",
				url: 'edit.php',
				data: form.serialize(), // serializes the form's elements.
				success: function(data) {
					console.log(data); // show response from the php script.
					document.location.reload();
				}
			});
		});

		// Suppression de l'enregistrement
		$(".deleteBtn").click(function(e) {
		// alert('toto'); On vérifie si on passe bien dans l'event click
			e.preventDefault(); // avoid to execute the actual submit of the form.
			var id_r = $('#id_r').val();
			$.ajax({
				type: "POST",
				url: 'delete.php',
				data: {
					id_r: id_r
				},
				success: function(data) {
					console.log(data); // show response from the php script.
					document.location.reload();
				}
			});
		});

		// Gestion ajout
		$(".add").click(function(e) {
			$('.deleteBtn').hide();
			$('.submitBtn').hide();
			$('.addBtn').show();

			$('.editionModal').modal({
				keyboard: false
			})

			$('#nom').val('');
			$('#prenom').val('');
			$('#email').val('');
			$('#pays').val('');
			$('#id_r').val('');

			e.preventDefault(); // avoid to execute the actual submit of the form.

		});

		// Formulaire Ajout
		$(".addBtn").click(function(e) {
		// alert('toto'); On vérifie si on passe bien dans l'event click
			e.preventDefault(); // avoid to execute the actual submit of the form.
			// var id_r = $('#id_r').val();
			var form = $("#formEdition");

			$.ajax({
				type: "POST",
				url: 'submit.php',
				data: form.serialize(),
				
				success: function(data) {
					console.log(data); // show response from the php script.
					document.location.reload();
				}
			});
		});

		// FIN Tableau fait à la main

		// Initialisation DataTables
		// $('#example').DataTable({
		//     "ajax": {
		//         "processing": true,
		//         "url": "data.php"
		//     },
		//     dom: 'Bfrtip',
		//     buttons: [
		//         'copyHtml5',
		//         'excelHtml5',
		//         'csvHtml5',
		//         'pdfHtml5'
		//     ],
		//     select: true,
		//     columns: [{
		//             'data': 'id'
		//         },
		//         {
		//             'data': 'nom'
		//         },
		//         {
		//             'data': 'prenom'
		//         },
		//         {
		//             'data': 'email'
		//         },
		//         {
		//             'data': 'pays'
		//         }

		//     ]
		// });

		});
	</script>	

	<div class="container" style="margin-top:50px;">
	<!--
		<table id="example" class="table" style="width:100%">
			<thead>
				<tr>
					<th>id</th>
					<th>nom</th>
					<th>prenom</th>
					<th>email</th>
					<th>pays</th>
				</tr>
			</thead>
		</table>
		<br />
		<br />
	-->

	<!-- Tableau Manuel -->
		<button class="btn btn-lg btn-info add">Ajouter un enregistrement</button>
		<table id="manuel" class="table table-hover table-dark" style="width:100%;margin-top:20px;">
			<thead class="thead-dark">
				<tr>
					<th>id</th>
					<th>nom</th>
					<th>prenom</th>
					<th>email</th>
					<th>pays</th>
					<th>edition</th>
				</tr>
			</thead>
			<tbody class="tab">
			<!-- Alimenté depuis ajax -->
			</tbody>
		</table>
		<!-- Modal d'édition-->
		<div class="editionModal modal fade" tabindex="-1" role="dialog">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Formulaire Edition</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<p>Edition</p>
						<form id="formEdition" method="POST" action="submit.php"> 
							<div class="form-group">
								<label for="nom">Nom</label>
								<input type="text" class="form-control" id="nom" name="nom" aria-describedby="nh" placeholder="Un nom...">
								<small id="nh" class="form-text text-muted">Info nom</small>

								<label for="prenom">Prenom</label>
								<input type="text" class="form-control" id="prenom" name="prenom" aria-describedby="ph" placeholder="Un prénom...">
								<small id="ph" class="form-text text-muted">Info prenom</small>

								<label for="email">Email</label>
								<input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Un email...">
								<small id="emailHelp" class="form-text text-muted">Info email</small>

								<label for="pays">Pays</label>
								<input type="text" name="pays" class="form-control" id="pays" name="pays" aria-describedby="ph" placeholder="Un pays...">
								<small id="ph" class="form-text text-muted">Info pays</small>

								<input id="id_r" name="id_r" type="hidden" value="">
							</div>
						</form>
						</div>
						<div class="modal-footer">
							<button type="submit" class="submitBtn btn btn-success">Valider</button>
							<button type="submit" class="addBtn btn btn-info">Enregistrer</button>
							<button type="button" class="deleteBtn btn btn-warning">Supprimer</button>
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	</body>
</html>
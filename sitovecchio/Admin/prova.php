<!DOCTYPE html>
<head>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<style type="text/css">
.submit, p {
padding:4px;
border:1px dashed #eee;
}
</style>
</head>
<body>
<form action="#">
<p>Invio abilitato.</p>
<input type="submit" value="Invia"></input>
<button>Riabilita</button>
</form>
<script type="text/javascript">
$('input:submit').click(function(){
$('p').text("Invio disabilitato.").addClass('submit');
$('input:submit').attr("disabled", true);
});
$('button').click(function(){
$('p').text("Invio abilitato.").removeClass('submit');
$('input:submit').attr("disabled", false);
});
</script>
</body>
</html>
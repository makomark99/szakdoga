<?php
include_once "./header.php";

function errorAlert(string $message, string $url, bool $err)
{?>
<script>
	Swal.fire({
		position: "center",
		type: "<?php echo ($err==true)? "error" : "success"; ?>",
		title: "<?php echo $message; ?>",
		showConfirmButton: false,
		icon: "<?php echo ($err==true)? "error" : "success"; ?>",
		background: "#343a40",
		color: "#fff",
		timer: 2500
	})
	setTimeout(function() {
		document.location.href = "<?php echo $url; ?>";
	}, 2500)
</script>
<?php
}
include_once "./footer.php";
?>
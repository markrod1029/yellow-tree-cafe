
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        <?php if (!empty($successMsg)): ?>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '<?= addslashes($successMsg) ?>',
                confirmButtonColor: '#3085d6',
                allowOutsideClick: false
            }).then(() => {
                window.location.href = "../../admin/index.php?page=staff";
            });
        <?php elseif (!empty($errorMsg)): ?>
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: '<?= addslashes($errorMsg) ?>',
                confirmButtonColor: '#d33'
            });
        <?php endif; ?>
    });
</script>

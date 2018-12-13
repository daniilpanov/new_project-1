<script>
    $(document).ready( function() {
       $("#maincheck").click( function() {
            if($('#maincheck').attr('checked')){
                $('.mc').attr('checked', true);
            } else {
                $('.mc').attr('checked', false);
            }
       });
    });
</script>
<?php

$menulist = $allmenus->print_list("en");

require_once "vmenulist.php" ;
?>
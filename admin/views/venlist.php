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

$aux_list = new \app\classes\CcreateEdit();
$list = $aux_list->print_list('en');

require_once "vlist.php" ;
?>

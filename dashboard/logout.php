<?php

    if(isset($_GET['operacion'])){

        if($_GET['operacion'] == "logout"){

            session_start();
            session_destroy();
            session_unset();

            //header("location: index.php");

        }
    }
?>

<script type="text/javascript">

    window.localStorage.removeItem('accessform');
    window.localStorage.clear();

    window.location = "index.php";

</script>

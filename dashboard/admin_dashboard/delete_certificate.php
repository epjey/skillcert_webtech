<?php
include("../../config/db_conn.php");

if (isset($_POST['certificate_id'])) {
    $certificate_id = intval($_POST['certificate_id']);

    // Delete certificate record
    $query = "DELETE FROM certificates WHERE certificate_id = $certificate_id";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "success";
    } else {
        echo "error: " . mysqli_error($conn);
    }
} else {
    echo "invalid_request";
}
?>

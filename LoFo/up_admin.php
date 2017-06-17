    <script type="text/javascript">
    <!--
        window.location = 'registered_users.php';
    -->
    </script>
<?php
// Your database info
include_once("php_includes/db_con.php");

if (!isset($_GET['id']))
{
    echo 'No ID was given...';
    exit;
}

if ($db_con->connect_error)
{
    die('Connect Error (' . $db_con->connect_errno . ') ' . $db_con->connect_error);
}

$sql = "UPDATE users SET role='1' WHERE user_id = ?";
if (!$result = $db_con->prepare($sql))
{
    die('Query failed: (' . $db_con->errno . ') ' . $db_con->error);
}

if (!$result->bind_param('i', $_GET['id']))
{
    die('Binding parameters failed: (' . $result->errno . ') ' . $result->error);
}

if (!$result->execute())
{
    die('Execute failed: (' . $result->errno . ') ' . $result->error);
}

if ($result->affected_rows > 0)
{
    echo "The ID was deleted with success.";
}
else
{
    echo "Couldn't delete the ID.";
}
$result->close();
$db_con->close();
?>
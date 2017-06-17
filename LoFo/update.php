
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

$sql = "UPDATE reported_by SET solved='1' WHERE report_id = ?";
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
    echo "The ID was modified with success.";
}
else
{
    echo "Couldn't modify the ID.";
}
$result->close();
$db_con->close();
?>
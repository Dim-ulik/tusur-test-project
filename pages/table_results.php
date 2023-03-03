<?php

require_once('../../../config.php');

$PAGE->set_context(context_system::instance());
$PAGE->set_pagelayout('admin');
$PAGE->set_title("Results");
$PAGE->set_heading("История решений");
$url = '/blocks/equation/pages/table_results.php';
$PAGE->set_url($url);

echo $OUTPUT->header();

global $DB;
$sql = 'SELECT * FROM mdl_block_equation_table';
$results = $DB->get_records_sql($sql);

echo "
<style type='text/css'>
  .table {
	width: 100%;
	border: none;
	margin-bottom: 20px;
	text-align: center;
  }
  .table thead th {
	font-weight: bold;
	text-align: left;
	border: none;
	padding: 10px 15px;
	background: #d8d8d8;
	font-size: 14px;
	border-left: 1px solid #ddd;
	border-right: 1px solid #ddd;
  }
  .table tbody td {
	text-align: left;
	border-left: 1px solid #ddd;
	border-right: 1px solid #ddd;
	padding: 10px 15px;
	font-size: 14px;
	vertical-align: top;
  }
  .table thead tr th:first-child, .table tbody tr td:first-child {
	border-left: none;
  }
  .table thead tr th:last-child, .table tbody tr td:last-child {
	border-right: none;
  }
  .table tbody tr:nth-child(even){
	background: #f3f3f3;
  }
</style>";

echo "<table class='table'>";
echo "<thead><tr>
			<td>id</td>
			<td>a</td>
			<td>b</td>
			<td>c</td>
			<td>x1</td>
			<td>x2</td>
		</tr>
		</thead>";

echo "<tbody>";

foreach ($results as $id => $result) {
    echo "<tr>";
    echo "<td>" . $result->id . "</td>";
    echo "<td>" . $result->a . "</td>";
    echo "<td>" . $result->b . "</td>";
    echo "<td>" . $result->c . "</td>";
    if ($result->res1 === NULL) {
        echo "<td colspan='2'>" . 'Решений нет!' . "</td>";
    }
    else {
        echo "<td>" . $result->res1 . "</td>";
        echo "<td>" . $result->res2 . "</td>";
    }
    echo"</tr>";
}

echo "</tbody></table>";

echo $OUTPUT->footer();

?>

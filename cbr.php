<?php

$old_date = strtoupper($_POST['old_date']);
//echo $old_date;

$addr = "http://cbrates.rbc.ru/tsv/";
$kodes = array(840,978);
$date = date("/Y/m/d");
if(isset($old_date) && $old_date != ''){
  $date_old = $old_date;
} else {
  $date_old = date("/Y/m/d", strtotime("-1 day"));
}
$ext = '.tsv';

foreach ($kodes as $kod) {
$link = $addr . $kod . $date . $ext;
$link_old = $addr . $kod . $date_old . $ext;
$screen = @file($link);
$screen_old = @file($link_old);
$temp = explode("\t", $screen[0]);
$temp_old = explode("\t", $screen_old[0]);
$kurs[] = $temp[1];
$kurs_old[] = $temp_old[1];
}
list($kursUSD, $kursEUR) = $kurs;
$dollar = $kursUSD;
$euro = $kursEUR;
list($kursUSD_old, $kursEUR_old) = $kurs_old;
$dollar_old = $kursUSD_old;
$euro_old = $kursEUR_old;
echo "<div style='text-align: center; border: 1px dotted gold; padding: 22px;'>";
echo "<h3><i><div style='border: 1px dotted gold;'>".date("Y/m/d")."</div></i></h3><h1>";
if ($dollar > $dollar_old) {
  echo "USD <span style='color: red;'>".$dollar."&#9650;".round(($dollar - $dollar_old), 4);
} else if ($dollar < $dollar_old) {
  echo "USD <span style='color: green;'>".$dollar."&#9660;".round(($dollar_old - $dollar), 4);
} else {
  echo "USD <span>".$dollar;
}
if ($euro > $euro_old) {
  echo "</span> EUR <span style='color: red;'>".$euro."&#9650;".round(($euro - $euro_old), 4);
} else if ($euro < $euro_old) {
  echo "</span> EUR <span style='color: green;'>".$euro."&#9660;".round(($euro_old - $euro), 4);
} else {
  echo "</span> EUR <span>".$euro;
}
echo "</span></div>";
?>
<div id='info' style="text-align: center;"><div class="alert alert-warning alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
<?php
echo $date_old."\n<br />";
echo $dollar_old . " " . $euro_old;

if ($dollar < 33) echo "<br /><b>cbr: USD < 33</b>";
else if ($dollar > 63) echo "<br /><b>cbr: USD > 63</b>";
echo "</div></div>";
?>

<?php

function print_cap_summary_table() {
 return file_get_contents('ftp://ftp.vectorbase.org/public_data/gffexport/latest/summary.html');
}


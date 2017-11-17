<?php
include 'ldap_connection.php';

// Removes navbar from top of result dropdown
echo <<<EOT

<style>
    #main-nav {
        display: none;
    }
</style>

EOT;


$ldap_connection = ldap_connect($server)
    or die("<p>Could not connect to LDAP server.</p>");

ldap_set_option($ldap_connection, LDAP_OPT_PROTOCOL_VERSION, 3);

if ($ldap_connection) {

    $ldap_bind = ldap_bind($ldap_connection, $user, $password);

}

$search_term = $_REQUEST["q"];
$dn = "OU=REDACTED, DC=REDACTED";
$filter = "(|(givenname=*$search_term*)(sn=*$search_term*))";
$search = ldap_search($ldap_connection, $dn, $filter);
$result_count = ldap_count_entries($ldap_connection, $search);
$entry = ldap_first_entry($ldap_connection, $search);
$results = [];
$search_parameter = ["givenname", "sn"]; // Order dictates output

if ($result_count != 0) {

    do {
        
        $result_string = "";
        $get_id = ldap_get_values($ldap_connection, $entry, "cn");
        $corporate_id = $get_id[0];
        $check_id = substr($corporate_id, 0, 1);

        if ($check_id === "A" || $check_id === "B" || $check_id === "C") {
        
        foreach ($search_parameter as $a) {

            $values = ldap_get_values($ldap_connection, $entry, $a);
            if (isset($values[0])) {

                $result_string .= $values[0] . " ";

            }
        }
            
        $results[] = "<div class='search-result'>" . ucwords(strtolower(rtrim($result_string))) . "</div><br>";

        }
    
    } while ($entry = ldap_next_entry($ldap_connection, $entry));
    
}

sort($results);

$search_result = implode("", $results);

// Output "no results" if no results were found or output correct values 
echo $search_result === "" ? "No Results <strong></strong><br>" : $search_result;
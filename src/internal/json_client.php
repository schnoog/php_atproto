<?php
$config['included'][] = "json_client.php";

class JSONClient extends RestClient {
    
    public function format_query($parameters, $primary=NULL, $secondary=NULL){
        return json_encode($parameters);
    }
}



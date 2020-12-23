<?php

$search_item = null;

if(isset($_GET['e__id'])){

    $es = $this->E_model->fetch(array(
        'e__id' => $e__id,
    ));
    if(count($es)){
        $search_item = $es[0]['e__title'];
    }

} elseif(isset($_GET['i__id'])){

    $is = $this->I_model->fetch(array(
        'i__id' => $_GET['i__id'],
    ));
    if(count($is)){
        $search_item = $is[0]['i__title'];
    }

}

if($search_item){
    return redirect_message('https://www.google.com/search?q='.urlencode($search_item));
} else {
    return view_json(array(
        'status' => 0,
        'message' => 'Invalid Input ID'
    ));
}
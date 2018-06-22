<?php
/**
 * Created by PhpStorm.
 * User: shervinenayati
 * Date: 2018-04-13
 * Time: 9:39 AM
 */

//We only want classes with some sort of an acticity:

$classes = $this->Db_model->r_fetch(array(
    'r_status >=' => 1, //Enrollment Open
),null,'ASC',0,array('ru'));



?>
    <table class="table table-condensed table-striped left-table" style="font-size:0.8em; width:100%;">
        <thead>
        <tr>
            <th style="width:40px;">#</th>
            <th>Bootcamp</th>
            <th>Lead Coach</th>
            <th>Class Start Time</th>
            <th>Elapsed</th>
            <th>Progress</th>
            <th colspan="4">Performance Stats</th>
        </tr>
        </thead>
        <tbody>
<?php
foreach($classes as $key=>$class) {

    //Fetch Full Bootcamp:
    $bs = $this->Db_model->b_fetch(array(
        'b.b_id' => $class['r_b_id'],
    ), array('fp'));

    if($class['r_status']>=2){
        //Fetch Bootcamp from Action Plan Copy:
        $bs = fetch_action_plan_copy($class['r_b_id'],$class['r_id'],$bs,array('b_fp_id'));
        $class = $bs[0]['this_class'];
    }

    //Fetch Leader:
    $coaches = $this->Db_model->ba_fetch(array(
        'ba.ba_b_id' => $class['r_b_id'],
        'ba.ba_status' => 3,
    ));

    echo '<tr>';
    echo '<td>'.($key+1).'</td>';

    echo '<td><a href="/console/'.$class['r_b_id'].'">'.$bs[0]['c_outcome'].'</a></td>';
    echo '<td><a href="/entities/'.$coaches[0]['u_id'].'">'.$coaches[0]['u_full_name'].'</a></td>';
    echo '<td><a href="/console/'.$class['r_b_id'].'/classes#class-'.$class['r_id'].'">'.echo_time(strtotime($class['r_start_date']),2).'</a></td>';
    echo '<td><span data-toggle="tooltip" title="% of Class Elapsed Time">';
    if($class['r_status']==3){
        echo '100%';
    } elseif($class['r_status']==2){
        echo round((time()-$class['r__class_start_time'])/($class['r__class_end_time']-$class['r__class_start_time'])*100).'%';
    }
    echo '</span></td>';
    echo '<td>';
    if($class['r_status']>=2){
        //Query average completion rate for Activated students:
        $average_completion = $this->Db_model->fetch_avg_class_completion($class['r_id']);
        echo '<span data-toggle="tooltip" title="Average completion rate of all class students combined">'.round($average_completion[0]['cr']*100).'%</span>';
    }
    echo '</td>';


    echo '<td>'.( $bs[0]['b_fp_id']>0 ? '<a href="https://www.facebook.com/'.$bs[0]['fp_fb_id'].'" target="_blank" data-toggle="tooltip" title="Bootcamp Facebook Page is '.$bs[0]['fp_name'].'" data-placement="right" ><i class="fas fa-plug"></i></a>' : '<i class="fas fa-exclamation-triangle redalert" data-toggle="tooltip" title="Bootcamp not connected to a Facebook Page yet" data-placement="right"></i>').'</td>';



    echo '<td class="'.( $bs[0]['b_status']<2 ? 'redalert' : '' ).'">';
    if($class['r_status']<2){
        echo echo_status('b',$bs[0]['b_status'],1,'right');
    }
    echo '</td>';


    echo '<td>'.echo_status('r',$class['r_status'],true).'</td>';
    echo '<td>';

    if($class['r_status']>=2){

        //Show Graduation Funnel:
        $completed = count($this->Db_model->ru_fetch(array(
            'r.r_id'	                        => $class['r_id'],
            'ru.ru_cache__current_task >'  => $class['r__total_tasks'],
        )));

        echo '<span data-toggle="tooltip" title="Completion Rate (Total Enrolled Students who Activated Messenger)">';
        echo '<b>'.($class['r__current_enrollments']>0 ? round($completed/$class['r__current_enrollments']*100) : '0').'%</b> Completed ('.$class['r__current_enrollments'].')';
        echo '</span>';

    } else {

        //Show Funnel:
        $pending_completion = count($this->Db_model->ru_fetch(array(
            'ru_r_id' => $class['r_id'],
            'ru_status' => 0,
        )));

        $guided_enrollments = count($this->Db_model->ru_fetch(array(
            'ru_r_id' => $class['r_id'],
            'ru_status >=' => 4,
            'ru_upfront_pay >' => 0,
        )));

        echo '<span data-toggle="tooltip" title="Pending &raquo; Enrolled Student &raquo; Guided-Seats">';
        echo $pending_completion.' &raquo; <b>'.$class['r__current_enrollments'].'</b>'.( $guided_enrollments>0 ? ' (<b>'.$guided_enrollments.'</b>)' : '' );
        echo '</span>';

    }
    echo '</td>';

    echo '</tr>';
}

echo '</tbody>';
echo '</table>';
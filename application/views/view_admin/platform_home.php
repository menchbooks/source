
<script src="/js/custom/platform-home.js?v=v<?= $this->config->item('app_version') ?>"
        type="text/javascript"></script>

<?php
//Fetch & Display Intent Note Messages to explain links:
$en_all_4488 = $this->config->item('en_all_4488');

//Fetch mission statement:
$mission_ins = $this->Intents_model->in_fetch(array(
    'in_id' => $this->config->item('in_mission_id'),
));
?>
<h1 style="text-align: center; margin-top: 50px;"><?= $en_all_4488[7161]['m_name'] ?></h1>
<p style="text-align: center; margin-top: 20px; padding-bottom:0; font-size:1.5em !important;">On a mission to <?= strtolower($mission_ins[0]['in_outcome']) ?> <a href="/<?= $this->config->item('in_learn_mench_id') ?>"><i class="fal fa-info-circle"></i></a></p>
<p style="text-align: center; margin-top: 20px; padding-bottom:40px; font-size:1.1em !important;"></p>


<div class="row" style="margin:0; padding: 0;">

    <div id="stats_intents_box" class="col-md-6 bottom-spacing">
        <div class="large-stat"><a href="javascript:void(0);" onclick="load_extra_stats('intents')" class="yellow"><?= $en_all_4488[4535]['m_icon'] ?> <span class="extended_stats"><i class="fas fa-spinner fa-spin"></i></span> <span class="substitle"><?= $en_all_4488[4535]['m_name'] ?> <i class="extra_stat_content fal fa-plus-circle"></i><i class="extra_stat_content fal fa-minus-circle hidden"></i></span></a></div>
        <div class="load_stats_box extra_stat_content hidden"></div>
    </div>


    <div id="stats_entities_box" class="col-md-6 bottom-spacing">
        <div class="large-stat"><a href="javascript:void(0);" onclick="load_extra_stats('entities')" class="blue"><?= $en_all_4488[4536]['m_icon'] ?> <span class="extended_stats"><i class="fas fa-spinner fa-spin"></i></span> <span class="substitle"><?= $en_all_4488[4536]['m_name'] ?> <i class="extra_stat_content fal fa-plus-circle"></i><i class="extra_stat_content fal fa-minus-circle hidden"></i></span></a></div>
        <div class="load_stats_box extra_stat_content hidden"></div>
    </div>

</div>


<div class="row" style="margin:0; padding: 0;">

    <div id="stats_links_box" class="col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3" style="margin-bottom:75px;">
        <div class="large-stat"><a href="javascript:void(0);" onclick="load_extra_stats('links')"><?= $en_all_4488[6205]['m_icon'] ?> <span class="extended_stats"><i class="fas fa-spinner fa-spin"></i></span> <span class="substitle"><?= $en_all_4488[6205]['m_name'] ?> <i class="extra_stat_content fal fa-plus-circle"></i><i class="extra_stat_content fal fa-minus-circle hidden"></i></span></a></div>
        <div class="load_stats_box extra_stat_content hidden"></div>
    </div>

</div>
<?php
/**
 * Joomla! component sexypolling
 *
 * @version $Id: default.php 2012-04-05 14:30:25 svn $
 * @author 2GLux.com
 * @package Sexy Polling
 * @subpackage com_sexypolling
 * @license GNU/GPL
 *
 * Extended by:
 * @version v3.0.0
 * @author Jefferson49
 * @link https://github.com/Jefferson49/Joomla_plugin_sexypolling_reloaded
 * @copyright Copyright (c) 2022 Jefferson49
 * @license GNU/GPL v3.0
 * 
 */

// no direct access
defined('_JEXEC') or die('Restircted access');

$document = JFactory::getApplication()->getDocument();

$jsFile = JURI::base(true).'/components/com_sexypolling/assets/js/jquery-1.7.2.min.js';
$document->addScript($jsFile);
$jsFile = JURI::base(true).'/components/com_sexypolling/assets/js/highstock.js';
$document->addScript($jsFile);
$jsFile = JURI::base(true).'/components/com_sexypolling/assets/js/exporting.js';
$document->addScript($jsFile);

$document->addScriptDeclaration ( 'jQuery.noConflict();' );


//function to return dates array
function get_dates_array($date1,$date2) {
    $a = strtotime($date1);
    $dates = array();
    while ($a <= strtotime($date2)) {
        $dates[] = date('Y-m-d', $a);
        $a += (60 * 60 * 24);
    }

    return $dates;
}


$db = JFactory::getDBO();

$poll_id = JFactory::getApplication()->input->get('id');

$query = "
            SELECT
                sp.name,
                sp.question,
                count(sv.ip) votes,
                sv.date
            FROM
                #__sexy_polls sp
            LEFT JOIN #__sexy_answers sa ON sa.id_poll = sp.id AND sa.published <> '-2'
            LEFT JOIN #__sexy_votes sv ON sv.id_answer = sa.id
            WHERE sp.id = '$poll_id'
            GROUP BY
                DATE(sv.date)
            ORDER BY
                sv.date
        ";
$db->setQuery($query);
$statdata = $db->loadAssocList();

$poll_name = $statdata[0]['name'];
$poll_question = $statdata[0]['question'];
$min_date = date('Y-m-d',strtotime($statdata[0]['date']));
$size = sizeof($statdata) - 1;
$max_date = date('Y-m-d',strtotime($statdata[$size]['date']));


$stat_array = array();
foreach($statdata as $val) {
    $only_date = date('Y-m-d',strtotime($val['date']));
    $stat_array[$only_date] = $val['votes'];
}


//get all range of dates
$dates_array = get_dates_array($min_date,$max_date);
//get final array wuth all dates
$stat_array_final = array();
foreach($dates_array as $k => $date_val) {
    $cur_votes = (in_array($date_val,array_keys($stat_array))) ? $stat_array[$date_val] : 0;

    $date_data = explode('-',$date_val);

    $stat_array_final[$k]["votes"] = $cur_votes;
    $stat_array_final[$k]["y"] = $date_data[0];
    $stat_array_final[$k]["m"] = $date_data[1];
    $stat_array_final[$k]["d"] = $date_data[2];
}

//country stat
$query = "
            SELECT
                count(sv.ip) votes,
                sv.country
            FROM
                #__sexy_votes sv
            LEFT JOIN #__sexy_answers sa ON sa.id_poll = '$poll_id' AND sa.published <> '-2'
            WHERE sv.id_answer = sa.id
            GROUP BY
            sv.country
            ORDER BY
            sv.country
            ";
$db->setQuery($query);
$statcountrydata = $db->loadAssocList();

$max = 0;
$max_country_name = @$statcountrydata[0]['country'];
foreach($statcountrydata as $val) {
    if($val['votes'] >= $max) {
        $max = $val['votes'];
        $max_country_name = $val['country'];
    }
}


//answers stat
$query = "
            SELECT
                count(sv.ip) votes,
                sa.id,
                sa.name
            FROM
                #__sexy_votes sv
            JOIN #__sexy_answers sa ON sa.id_poll = '$poll_id' AND sa.published <> '-2'
            WHERE sv.id_answer = sa.id
            GROUP BY
            sv.id_answer
            ORDER BY votes DESC
            ";
$db->setQuery($query);
$statanswersdata = $db->loadAssocList();
$max = 0;
$max_ans_id = @$statanswersdata[0]['id'];
foreach($statanswersdata as $val) {
    if($val['votes'] >= $max) {
        $max = $val['votes'];
        $max_ans_id = $val['id'];
    }
}

$query = "
            SELECT
            count(sv.ip) votes
            FROM
            #__sexy_votes sv
            JOIN #__sexy_answers sa ON sa.id_poll = '$poll_id'
            WHERE sv.id_answer = sa.id
            ";
$db->setQuery($query);
$totalvotes = $db->loadResult();

JToolBarHelper::title(   JText::_( 'COM_SEXYPOLLING_STATISTICS' ).' - ('.$poll_name.')' ,'manage.png' );


if($totalvotes > 0) {
?>
<div>
<script type="text/javascript">
(function($) {
    $(document).ready(function() {


        // Create the chart
        window.chart = new Highcharts.StockChart({
            chart : {
                renderTo : 'graph_container'
            },

            rangeSelector : {
                selected : 1
            },

            title : {
                text : '<?php echo JText::_("COM_SEXYPOLLING_VOTES_STATISTICS")." - ($poll_name)";?>'
            },

            scrollbar: {
                barBackgroundColor: '#bbb',
                barBorderRadius: 7,
                barBorderWidth: 0,
                buttonBackgroundColor: '#999',
                buttonBorderWidth: 0,
                buttonBorderRadius: 7,
                trackBackgroundColor: 'none',
                trackBorderWidth: 1,
                trackBorderRadius: 8,
                trackBorderColor: '#fff'
            },

            series : [
            <?php
                $c_data = array();
                foreach($stat_array_final as $row) {
                    $m = $row['m'] - 1;
                    $c_data[] = '[Date.UTC('.$row["y"].','.$m.','.$row["d"].',0,0,0),'.$row["votes"].']';
                }

                //print series javacript
                echo '{';
                echo "name : 'Votes',\n";
                echo "type: 'areaspline',\n";
                //echo "type: 'column',\n";
                //echo "type: 'spline',\n";
                echo 'data : [';
                    foreach ($c_data as $r => $val) {
                        echo $val;
                        if($r != sizeof($c_data) - 1)
                            echo ',';
                        echo "\n";
                    }
                echo '],';
                echo 'marker : {
                            enabled : false,
                            radius : 3
                        },
                        shadow : true,
                        tooltip : {
                            valueDecimals : 0
                        },
                        fillColor : {
                            linearGradient : {
                                x1: 0,
                                y1: 0,
                                x2: 0,
                                y2: 1
                            },
                            stops : [[0, Highcharts.getOptions().colors[0]], [1, "rgba(0,0,0,0)"]]
                        },
                        threshold: null
                        ';
                echo '}';
            ?>
            ]
        });


        /*pie charts*/
         var chart;
            $(document).ready(function() {
                chart = new Highcharts.Chart({
                    chart: {
                        renderTo: 'container1',
                        plotBackgroundColor: null,
                        plotBorderWidth: null,
                        plotShadow: false
                    },
                    title: {
                        text: '<?php echo JText::_("COM_SEXYPOLLING_COUNTRY_STATISTICS");?>'
                    },
                    tooltip: {
                        formatter: function() {
                            return '<b>'+ this.point.name +'</b>: '+ this.percentage.toFixed(2) +' %';
                        }
                    },
                    plotOptions: {
                        pie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: true,
                                color: '#444444',
                                connectorColor: '#555555',
                                formatter: function() {
                                    return '<b>'+ this.point.name +'</b>: '+ this.percentage.toFixed(2) +' %';
                                }
                            },
                            showInLegend: true
                        }
                    },
                    series: [{
                        type: 'pie',
                        name: '',
                        data: [
                            <?php
                                foreach($statcountrydata as $k => $val) {
                                    $perc = sprintf ("%.2f", ((100 * $val['votes']) / $totalvotes));

                                    if($max_country_name == $val['country']) {
                                        echo "{
                                                name: '".$val['country']."',
                                                y: $perc,
                                                sliced: true,
                                                selected: true
                                            }";
                                    }
                                    else {
                                        echo "['".$val['country']."',".$perc."]";
                                    }
                                    if($k != sizeof($statcountrydata) - 1)
                                        echo ',';
                                }
                            ?>
                        ]
                    }]
                });
            });

        /*pie charts*/
         var chart;
            $(document).ready(function() {
                chart = new Highcharts.Chart({
                    chart: {
                        renderTo: 'container2',
                        plotBackgroundColor: null,
                        plotBorderWidth: null,
                        plotShadow: false
                    },
                    title: {
                        text: '<?php echo JText::_("COM_SEXYPOLLING_ANSWERS_STATISTICS");?>'
                    },
                    tooltip: {
                        formatter: function() {
                            return '<b>'+ this.point.name +'</b>: '+ this.percentage.toFixed(2) +' %';
                        }
                    },
                    plotOptions: {
                        pie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: true,
                                color: '#444444',
                                connectorColor: '#555555',
                                formatter: function() {
                                    return '<b>'+ this.point.name +'</b>: '+ this.percentage.toFixed(2) +' %';
                                }
                            },
                            showInLegend: true
                        }
                    },
                    series: [{
                        type: 'pie',
                        name: '',
                        data: [
                            <?php
                                foreach($statanswersdata as $k => $val) {
                                    $perc = sprintf ("%.2f", ((100 * $val['votes']) / $totalvotes));
                                    $val['name'] = preg_replace('/(\<\s\>.*?\<\s\>)/si','',$val['name']);
                                    $val['name'] = str_replace("\n","",$val['name']);
                                    $val['name'] = str_replace("\r","",$val['name']);

                                    $val['name'] = preg_replace('/(<[a-zA-Z]+.*?>(.*?)<\/[a-zA-Z]+>)/si','',$val['name']);

                                    if($val['id'] == $max_ans_id) {
                                        echo "{
                                                name: '".str_replace(array('\'','"',"'"),"",stripslashes(htmlspecialchars_decode(strip_tags($val['name']),ENT_NOQUOTES)))."',
                                                y: $perc,
                                                sliced: true,
                                                selected: true
                                            }";
                                    }
                                    else {
                                        //echo "['".str_replace(array('\'','"'),"",htmlspecialchars_decode($val['name']))."',".$perc."]";
                                        echo "['".str_replace(array('\'','"',"'"),"",stripslashes(htmlspecialchars_decode(strip_tags($val['name']),ENT_NOQUOTES)))."',".$perc."]";
                                    }
                                    if($k != sizeof($statanswersdata) - 1)
                                        echo ',';
                                }
                            ?>
                        ]
                    }]
                });
            });



})
})(jQuery);
</script>
<div style="color: rgb(21, 90, 177);font-size: 20px;font-weight: bold;clear: both;text-align: center;margin: 5px 0 5px 0;"><?php echo JText::_('COM_SEXYPOLLING_STATISTICS_DEMO')?></div>

<div style="position: relative;float: left; width: 48%;padding: 8px;border: 1px solid #ccc;border-radius: 6px;box-shadow: inset 0 0 28px -3px #bbb;margin: 15px 0;">
    <div id="container2" style=""></div>
    <div style="position: absolute;z-index: 100000;color: red;height: 13px;width: 87px;bottom: 10px;right: 10px;background-color: #fff;"></div>
</div>
<div style="position: relative;float: right; width: 48%;padding: 8px;border: 1px solid #ccc;border-radius: 6px;box-shadow: inset 0 0 28px -3px #bbb;margin: 15px 0;">
    <div id="container1" style=""></div>
    <div style="position: absolute;z-index: 100000;color: red;height: 13px;width: 87px;bottom: 10px;right: 10px;background-color: #fff;"></div>
</div>

<div style="position: relative;padding: 8px;border: 1px solid #ccc;border-radius: 6px;box-shadow: inset 0 0 28px -3px #bbb;margin: 15px 0;clear: both;">
    <div id="graph_container" style="width: 98%;margin:0 auto;"></div>
    <div style="position: absolute;z-index: 100000;color: red;height: 13px;width: 200px;bottom: 10px;right: 10px;background-color: #fff;"></div>
</div>
</div>
<?php }
elseif($totalvotes == 0) {
    echo 'No Data';
}?>


<form action="index.php" method="post" name="adminForm" id="adminForm">
<input type="hidden" name="option" value="com_sexypolling" />
<input type="hidden" name="task" value="cancel" />
<input type="hidden" name="controller" value="statistics" />
</form>
<?php include (JPATH_BASE.'/components/com_sexypolling/helpers/footer.php'); ?>
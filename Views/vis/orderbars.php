<!--
   All Emoncms code is released under the GNU Affero General Public License.
   See COPYRIGHT.txt and LICENSE.txt.

    ---------------------------------------------------------------------
    Emoncms - open source energy visualisation
    Part of the OpenEnergyMonitor project:
    http://openenergymonitor.org
-->

<?php
  $feedid = $_GET["feedid"]; 
  $apikey = $_GET["apikey"];
  global $path, $embed;
?>

<!--[if IE]><script language="javascript" type="text/javascript" src="<?php echo $path; ?>Includes/flot/excanvas.min.js"></script><![endif]-->
<script language="javascript" type="text/javascript" src="<?php echo $path; ?>Includes/flot/jquery.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo $path; ?>Includes/flot/jquery.flot.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo $path; ?>Includes/flot/date.format.js"></script>

<script language="javascript" type="text/javascript" src="<?php echo $path; ?>Views/vis/common/api.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo $path; ?>Views/vis/common/inst.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo $path; ?>Views/vis/common/proc.js"></script>
 
<?php if (!$embed) { ?>
<h2>Bar graph (ordered by height): <?php echo $feedname; ?></h2>
<?php } ?>

    <div id="graph_bound" style="height:400px; width:100%; position:relative; ">
      <div id="graph"></div>
      <h3 style="position:absolute; top:00px; left:50px;"><span id="stats"></span></h3>
    </div>

<script id="source" language="javascript" type="text/javascript">

  var embed = <?php echo $embed; ?>;
  $('#graph').width($('#graph_bound').width());
  $('#graph').height($('#graph_bound').height());
  if (embed) $('#graph').height($(window).height());

  var feedid = "<?php echo $feedid; ?>";
  var feedname = "<?php echo $feedname; ?>";
  var path = "<?php echo $path; ?>";
  var apikey = "<?php echo $apikey; ?>";

  var graph_data = [];
  vis_feed_data();

  $(window).resize(function(){
    $('#graph').width($('#graph_bound').width());
    if (embed) $('#graph').height($(window).height());
    plot();
  });

  function vis_feed_data()
  {
    graph_data = get_feed_data(feedid,0,0,0);

    for(x = 0; x < graph_data.length; x++) {
      for(y = 0; y < (graph_data.length-1); y++) {
        if(graph_data[y][1]*1 < graph_data[y+1][1]*1) {
          holder = graph_data[y+1];
          graph_data[y+1] = graph_data[y];
          graph_data[y] = holder;
        }
      }
    }

    for(x = 0; x < graph_data.length; x++) graph_data[x][0] = x;

    plot();
  }

  function plot()
  {
    var plot = $.plot($("#graph"), [{data: graph_data, bars: { show: true, align: "center", fill: true}}], {
      grid: { show: true, hoverable: true },
      yaxis: {min: 0}
    });
  }

</script>


<?= $this->extend("layouts/app") ?>
<?= $this->section("body") ?>
<?php include APPPATH.'views/layouts/sidebar.php';?>
<?php echo script_tag('js/jquery.min.js'); ?>
    <section class="home">
        <div class="container">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12">
                    <h6 class="header-dashboard">CSAT/Dashboard</h6>                    
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-3 row">
                                <div class="col-xl-6 col-lg-6 col-md-6">
                                <canvas id="chart-line" width="299" height="200" class="chartjs-render-monitor" style="display: block; width: 600px; height: 300px;"></canvas>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6">
                                <canvas id="chart-line1" width="299" height="200" class="chartjs-render-monitor" style="display: block; width: 600px; height: 300px;"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- <div class="col-xl-6 col-lg-6 col-md-6">
                    <div class="button-dashboard hide-md">
                        <button><i class="far fa-calendar" style="color: #606162;"></i>
                            Select Dates
                        </button>
                        <button><i class="fas fa-filter" style="color: #696969;"></i> Filter</button>
                    </div>
                    <div class="Satisfaction">
                        <p class="response-head">CSAT Summary</p>
                        <div class="survey">
                            <div class="sur-con">
                                <h2>Content</h2>
                            </div>
                        </div>
                    </div>
                    <div class="column-left">
                        <div class="response-2">
                            <div class="res-con">
                                <h2>Content</h2>
                            </div>
                        </div>
                    </div>
                </div> -->
            </div>
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-6">
                    <p class="response-head-1">NPS Response</p>
                    <!-- <div class="col-1-right">
                        <button>progress
                            <?php $imageProperties = ['src' => 'images/Icon.svg']; 
                            echo img($imageProperties); ?></button>
                    </div>
                    <div class="res-cou-2">
                        <h2>content</h2>
                    </div> -->
                    <canvas id="chartId" aria-label="chart" height="350" width="580"></canvas>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6">
                    <p class="response-head-1">
                        CSAT By Country
                    </p>
                    <div class="col-2-right">
                        <button>progress<?php $imageProperties = ['src' => 'images/Icon.svg']; 
                            echo img($imageProperties); ?></button>
                    </div>
                    <div class="res-cou-2">
                        <h2>content</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.bundle.min.js'></script>
    <script>
    $(document).ready(function() {
        Chart.pluginService.register({
      beforeDraw: function(chart) {
        if (chart.config.options.elements.center) {
          // Get ctx from string
          var ctx = chart.chart.ctx;

          // Get options from the center object in options
          var centerConfig = chart.config.options.elements.center;
          var fontStyle = centerConfig.fontStyle || 'Arial';
          var txt = centerConfig.text;
          var color = centerConfig.color || '#000';
          var maxFontSize = centerConfig.maxFontSize || 75;
          var sidePadding = centerConfig.sidePadding || 20;
          var sidePaddingCalculated = (sidePadding / 100) * (chart.innerRadius * 2)
          // Start with a base font of 30px
          ctx.font = "30px " + fontStyle;

          // Get the width of the string and also the width of the element minus 10 to give it 5px side padding
          var stringWidth = ctx.measureText(txt).width;
          var elementWidth = (chart.innerRadius * 2) - sidePaddingCalculated;

          // Find out how much the font can grow in width.
          var widthRatio = elementWidth / stringWidth;
          var newFontSize = Math.floor(30 * widthRatio);
          var elementHeight = (chart.innerRadius * 2);

          // Pick a new font size so it will not be larger than the height of label.
          var fontSizeToUse = Math.min(newFontSize, elementHeight, maxFontSize);
          var minFontSize = centerConfig.minFontSize;
          var lineHeight = centerConfig.lineHeight || 25;
          var wrapText = false;

          if (minFontSize === undefined) {
            minFontSize = 20;
          }

          if (minFontSize && fontSizeToUse < minFontSize) {
            fontSizeToUse = minFontSize;
            wrapText = true;
          }

          // Set font settings to draw it correctly.
          ctx.textAlign = 'center';
          ctx.textBaseline = 'middle';
          var centerX = ((chart.chartArea.left + chart.chartArea.right) / 2);
          var centerY = ((chart.chartArea.top + chart.chartArea.bottom) / 2);
          ctx.font = fontSizeToUse + "px " + fontStyle;
          ctx.fillStyle = color;

          if (!wrapText) {
            ctx.fillText(txt, centerX, centerY);
            return;
          }

          var words = txt.split(' ');
          var line = '';
          var lines = [];

          // Break words up into multiple lines if necessary
          for (var n = 0; n < words.length; n++) {
            var testLine = line + words[n] + ' ';
            var metrics = ctx.measureText(testLine);
            var testWidth = metrics.width;
            if (testWidth > elementWidth && n > 0) {
              lines.push(line);
              line = words[n] + ' ';
            } else {
              line = testLine;
            }
          }

          // Move the center up depending on line height and number of lines
          centerY -= (lines.length / 2) * lineHeight;

          for (var n = 0; n < lines.length; n++) {
            ctx.fillText(lines[n], centerX, centerY);
            centerY += lineHeight;
          }
          //Draw text in center
          ctx.fillText(line, centerX, centerY);
        }
      }
    });
        var promotor  = "<?php echo count($getdashData['promoters']); ?>";
        var passives  = "<?php echo count($getdashData['passives']); ?>";
        var detractors  = "<?php echo count($getdashData['detractors']); ?>";
        var getsurveyresponse  = "<?php echo $getdashData['getsurveyresponse']; ?>";
        var totalresponse  = "<?php echo $getdashData['totalresponse']; ?>";
        var responserate = Math.round((getsurveyresponse/totalresponse) * 100) + "%";
        
        console.log(barchartData);
        console.log(responserate);
        var ctx = $("#chart-line");
        var myLineChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: [ "Promoters","Passives","Detractors"],
                datasets: [{
                    data: [promotor, passives, detractors ],
                    backgroundColor: ["darkblue", "pink", "red"]
                }]
            },
            options: {
                title: {
                    display: true,
                    text: 'Net Promotion Score'
                }
            }
        });
        // Response Rate
        var ctx = $("#chart-line1");
        var myLineChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: [ "total Data","response Data"],
                datasets: [{
                    data: [totalresponse, getsurveyresponse ],
                    backgroundColor: ["darkblue", "red"]
                }]
            },
            options: {
                title: {
                    display: true,
                    text: 'Response Rate'
                },
                elements: {
                    center: {
                        text: responserate,
                        color: '#FF6384', // Default is #000000
                        fontStyle: 'Arial', // Default is Arial
                        sidePadding: 20, // Default is 20 (as a percentage)
                        minFontSize: 25, // Default is 20 (in px), set to false and text will not wrap.
                        lineHeight: 25 // Default is 25 (in px), used for when text wraps
                    }
                }
            }
        });
    });
    var linelabel = ['1','2','3','4','5','6','7','8','9','10'];
    var barchartData = ["<?php echo (isset($getdashData['getfullResponse'][1]) ? $getdashData['getfullResponse'][1] : ''); ?>",
        "<?php echo (isset($getdashData['getfullResponse'][2]) ? $getdashData['getfullResponse'][2] : ''); ?>",
        "<?php echo (isset($getdashData['getfullResponse'][3]) ? $getdashData['getfullResponse'][3] : ''); ?>",
        "<?php echo (isset($getdashData['getfullResponse'][4]) ? $getdashData['getfullResponse'][4] : ''); ?>",
        "<?php echo (isset($getdashData['getfullResponse'][5]) ? $getdashData['getfullResponse'][5] : ''); ?>",
        "<?php echo (isset($getdashData['getfullResponse'][6]) ? $getdashData['getfullResponse'][6] : ''); ?>",
        "<?php echo (isset($getdashData['getfullResponse'][7]) ? $getdashData['getfullResponse'][7] : ''); ?>",
        "<?php echo (isset($getdashData['getfullResponse'][8]) ? $getdashData['getfullResponse'][8] : ''); ?>",
        "<?php echo (isset($getdashData['getfullResponse'][9]) ? $getdashData['getfullResponse'][9] : ''); ?>",
        "<?php echo (isset($getdashData['getfullResponse'][10]) ? $getdashData['getfullResponse'][10] : ''); ?>",];
    var chrt = document.getElementById("chartId").getContext("2d");
      var chartId = new Chart(chrt, {
         type: 'bar',
         data: {
            labels: linelabel,
            datasets: [{
               label: "NPS Customer Response",
               data: barchartData,
               backgroundColor: ['red', 'pink', 'brown', 'darkblue', 'lightgreen', 'darkred', 'gold', 'lightblue', 'violet', 'yellow']
            }],
         },
         options: {
            responsive: true,
         },
      });
</script>
    <?= $this->endSection() ?>
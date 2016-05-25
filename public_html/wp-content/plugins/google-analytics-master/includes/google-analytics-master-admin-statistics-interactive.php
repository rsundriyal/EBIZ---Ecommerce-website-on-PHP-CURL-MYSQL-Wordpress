<?php
// Create menu
function menu_single_google_analytics_admin_statistics_interactive(){
	if ( is_admin() )
	add_submenu_page( 'google-analytics-master', 'Statistics Interactive', 'Statistics Interactive', 'manage_options', 'google-analytics-master-admin-statistics-interactive', 'google_analytics_master_admin_statistics_interactive' );
}

function google_analytics_master_admin_statistics_interactive(){
?>
<div class="wrap">
<div style="width:40px; vertical-align:middle; float:left;"><img src="<?php echo plugins_url('../images/techgasp-minilogo.png', __FILE__); ?>" alt="' . esc_attr__( 'TechGasp Plugins') . '" /></div>
<h2><b>&nbsp;Statistics</b></h2><br>

<!-- START ANALYTICS EMBED -->
<!DOCTYPE html>
<meta charset="utf-8">
<link href='//fonts.googleapis.com/css?family=Open+Sans:700,400,300' rel='stylesheet'>
<link rel="stylesheet" href="<?php echo plugins_url('assets/css/main_google_analytics.css', __FILE__); ?>">

<header class="Banner">
  <div class="Banner-auth" id="auth"></div>
</header>

<main>
  <section>
    <div class="Instructions">
      <h2>Instructions</h2>
      <ul>
        <li>Click on a row in the table below to see a timeline of sessions from that browser over the past week.</li>
        <li>At any point you may pick a new view from the view selector and click "update" to interact with that view's data.</li>
      </ul>
    </div>
  </section>

  <section>
    <div class="Component">
      <i id="viewpicker"></i>
      <button class="Button" id="update">Update</button>
    </div>
  </section>

  <section>
    <div class="Component Chart">
      <h3 class="Chart-title">Top Browsers</h3>
      <div id="table-chart"></div>
    </div>
    <div class="Component Chart">
      <h3 class="Chart-title">Page Views Last Week</h3>
      <div id="line-chart"></div>
    </div>
  </section>
</main>

<!-- This code snippet loads the Embed API. Do not modify! -->
<script>
(function(w,d,s,g,js,fjs){
  g=w.gapi||(w.gapi={});g.analytics={q:[],ready:function(cb){this.q.push(cb)}};
  js=d.createElement(s);fjs=d.getElementsByTagName(s)[0];
  js.src='https://apis.google.com/js/platform.js';
  fjs.parentNode.insertBefore(js,fjs);js.onload=function(){g.load('analytics')};
}(window,document,'script'));
</script>

<!-- This demo uses the viewpicker component, which uses JavaScript promises.
The promise.js script below polyfills promises in older browsers that don't
support them. -->
<script src="<?php echo plugins_url('assets/js/promise.js', __FILE__); ?>"></script>
<script src="<?php echo plugins_url('components/viewpicker.js', __FILE__); ?>"></script>

<script>
gapi.analytics.ready(function() {

  /**
* Authorize this user.
*/
  gapi.analytics.auth.authorize({
    container: 'auth',
    clientid: '<?php echo get_option('google_analytics_master_client_id'); ?>',
  });

  /**
* Add a callback to add the `is-authorized` class to the body
* as soon as authorization is successful. This is used to help
* style components.
* Also add an event listener to a button so we only update the charts
* when it's clicked (as opposed to whever the user changes views).
*/
  gapi.analytics.auth.on('success', function(response) {
    document.documentElement.classList.add('is-authorized');
    document.getElementById('update').addEventListener('click', update);
  });

  /**
* Create a new Viewpicker instance to be rendered inside of an
* element with the id "viewpicker".
*/
  var viewpicker = new gapi.analytics.ext.Viewpicker({
    container: 'viewpicker'
  }).execute();

  /**
* Create a new DataChart instance with the given query parameters
* and Google chart options. It will be rendered inside an element
* with the id "table-chart".
*/
  var tableChart = new gapi.analytics.googleCharts.DataChart({
    query: {
      'dimensions' : 'ga:browser',
      'metrics': 'ga:pageviews,ga:users,ga:newUsers,ga:bounces,ga:organicSearches',
      'sort': '-ga:pageviews',
      'max-results': '9'
    },
    chart: {
      type: 'TABLE',
      container: 'table-chart'
    }
  });

  /**
* Create a new DataChart instance with the given query parameters
* and Google chart options. It will be rendered inside an element
* with the id "line-chart".
*/
  var lineChart = new gapi.analytics.googleCharts.DataChart({
    query: {
      'dimensions': 'ga:date',
      'metrics': 'ga:pageviews,ga:users,ga:newUsers,ga:bounces,ga:organicSearches',
      'start-date': '7daysAgo',
      'end-date': 'yesterday'
    },
    chart: {
      type: 'LINE',
      container: 'line-chart'
    }
  });


  /**
* Store a refernce to the click listener variable so it can be removed
* later.
*/
  var clickListener;

  /**
* Each time the table chart is rendered, add an event listener to its rows
* so that when the user clicks on a row, the line chart is updated with
* only the data from the browser in the clicked row.
*/
  tableChart.on('success', function(response) {

    var tableChart = response.chart;
    var dataTable = new google.visualization.DataTable(response.data);

    if (clickListener) {
      google.visualization.events.removeListener(clickListener);
    }

    clickListener = google.visualization.events
        .addListener(tableChart, 'select', function() {

      if (!tableChart.getSelection().length) return;

      var row = tableChart.getSelection()[0].row;
      var browser = dataTable.getValue(row, 0);
      lineChart.set({
        'query': {
          'filters': 'ga:browser==' + browser
        },
        chart: {
          options: {
            title: browser
          }
        }
      }).execute();
    });
  });

  /**
* Run the update function the very first time the viewpicer instance
* emits the change event (which will happen as soon as the page loads).
* (After that, only run update when the button is clicked.)
*/
  viewpicker.once('change', update);

  /**
* Update the charts with the viewpickers ids. If the line chart's
* query option has a filter property (which happens when you click on a
* row in the table chart) then update the line chart as well.
*/
  function update() {
    var options = {
      query: {
        ids: viewpicker.ids
      }
    };
    tableChart.set(options).execute();
    lineChart.set(options);

    if (lineChart.get().query.filters) lineChart.execute();
  }
});
</script>

<div style="clear:both">
<br>
<h2>IMPORTANT: Makes no use of Javascript or Ajax to keep your website fast and conflicts free</h2>

<div style="background: url(<?php echo plugins_url('../images/techgasp-hr.png', __FILE__); ?>) repeat-x; height: 10px"></div>

<br>

<p>
<a class="button-secondary" href="http://wordpress.techgasp.com" target="_blank" title="Visit Website">More TechGasp Plugins</a>
<a class="button-secondary" href="http://wordpress.techgasp.com/support/" target="_blank" title="Facebook Page">TechGasp Support</a>
<a class="button-primary" href="http://wordpress.techgasp.com/google-analytics-master/" target="_blank" title="Visit Website"><?php echo get_option('google_analytics_master_name'); ?> Info</a>
<a class="button-primary" href="http://wordpress.techgasp.com/google-analytics-master-documentation/" target="_blank" title="Visit Website"><?php echo get_option('google_analytics_master_name'); ?> Documentation</a>
<a class="button-primary" href="http://wordpress.org/plugins/google-analytics-master/" target="_blank" title="Visit Website">RATE US *****</a>
</p>
</div>

<?php
}

if( is_multisite() ) {
add_action( 'admin_menu', 'menu_single_google_analytics_admin_statistics_interactive' );
}
else {
add_action( 'admin_menu', 'menu_single_google_analytics_admin_statistics_interactive' );
}
?>
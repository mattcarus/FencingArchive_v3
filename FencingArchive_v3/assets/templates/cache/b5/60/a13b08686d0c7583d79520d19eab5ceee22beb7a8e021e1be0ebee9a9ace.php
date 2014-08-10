<?php

/* home.html */
class __TwigTemplate_b560a13b08686d0c7583d79520d19eab5ceee22beb7a8e021e1be0ebee9a9ace extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
    <meta charset=\"utf-8\">
    <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
    
    <title></title>
    
    <link href=\"http://v3.fencingarchive.net/assets/bootstrap/bootstrap-3.1.1-dist/css/bootstrap.min.css\" rel=\"stylesheet\">
    <link href=\"http://v3.fencingarchive.net/assets/style/teamgb.css\" rel=\"stylesheet\">
    <link href=\"http://v3.fencingarchive.net/assets/socicon/socicon.css\" rel=\"stylesheet\">
    
    <link href='//fonts.googleapis.com/css?family=Yanone+Kaffeesatz:300,400,200,500,700' rel='stylesheet' type='text/css'>
    
\t<script src=\"http://v3.fencingarchive.net/assets/jquery/js/jquery-1.11.0.min.js\"></script>
\t<script src=\"http://v3.fencingarchive.net/assets/bootstrap/bootstrap-3.1.1-dist/js/bootstrap.min.js\"></script>
    <script src=\"//d3js.org/d3.v3.min.js\"></script>
    <script src=\"http://v3.fencingarchive.net/assets/typeahead/typeahead.bundle.min.js\"></script>
</head>

<body role=\"document\">

    <!-- Fixed navbar -->
    <div class=\"navbar navbar-inverse navbar-fixed-top\" role=\"navigation\">
      <div class=\"container\">
        <div class=\"navbar-header\">
          <button type=\"button\" class=\"navbar-toggle\" data-toggle=\"collapse\" data-target=\".navbar-collapse\">
            <span class=\"sr-only\">Toggle navigation</span>
            <span class=\"icon-bar\"></span>
            <span class=\"icon-bar\"></span>
            <span class=\"icon-bar\"></span>
          </button>
          <a class=\"navbar-brand\" href=\"#\">FencingArchive</a>
        </div>
        <div class=\"navbar-collapse collapse\">
          <ul class=\"nav navbar-nav\">
            <li class=\"active\"><a href=\"#\">Home</a></li>
            <li><a href=\"#about\">About</a></li>
            <li><a href=\"#contact\">Contact</a></li>
            <li class=\"dropdown\">
              <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">Dropdown <b class=\"caret\"></b></a>
              <ul class=\"dropdown-menu\">
                <li><a href=\"#\">Action</a></li>
                <li><a href=\"#\">Another action</a></li>
                <li><a href=\"#\">Something else here</a></li>
                <li class=\"divider\"></li>
                <li class=\"dropdown-header\">Nav header</li>
                <li><a href=\"#\">Separated link</a></li>
                <li><a href=\"#\">One more separated link</a></li>
              </ul>
            </li>
          </ul>
          <form class=\"navbar-form navbar-right\" role=\"form\">
            <div class=\"form-inline form-group\">
              <input type=\"text\" placeholder=\"Search\" class=\"form-control\">
            </div>
            <button type=\"submit\" class=\"btn btn-success\"><span class=\"glyphicon glyphicon-search\"></span></button>
          </form>
          <ul class=\"nav navbar-nav navbar-right\">
            <li><a href=\"https://twitter.com/share?text=#fencingarchive:&url=";
        // line 62
        if (isset($context["url"])) { $_url_ = $context["url"]; } else { $_url_ = null; }
        echo twig_escape_filter($this->env, $_url_, "html", null, true);
        echo "\"><span class=\"socicon\">a</span></a></li>
            <li><a href=\"http://www.facebook.com/sharer.php?u=";
        // line 63
        if (isset($context["url"])) { $_url_ = $context["url"]; } else { $_url_ = null; }
        echo twig_escape_filter($this->env, $_url_, "html", null, true);
        echo "\"><span class=\"socicon\">b</span></a></li>
            <li><a href=\"https://plus.google.com/share?hl=en-GB&url=";
        // line 64
        if (isset($context["url"])) { $_url_ = $context["url"]; } else { $_url_ = null; }
        echo twig_escape_filter($this->env, $_url_, "html", null, true);
        echo "\"><span class=\"socicon\">c</span></a></li>
          </ul>
          
        </div><!--/.nav-collapse -->
      </div>
    </div>
    
    <div class=\"container theme-showcase\" role=\"main\">

\t  <div class=\"page-header\">
        <h1><span id=\"name\"><!-- Competition Name --></span><span id=\"popularity\"></span></h1>
      </div>
      
      <div class=\"row\">
      
        <div class=\"col-sm-12 text-center hidden-xs\">
          <script type=\"text/javascript\">
\t\t\tgoogle_ad_client = \"ca-pub-3145321863445101\";
\t\t\tgoogle_ad_slot = \"2379948764\";
\t\t\tgoogle_ad_width = 728;
\t\t\tgoogle_ad_height = 90;
\t\t  </script>
\t\t  <script type=\"text/javascript\" src=\"http://pagead2.googlesyndication.com/pagead/show_ads.js\"></script>
        </div><!-- /hidden-xs -->
        
        <div class=\"col-sm-12 text-center visible-xs\">
          <script type=\"text/javascript\">
            google_ad_client = \"ca-pub-3145321863445101\";
            google_ad_slot = \"5404189499\";
            google_ad_width = 234;
            google_ad_height = 60;
          </script>
\t\t  <script type=\"text/javascript\" src=\"http://pagead2.googlesyndication.com/pagead/show_ads.js\"></script>
        </div><!-- /visible-xs -->
      </div>
      
      <div class=\"row\">
          <form class=\"form-inline\" role=\"form\">
            <div class=\"form-group\">
\t            <div class=\"col-sm-12 full-width-form\">
\t              <input type=\"text\" placeholder=\"Search\" class=\"form-control typeahead\" data-provide=\"typeahead\" autocomplete=\"off\">
\t              <button type=\"submit\" class=\"btn btn-success\"><span class=\"glyphicon glyphicon-search\"></span></button>
\t            </div>
            </div>
          </form>
      </div>

      <div class=\"row\">
        <div class=\"col-sm-6\">
          <div class=\"panel panel-default\">
            <div class=\"panel-heading\">
              <h3 class=\"panel-title\">Recent Competitions</h3>
            </div>
            <div class=\"panel-body\">
              <ul class=\"unstyled-list\" id=\"competitions\"><!-- Recent Competitions List --></ul>
            </div>
          </div>
        </div><!-- /.col-sm-6 -->

        <div class=\"col-sm-6\">
          <div class=\"panel panel-default\">
            <div class=\"panel-heading\">
              <h3 class=\"panel-title\" id=\"screen_name\"><!-- Screen Name --></h3>
            </div>
            <div class=\"panel-body\">
              <ul class=\"unstyled-list\" id=\"twitter\"><!-- Status Tweets --></ul>
            </div>
          </div>
        </div><!-- /.col-sm-6 -->
      </div>
    </div> <!-- /container -->

    <script>
\t  \$.ajax({
\t\t    type: \"GET\",
\t\t\turl: \"http://api.fencingarchive.net/query/lastNCompetitionLinks/10\",
\t\t\tcrossDomain: true
\t\t  }).done( function(xml){
\t\t\t\$(xml).find('node').each( function() {
\t\t\t  \$('#competitions').append(\"<li>\" + \$(this).text() + \"</li>\");
\t\t\t})
\t\t  });
\t  
\t  \$.ajax({
\t\t    type: \"GET\",
\t\t\turl: \"http://api.fencingarchive.net/twitter/profile\",
\t\t\tcrossDomain: true
\t\t  }).done( function(xml){
\t\t\t  \$('#screen_name').append('@' + \$(xml).find('screen_name').text());
\t\t  });
\t\t
\t\t  
\t  \$.ajax({
\t\t    type: \"GET\",
\t\t\turl: \"http://api.fencingarchive.net/twitter/status\",
\t\t\tcrossDomain: true
\t\t  }).done( function(xml){
\t\t\t\$(xml).find('node').each( function() {
\t\t\t\t\$(this).find('text').each(function () {
\t\t\t\t  \$('#twitter').append(\"<li>\" + \$(this).text() + \"</li>\");
\t\t\t    })
\t\t\t})
\t\t  });
\t  
\t  var fencingArchiveSearch = new Bloodhound({
\t\t  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('page_url'),
\t\t  queryTokenizer: Bloodhound.tokenizers.whitespace,
\t\t  remote: {
\t\t\t  url: 'http://api.fencingarchive.net/search/%QUERY', 
\t\t\t  filter: function(list) {
\t\t\t\t  var searchObj = [];
\t\t\t\t  \$.each(list.hits.hits, function (key, value) {
\t\t\t\t\tconsole.log(value._source);
\t\t\t\t\tsearchObj.push(value._source);
\t\t\t\t  });
\t\t\t\t  console.log(searchObj);
\t\t\t\t  return searchObj;
\t\t\t  }
\t\t  }
\t\t});
\t  
\t  fencingArchiveSearch.initialize();
\t  
/*
\t  fencingArchiveSearch
\t  .done(function() { console.log('BloodHound - Success!'); })
\t  .fail(function() { console.log('BloodHound - Err!'); });
*/

\t  \$(\".typeahead\").typeahead(null, {
\t      name: \"typeahead\",
\t      displayKey: \"page_name\",
\t      source: fencingArchiveSearch.ttAdapter()
\t    });
\t  
    </script>

</body>
</html>
";
    }

    public function getTemplateName()
    {
        return "home.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  92 => 64,  87 => 63,  82 => 62,  19 => 1,);
    }
}

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<?php $path = sfConfig::get('sf_relative_url_root', preg_replace('#/[^/]+\.php5?$#', '', isset($_SERVER['SCRIPT_NAME']) ? $_SERVER['SCRIPT_NAME'] : (isset($_SERVER['ORIG_SCRIPT_NAME']) ? $_SERVER['ORIG_SCRIPT_NAME'] : ''))) ?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="robots" content="index, nofollow" />
    <title>Recording Questions Error Page</title>

    <link rel="shortcut icon" href="/favicon.ico" />
    <link rel="stylesheet" type="text/css" media="screen" href="/css/style.css" />

    <style>

        body { background: white; }
        a { font-size: 1.2em; }

    </style>

</head>
<body>

  <img src="/images/error_logo.jpg">

  <h2 class="title">Oops! An Error Occurred</h2>
  <h5>The server returned a "<?php echo $code ?> <?php echo $text ?>".</h5>

  <a href="javascript:history.go(-1)">Back to previous page</a><br/><br/>

   <form action="/">
       <input type="submit" class="submit" value="Return To Homepage"/>
   </form>

</body>
</html>

<?php


function link_to_active($name, $url, $class = '', $activ = false, $title = '')
{
  use_helper('Url');

  $context = sfContext::getInstance();
  $uri = $context->getRequest()->getUri();
  $genUrl = url_for($url, true);

  $parsURL = parse_url($genUrl);

  if(strpos($uri, $parsURL['path']))
  {
    return link_to($name, $url, array('class' => $class));
  }

  if(($uri == $genUrl) || $activ)
  {
    return link_to($name, $url, array('class' => $class, 'title' => $title));
  }
  else
    return link_to($name, $url);
}

function date_age_tag($start, $short = false)
{
  $uts['start']      =    strtotime( $start );
  $uts['end']        =    time();//strtotime( $end );

  if( $uts['start']!==-1 && $uts['end']!==-1 )
  {
    if( $uts['end'] >= $uts['start'] )
    {
      $diff = $uts['end'] - $uts['start'];
      
      if($diff < 300)
      {
        return 'just now';
      }

      if($diff < 300)
      {
        return 'just now';
      }

      if( $days=intval((floor($diff/86400))) )
        $diff = $diff % 86400;
      if( $hours=intval((floor($diff/3600))) )
        $diff = $diff % 3600;
      if( $minutes=intval((floor($diff/60))) )
        $diff = $diff % 60;

      if($short)
      {
        return ($hours.' h '.$minutes.' min ago');
      }
      elseif($days > 3)   // don't display minutes if date is older than 3 days
      {
        return ($days.' day '.$hours.' h ');
      }
      else
      {
        return ($days.' day '.$hours.' h '.$minutes.' min ago');
      }
    }
    else
    {
      return false;
    }
  }
  else
  {
    return false;
  }
  return( false );
}

function getLableNavigation($nav)
{
  if($nav == 'recent' || $nav == null)
  {
    return 'Recent Questions';
  }
  if($nav == 'popular')
  {
    return 'Popular Questions';
  }
  if($nav == 'lastWeek')
  {
    return 'Last Week Questions';
  }
  if($nav == 'lastMonth')
  {
    return 'Last Month Questions';
  }
  if($nav == 'unanswered')
  {
    return 'Unanswered Questions';
  }

}

function captchagd($name = '', $value = '')
{
//	\' + Math.random() + \'
  use_helper('Url');
  $url = url_for1('sfCaptchaGD/GetImage', true);
  $img = "<a onClick='return false' title='Reload image'><img src='" . $url .'?r=' . time() . "' onClick='this.src=\"{$url}?r=\" + Math.random() + \"&reload=1\"'></a>";
  return $img;
}

function initTinyMce()
{
  $tinymce_options = '
        theme : "advanced",
        file_browser_callback : "sfMediaLibrary.fileBrowserCallBack",
        remove_script_host : true,
        theme_advanced_resizing : true,
        theme_advanced_buttons2 : "",
        theme_advanced_buttons3 : "",
        theme_advanced_path : false,
   ';

  // add text editor buttons
  // user can only post links or images after 15 experience.
  $userId = sfContext::getInstance()->getUser()->getCurrentUser()->getId();

  if(fpExperience::checkForAction($userId, 'post_link'))
  {
    $buttons = 'theme_advanced_buttons1 : "bold,italic,strikethrough,|,bullist,numlist,|,link,blockquote,image,|,outdent,indent,undo,redo"';
  } else
  {
    $buttons = 'theme_advanced_buttons1 : "bold,italic,strikethrough,|,bullist,numlist,|,blockquote,|,outdent,indent,undo,redo"';
  }

  $tinymce_options .= $buttons;

  return array(
      'class' => 'textarea resizable',
      'rows'  => '5',
      'cols'  => '5',
      'rich' => true,
      'tinymce_options' => $tinymce_options,
  );
}

/**
 * @param String $href [Absolute or internat URI]
 * @param String $rel [value for 'rel' attribtue, e.g. 'canonical']
 *
 * @return void
 */
function add_link($href, $rel)
{
  $slot = get_slot('links');

  try
  {
    $href = url_for($href, true);
    $slot  .= "\n<link rel=\"$rel\" href=\"$href\" />";
  }
  catch (InvalidArgumentException $e)
  {
    $slot  .= "\n<!-- Could not add Link '$href': Only absolute or internal URIs allowed -->";
  }
  slot('links', $slot);
}

/**
 * creates a slot for the skimlinks javascript code
 */
function add_skimlinks()
{
  $slot = get_slot('skimlinks');

  $slot = '
    <script type="text/javascript" src="http://recordingquestionscom.skimlinks.com/api/skimlinks.js"></script>
    <script type="text/javascript">
        var skimlinks_pub_id = \'1330X519115\';
        skimlinks();
    </script>
    ';

  slot('skimlinks', $slot);
}



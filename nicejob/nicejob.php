<?php
/**
Plugin Name: NiceJob
Plugin URI: https://get.nicejob.co/
Version: 3.6.5
Author: nicejob
Description: Easily add NiceJob Stories, Reviews, Trust Badge, Engage, and Collect Leads and Reviews to your Wordpress site.
*/

/**
 * nicejob-showroom shortcode handle function
 * usage : [nicejob-showroom id=1]
 * @param  array $atts
 * @return  string
 */
function nicejob_showroom($atts) {
  $default_domain = 'app.nicejob.co';
  $default_review_domain = 'reviews.nicejob.co';
  $a = shortcode_atts( array(
    'id' => 0,
    'domain' => $default_domain,
    'review_domain' => $default_review_domain
  ), $atts );
  $id = (int) $a['id'];

  if($id==0) {
    $company_id = get_site_option('nicejob_company_id');
    $id = ($company_id)?$company_id:0;
  }

  $domain = $default_domain;
  $app_url = 'https://'.$domain;
  if(isset($a['domain']) && $a['domain']!=''){
    $domain = $a['domain'];
    $app_url = 'http'.(($domain==$default_domain)?'s':'').'://'.$domain;
  }

  $review_domain = $default_review_domain;
  if(isset($a['review_domain']) && $a['review_domain']!=''){
    $review_domain = $a['review_domain'];
  }

  ob_start();
  ?>
  <div class="nicework-showroom-container"></div><script>var NWDOMAIN="<?php echo esc_attr($domain); ?>";var NWRDOMAIN="<?php echo esc_attr($review_domain); ?>";!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.setAttribute("data-id",<?php echo esc_js($id) ?>);js.setAttribute("data-campaign","showroom");js.src="<?php echo esc_url($app_url); ?>/js/nicework-showroom.js";d.getElementsByTagName('head')[0].appendChild(js,fjs);}}(document,"script","nicework-showroomjs");</script>
  <?php
  return ob_get_clean();
}
add_shortcode( 'nicejob-showroom', 'nicejob_showroom' );


/**
 * nicejob-review-feed shortcode handle function
 * usage : [nicejob-review-feed id=1 column='single' width=300 height=400]
 * @param  array $atts
 * @return  string
 */
function nicejob_review_feed($atts) {
  $default_domain = 'app.nicejob.co';
  $a = shortcode_atts( array(
    'id' => 0,
    'column' => 'single',
    'width' => 0,
    'height' => 0,
    'domain' => $default_domain
  ), $atts );
  $id = (int) $a['id'];

  if($id==0) {
    $company_id = get_site_option('nicejob_company_id');
    $id = ($company_id)?$company_id:0;
  }

  $domain = $default_domain;
  $app_url = 'https://'.$domain;
  if(isset($a['domain']) && $a['domain']!=''){
    $domain = $a['domain'];
    $app_url = 'http'.(($domain==$default_domain)?'s':'').'://'.$domain;
  }

  ob_start();
  ?>
  <a class="nicework-review-feed-widget" href="<?php echo esc_url($app_url); ?>" data-option="<?php echo esc_attr($a['column'] .",". $a['width'] .",". $a['height']);?>">powered by NiceWork</a><script>var NWDOMAIN="<?php echo esc_attr($domain); ?>";!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.setAttribute("data-id",<?php echo esc_js($id); ?>);js.src="<?php echo esc_url($app_url) ?>/js/nicework-widgets.js";fjs.parentNode.appendChild(js,fjs);}}(document,"script","nicework-widgetjs");</script>
  <?php
  return ob_get_clean();
}
add_shortcode( 'nicejob-review-feed', 'nicejob_review_feed' );

/**
 * nicejob-stories shortcode handle function
 * usage : [nicejob-stories style='single' show='all']
 * @param  array $atts
 * @return  string
 */
function nicejob_stories($atts) {
  $cdn_js_url = 'https://cdn.nicejob.co';
  $platform_js_url = 'https://platform.nicejob.co';
  $monolith_app_url = 'https://app.nicejob.co';
  $app_url = 'https://app.nicejob.co';
  $review_url = 'https://nicejob.co';
  $a = shortcode_atts( array(
    'id' => 0,
    'style' => 'grid',
    'show' => 'all',
    'max-height' => 0,
    'branding' => 'top',
    'js-url' => $cdn_js_url,
    'review-url' => $review_url,
    'app-url' => $monolith_app_url,
	'source' => ''
  ), $atts );

  $salt = 'N1ce70B';
  if($a['id']==0) {
    $company_id = get_site_option('nicejob_company_id');
    $a['id'] = ($company_id)?$company_id:0;
  }

  $hash = $a['id'];
  if(strlen($a['id'])>5) {
    // Has alphabet, meaning it's md5, it's a monolith id
    if(preg_match("/[a-z]/i", $a['id'])) {
      $a['js-url'] = $platform_js_url;
      $a['app-url'] = $monolith_app_url;
    }
  } else if($a['id']!=0) {
    $hash = md5("{$a['id']}:".$salt);
    $a['js-url'] = $platform_js_url;
    $a['app-url'] = $monolith_app_url;
  }

  $params = '';
  $params .= ($a['style']=='grid')?'':' data-style="single"';
  switch($a['show']) {
    case 'photos':
      $params .= ' data-filter-media="show"';
      break;
    case 'reviews':
      $params .= ' data-filter-media="hide"';
      break;
    case 'reviews-no-photos':
      $params .= ' data-filter-media="hide" data-media="hide"';
      break;
  }
  $params .= (intval($a['max-height'])>0)?' data-max-height="'.intval($a['max-height']).'"':'';
  $params .= ($a['branding']=='top')?'':' data-branding="bottom"';
  $source = $a['source'] ?? '';
  $params .= get_data_source_attr($source);
  $js_url = $a['js-url'];
  $nj_app = ($a['app-url']!=$app_url)?' nj-app="'.$a['app-url'].'"':'';
  $nj_review = ($a['review-url']!=$review_url)?' nj-review="'.$a['review-url'].'"':'';
  ob_start();
  ?>
  <a class="nj-stories" href="<?php echo esc_url($a['review-url']); ?>/<?php echo esc_attr($hash); ?>"<?php echo esc_attr($params); ?>>powered by NiceJob</a><script type="text/javascript"<?php echo wp_kses_post($nj_app.$nj_review); ?> src="<?php echo esc_url($js_url); ?>/js/sdk.min.js?id=<?php echo esc_attr($hash); ?>" defer></script>
  <?php
  return ob_get_clean();
}
add_shortcode('nicejob-stories', 'nicejob_stories');

/**
 * nicejob-badge shortcode handle function
 * usage : [nicejob-badge show-reviews="0"]
 * @param  array $atts
 * @return  string
 */
function nicejob_badge($atts) {
  $cdn_js_url = 'https://cdn.nicejob.co';
  $platform_js_url = 'https://platform.nicejob.co';
  $monolith_app_url = 'https://app.nicejob.co';
  $app_url = 'https://app.nicejob.co';
  $review_url = 'https://nicejob.co';
  $a = shortcode_atts( array(
    'id' => 0,
    'show-reviews' => '0',
    'js-url' => $cdn_js_url,
    'review-url' => $review_url,
    'app-url' => $app_url,
	'source' => ''
  ), $atts );

  $salt = 'N1ce70B';
  if($a['id']==0) {
    $company_id = get_site_option('nicejob_company_id');
    $a['id'] = ($company_id)?$company_id:0;
  }

  $hash = $a['id'];
  if(strlen($a['id'])>5) {
    // Has alphabet, meaning it's md5, it's a monolith id
    if(preg_match("/[a-z]/i", $a['id'])) {
      $a['js-url'] = $platform_js_url;
      $a['app-url'] = $monolith_app_url;
    }
  } else if($a['id']!=0) {
    $hash = md5("{$a['id']}:".$salt);
    $a['js-url'] = $platform_js_url;
    $a['app-url'] = $monolith_app_url;
  }

  $params = '';
  $params .= (intval($a['show-reviews'])>0)?' data-show-reviews="1"':'';
  $source = $a['source'] ?? '';
  $params .= get_data_source_attr($source);
  $js_url = $a['js-url'];
  $nj_app = ($a['app-url']!=$app_url)?' nj-app="'.$a['app-url'].'"':'';
  $nj_review = ($a['review-url']!=$review_url)?' nj-review="'.$a['review-url'].'"':'';
  ob_start();
  ?>
  <a class="nj-badge" href="<?php echo esc_url($a['review-url']); ?>/<?php echo esc_attr($hash); ?>"<?php echo esc_attr($params); ?>>powered by NiceJob</a><script type="text/javascript"<?php echo wp_kses_post($nj_app.$nj_review); ?> src="<?php echo esc_url($js_url); ?>/js/sdk.min.js?id=<?php echo esc_attr($hash); ?>" defer></script>
  <?php
  return ob_get_clean();
}
add_shortcode('nicejob-badge', 'nicejob_badge');

/**
 * nicejob-engage shortcode handle function
 * usage : [nicejob-engage positon="right" event-types="Booking,Review"]
 * @param  array $atts
 * @return  string
 */
function nicejob_engage($atts) {
  $cdn_js_url = 'https://cdn.nicejob.co';
  $platform_js_url = 'https://platform.nicejob.co';
  $monolith_app_url = 'https://app.nicejob.co';
  $app_url = 'https://app.nicejob.co';
  $review_url = 'https://nicejob.co';
  $default_events = 'Booking,Review';
  $a = shortcode_atts( array(
    'id' => 0,
    'position' => 'left',
    'event-types' => $default_events,
    'js-url' => $cdn_js_url,
    'review-url' => $review_url,
    'app-url' => $app_url,
    'mobile' => ''
  ), $atts );

  $salt = 'N1ce70B';
  if($a['id']==0) {
    $company_id = get_site_option('nicejob_company_id');
    $a['id'] = ($company_id)?$company_id:0;
  }

  $hash = $a['id'];
  if(strlen($a['id'])>5) {
    // Has alphabet, meaning it's md5, it's a monolith id
    if(preg_match("/[a-z]/i", $a['id'])) {
      $a['js-url'] = $platform_js_url;
      $a['app-url'] = $monolith_app_url;
    }
  } else if($a['id']!=0) {
    $hash = md5("{$a['id']}:".$salt);
    $a['js-url'] = $platform_js_url;
    $a['app-url'] = $monolith_app_url;
  }

  $params = '';
  $params .= ' data-position="'.(($a['position']=='left')?'left':'right').'"';
  $params .= ' data-event-types="'.(($a['event-types']!='')?$a['event-types']:$default_events).'"';
  $params .= ($a['mobile']=='hide')?' data-mobile="hide"':'';
  $js_url = $a['js-url'];
  $nj_app = ($a['app-url']!=$app_url)?' nj-app="'.$a['app-url'].'"':'';
  $nj_review = ($a['review-url']!=$review_url)?' nj-review="'.$a['review-url'].'"':'';
  ob_start();
  ?>
  <div class="nj-engage"<?php echo wp_kses_post($params); ?>></div><script type="text/javascript"<?php echo wp_kses_post($nj_app.$nj_review); ?> src="<?php echo esc_url($js_url); ?>/js/sdk.min.js?id=<?php echo esc_attr($hash); ?>" defer></script>
  <?php
  return ob_get_clean();
}
add_shortcode('nicejob-engage', 'nicejob_engage');

/**
 * nicejob-lead shortcode handle function
 * usage : [nicejob-lead type="button" class="button-right button-blue" text="Quick Estimate"]
 * @param  array $atts
 * @return  string
 */
function nicejob_lead($atts) {
  $cdn_js_url = 'https://cdn.nicejob.co';
  $platform_js_url = 'https://platform.nicejob.co';
  $monolith_app_url = 'https://app.nicejob.co';
  $app_url = 'https://app.nicejob.co';
  $review_url = 'https://nicejob.co';
  $a = shortcode_atts( array(
    'id' => 0,
    'type' => 'a',
    'class' => '',
    'text' => 'Click here for an estimate',
    'js-url' => $cdn_js_url,
    'review-url' => $review_url,
    'app-url' => $app_url
  ), $atts );

  $salt = 'N1ce70B';
  if($a['id']==0) {
    $company_id = get_site_option('nicejob_company_id');
    $a['id'] = ($company_id)?$company_id:0;
  }

  $hash = $a['id'];
  if(strlen($a['id'])>5) {
    // Has alphabet, meaning it's md5, it's a monolith id
    if(preg_match("/[a-z]/i", $a['id'])) {
      $a['js-url'] = $platform_js_url;
      $a['app-url'] = $monolith_app_url;
    }
  } else if($a['id']!=0) {
    $hash = md5("{$a['id']}:".$salt);
    $a['js-url'] = $platform_js_url;
    $a['app-url'] = $monolith_app_url;
  }

  $params = '';
  $params .= ' class="nj-lead'.(($a['class']!='')?' '.trim($a['class']):"").'"';
  if($a['type']=='a') {
    $params .= ' href="'.$review_url.'/'.$a['id'].'"';
  }
  $js_url = $a['js-url'];
  $nj_app = ($a['app-url']!=$app_url)?' nj-app="'.$a['app-url'].'"':'';
  $nj_review = ($a['review-url']!=$review_url)?' nj-review="'.$a['review-url'].'"':'';
  ob_start();
  if($a['type']=='button') {
  ?>
    <button type="button" <?php echo wp_kses_post($params); ?>><?php echo esc_html($a['text']); ?></button>
  <?php } else { ?>
    <a <?php echo wp_kses_post($params); ?>><?php echo esc_html($a['text']); ?></a>
  <?php } ?>
  <script type="text/javascript"<?php echo wp_kses_post($nj_app.$nj_review); ?> src="<?php echo esc_url($js_url); ?>/js/sdk.min.js?id=<?php echo esc_attr($hash); ?>" defer></script>
  <?php
  return ob_get_clean();
}
add_shortcode('nicejob-lead', 'nicejob_lead');

/**
 * nicejob-review shortcode handle function
 * usage : [nicejob-review type="button" class="button-right button-blue" text="Leave us a review!"]
 * @param  array $atts
 * @return  string
 */
function nicejob_review($atts) {
  $cdn_js_url = 'https://cdn.nicejob.co';
  $platform_js_url = 'https://platform.nicejob.co';
  $monolith_app_url = 'https://app.nicejob.co';
  $app_url = 'https://app.nicejob.co';
  $review_url = 'https://nicejob.co';
  $a = shortcode_atts( array(
    'id' => 0,
    'type' => 'a',
    'class' => '',
    'text' => 'Leave us a review!',
    'js-url' => $cdn_js_url,
    'review-url' => $review_url,
    'app-url' => $app_url
  ), $atts );

  $salt = 'N1ce70B';
  if($a['id']==0) {
    $company_id = get_site_option('nicejob_company_id');
    $a['id'] = ($company_id)?$company_id:0;
  }

  $hash = $a['id'];
  if(strlen($a['id'])>5) {
    // Has alphabet, meaning it's md5, it's a monolith id
    if(preg_match("/[a-z]/i", $a['id'])) {
      $a['js-url'] = $platform_js_url;
      $a['app-url'] = $monolith_app_url;
    }
  } else if($a['id']!=0) {
    $hash = md5("{$a['id']}:".$salt);
    $a['js-url'] = $platform_js_url;
    $a['app-url'] = $monolith_app_url;
  }

  $params = '';
  $params .= ' class="nj-review'.(($a['class']!='')?' '.trim($a['class']):"").'"';
  if($a['type']=='a') {
    $params .= ' href="'.$review_url.'/'.$a['id'].'"';
  }
  $js_url = $a['js-url'];
  $nj_app = ($a['app-url']!=$app_url)?' nj-app="'.$a['app-url'].'"':'';
  $nj_review = ($a['review-url']!=$review_url)?' nj-review="'.$a['review-url'].'"':'';
  ob_start();
  if($a['type']=='button') {
  ?>
    <button type="button" <?php echo wp_kses_post($params); ?>><?php echo esc_html($a['text']); ?></button>
  <?php } else { ?>
    <a <?php echo wp_kses_post($params); ?>><?php echo esc_html($a['text']); ?></a>
  <?php } ?>
  <script type="text/javascript"<?php echo wp_kses_post($nj_app.$nj_review); ?> src="<?php echo esc_url($js_url); ?>/js/sdk.min.js?id=<?php echo esc_attr($hash); ?>" defer></script>
  <?php
  return ob_get_clean();
}
add_shortcode('nicejob-review', 'nicejob_review');

function nicejob_recommendation($atts = [], ?string $content = null, string $tag = ''): string
{
    if (is_string($atts) && empty($atts)) {
        $atts = [];
    }

    $atts = array_change_key_case($atts, CASE_LOWER);
	$wporgAtts = shortcode_atts(
            [
                'type' => 'a',
                'text' => 'Recommend us!',
                'class' => '',
            ],
            $atts,
            $tag
	);

	$companyId = get_site_option('nicejob_company_id');
    $type = esc_html__($wporgAtts['type']);
    $text = esc_html__($wporgAtts['text']);
    $class = esc_html__($wporgAtts['class']);

    switch ($type) {
        case 'button':
            $link = <<<HTML
            <button type="button" class="nj-recommendation $class">$text</button>
            HTML;
            break;
        default:
	        $link = <<<HTML
            <a href="#" class="nj-recommendation $class">$text</a>
            HTML;
    }
    return <<<HTML
        $link
        <script type="text/javascript" src="https://cdn.nicejob.co/js/sdk.min.js?id=$companyId" defer></script>
    HTML;
}

/**
 * Central location to create all shortcodes.
 */
function nicejob_shortcodes_init() {
	add_shortcode('nicejob-recommendation', 'nicejob_recommendation');
}

add_action( 'init', 'nicejob_shortcodes_init' );

/**
 * Shows admin menu only for network admin menu
 *
 * @uses add_options_page
 * @action network_admin_menu
 * @return null
 */
function action_nicejob_options() {
  add_menu_page('NiceJob', 'NiceJob', 'manage_options', __FILE__, 'nicejob_options');
}

/**
 * NiceJob admin menu
 *
 * @action nicejob_options
 * @return null
 */
function nicejob_options() {
  if(
    !empty($_POST) &&
    isset($_POST['submit']) && 
    isset($_POST['nicejob_company_id']) &&
    check_admin_referer('update_company_id', '_wp_update_company_id_nonce')
  ) {
    $new_company_id = esc_attr(wp_unslash($_POST['nicejob_company_id']));
    update_site_option('nicejob_company_id', $new_company_id);
    add_settings_error('general', 'settings_updated', 'Settings saved!', 'updated');
  }
  $company_id = get_site_option('nicejob_company_id');
  ?>
  <div class="wrap">
    <!--h2>NiceJob</h2-->
    <p><?=settings_errors(); // phpcs:ignore?></p>
    <h3><img src="<?=esc_url(plugin_dir_url(__FILE__))."/nicejob-logo.png"?>" style="width:150px;" /></h3>
    <form action="" method="POST">
      <div>
        <label for="nicejob-company-id">Company ID</label>
        <input id="nicejob-company-id" type="text" name="nicejob_company_id" value="<?=esc_attr($company_id)?>" style="width:200px;" />
        <a href="https://app.nicejob.co/settings/company/profile" target="_blank" class="button">Get your Company ID</a>
      </div>
      <?=wp_nonce_field('update_company_id', '_wp_update_company_id_nonce', true, false); // phpcs:ignore?>
      <?=submit_button('Save'); // phpcs:ignore?>
    </form>
    <h2>Using NiceJob plugin</h2>
    <p>A new button will appear on the rich editor: NiceJob Stories and NiceJob Badge.</p>
    <h3>Stories</h3>
    <code>[nicejob-stories]</code>
    <ul>
      <li>&bull; <strong>id</strong>: is your NiceJob company_id</li>
      <li>&bull; <strong>style</strong>: [grid/single] layout style (optional, default is grid)</li>
      <li>&bull; <strong>show</strong>: [all/photos/reviews/reviews-no-photos] stories to show (default is all)</li>
      <li>&bull; <strong>max-height</strong>: stories maximum height (optional, default none)</li>
      <li>&bull; <strong>branding</strong>: [top/bottom] brand position (optional, default top)</li>
    </ul>
    <p>Example usage of complete options:</p>
    <code>[nicejob-stories style="grid" show="reviews" max-height=300 branding="bottom"]</code>
    <p>Stories widget help article: <a href="https://help.nicejob.co/en/articles/1082635-how-to-install-the-stories-widget" target="_blank">How To Install The Stories Widget</a></p>
    <p>&nbsp;</p>
    <h3>Badge</h3>
    <code>[nicejob-badge]</code>
    <ul>
      <li>&bull; <strong>id</strong>: is your NiceJob company_id</li>
      <li>&bull; <strong>show-reviews</strong>: [1/0] Show reviews</li>
    </ul>
    <p>Example usage of complete options:</p>
    <code>[nicejob-badge show-reviews="1"]</code>
    <p>&nbsp;</p>
    <h3>Engage</h3>
    <code>[nicejob-engage]</code>
    <ul>
      <li>&bull; <strong>position</strong>: position on screen</li>
      <li>&bull; <strong>even-types</strong>: events to show. Comma separated, for eg: Booking,Review</li>
      <li>&bull; <strong>mobile</strong>: [show/hide] Show or hide on mobile device (optional), default: show</li>
    </ul>
    <p>Example usage of complete options:</p>
    <code>[nicejob-engage position="left" event-types="Booking,Review"]</code>
    <p>&nbsp;</p>
    <h3>Collect Leads</h3>
    <code>[nicejob-lead]</code>
    <ul>
      <li>&bull; <strong>type</strong>: [a/button] anchor link or button, default: a</li>
      <li>&bull; <strong>class</strong>: additional element class (optional)</li>
      <li>&bull; <strong>text</strong>: element text, default: Click here for an estimate</li>
    </ul>
    <p>Example usage of complete options:</p>
    <code>[nicejob-lead type="button" class="button-right button-blue" text="Click here for an estimate"]</code>
    <p>If you already add one of above widgets, you can make a lead button anywhere by adding element class <strong>nj-lead</strong> to an anchor or button element, it will automatically enable that button to open lead form.</p>
    <p>&nbsp;</p>
    <h3>Collect Reviews</h3>
    <code>[nicejob-review]</code>
    <ul>
      <li>&bull; <strong>type</strong>: [a/button] anchor link or button, default: a</li>
      <li>&bull; <strong>class</strong>: additional element class (optional)</li>
      <li>&bull; <strong>text</strong>: element text, default: Leave us a review!</li>
    </ul>
    <p>Example usage of complete options:</p>
    <code>[nicejob-review type="button" class="button-right button-blue" text="Leave us a review!"]</code>
    <p>If you already add one of above widgets, you can make a review button anywhere by adding element class <strong>nj-review</strong> to an anchor or button element, it will automatically enable that button to open review form.</p>
      <br/>
      <h3>Collect Recommendations</h3>
      <code>[nicejob-recommendation]</code>
      <ul>
          <li>&bull; <strong>type</strong>: [a/button] anchor link or button, default: a (optional)</li>
          <li>&bull; <strong>class</strong>: additional element class (optional)</li>
          <li>&bull; <strong>text</strong>: element text, default: Recommend us! (optional)</li>
      </ul>
      <p>Example usage of complete options:</p>
      <code>[nicejob-recommendation type="button" class="button-right button-blue" text="Recommend us!"]</code>
  </div>
  <?php
}
add_action('admin_menu', 'action_nicejob_options');

add_action('admin_head', 'nicejob_admin_icon');
function nicejob_admin_icon() {
  echo '<style>
    #adminmenu #toplevel_page_nicejob-nicejob .menu-icon-generic div.wp-menu-image:before {
      background: no-repeat url('.esc_url(plugin_dir_url(__FILE__))."/nicejob-button-40-white.png".') 0px 6px scroll;
      background-size: 20px;
      font-family: auto;
      color: transparent;
      content: \'\';
    }
  </style>';
}

function enqueue_plugin_scripts($plugin_array) {
  //enqueue TinyMCE plugin script with its ID.
  $plugin_array["nicejob_stories_button"] =  plugin_dir_url(__FILE__) . "nicejob-stories-button.js";
  $plugin_array["nicejob_badge_button"] =  plugin_dir_url(__FILE__) . "nicejob-badge-button.js";
  $plugin_array["nicejob_engage_button"] =  plugin_dir_url(__FILE__) . "nicejob-engage-button.js";
  $plugin_array["nicejob_lead_button"] =  plugin_dir_url(__FILE__) . "nicejob-lead-button.js";
  $plugin_array["nicejob_review_button"] =  plugin_dir_url(__FILE__) . "nicejob-review-button.js";
  $plugin_array["nicejob_recommendation_button"] =  plugin_dir_url(__FILE__) . "nicejob-recommendation-button.js";
  return $plugin_array;
}
add_filter("mce_external_plugins", "enqueue_plugin_scripts");

function register_buttons_editor($buttons) {
	//register buttons with their id.
	$buttons[] = "nicejob_stories_button";
	$buttons[] = "nicejob_badge_button";
	$buttons[] = "nicejob_engage_button";
	$buttons[] = "nicejob_lead_button";
	$buttons[] = "nicejob_review_button";
	$buttons[] = "nicejob_recommendation_button";
	return $buttons;
}
add_filter("mce_buttons", "register_buttons_editor");

function get_data_source_attr(string $source = ''): string {
    if (!$source) {
        return '';
    }
    $trimmedSource = trim($source, ',');
    if (preg_match("/^[0-9]+(,[0-9]+)*$/", $trimmedSource)) {
        return ' data-source="' . $trimmedSource . '"';
    }
    if (strtolower($source) === 'account') {
        return ' data-source="account"';
    }
    
    return '';
}

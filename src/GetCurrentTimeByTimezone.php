<?php

/**
* @file providing the service that return time by timezone.
*
*/

namespace  Drupal\assignment;

use Drupal\Core\Datetime\DateFormatter;


class GetCurrentTimeByTimezone {
 
 /**
  * @var DateFormatter $dateFormatter.
  */ 
 protected $dateFormatter;
 
 /**
   * @param Drupal\Core\Datetime\DateFormatter $dateFormatter;
   */
 public function __construct(DateFormatter $dateFormatter) {
   $this->dateFormatter = $dateFormatter;
 }

 public function  getTimeWithTimezone(){

    // Get country, city and timezone values which is set in site config form.
    $country = \Drupal::config('site_config_form.adminsettings')->get('site_config_country');
    $city = \Drupal::config('site_config_form.adminsettings')->get('site_config_city');
    $timezone = \Drupal::config('site_config_form.adminsettings')->get('site_config_timezone');  
    if($country && $city && $timezone){

      // Use dateFormatter service to get time by timezone.
      $date_time = $this->dateFormatter->format(time(), 'custom', 'jS M Y - h:i A', $timezone);
      return $date_time;
    }
 }
}
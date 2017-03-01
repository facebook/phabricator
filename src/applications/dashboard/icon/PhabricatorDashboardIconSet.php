<?php

final class PhabricatorDashboardIconSet
  extends PhabricatorIconSet {

  const ICONSETKEY = 'dashboards';

  public function getSelectIconTitleText() {
    return pht('Choose Dashboard Icon');
  }

  protected function newIcons() {
    $map = array(
      'fa-home' => pht('Home'),
      'fa-th-large' => pht('Blocks'),
      'fa-columns' => pht('Columns'),
      'fa-bookmark' => pht('Page Saver'),

      'fa-book' => pht('Knowledge'),
      'fa-bomb' => pht('Kaboom'),
      'fa-pie-chart' => pht('Apple Blueberry'),
      'fa-bar-chart' => pht('Serious Business'),

      'fa-bell' => pht('Ding Ding'),
      'fa-credit-card' => pht('Plastic Debt'),
      'fa-code' => pht('PHP is Life'),
      'fa-sticky-note' => pht('To Self'),

      'fa-newspaper-o' => pht('Stay Woke'),
      'fa-server' => pht('Metallica'),
      'fa-hashtag' => pht('Corned Beef'),
      'fa-group' => pht('Triplets'),
    );

    $icons = array();
    foreach ($map as $key => $label) {
      $icons[] = id(new PhabricatorIconSetIcon())
        ->setKey($key)
        ->setLabel($label);
    }

    return $icons;
  }

}

<?php

final class HarbormasterBuildArcanistAutoplan
  extends HarbormasterBuildAutoplan {

  const PLANKEY = 'arcanist';

  public function getAutoplanPlanKey() {
    return self::PLANKEY;
  }

  public function getAutoplanName() {
    return pht('Arcanist Client Results');
  }

}

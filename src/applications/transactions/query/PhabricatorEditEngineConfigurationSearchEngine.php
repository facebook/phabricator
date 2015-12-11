<?php

final class PhabricatorEditEngineConfigurationSearchEngine
  extends PhabricatorApplicationSearchEngine {

  private $engineKey;

  public function setEngineKey($engine_key) {
    $this->engineKey = $engine_key;
    return $this;
  }

  public function getEngineKey() {
    return $this->engineKey;
  }

  public function canUseInPanelContext() {
    return false;
  }

  public function getResultTypeDescription() {
    return pht('Forms');
  }

  public function getApplicationClassName() {
    return 'PhabricatorTransactionsApplication';
  }

  public function newQuery() {
    return id(new PhabricatorEditEngineConfigurationQuery())
      ->withEngineKeys(array($this->getEngineKey()));
  }

  protected function buildQueryFromParameters(array $map) {
    $query = $this->newQuery();

    $is_create = $map['isCreate'];
    if ($is_create !== null) {
      $query->withIsDefault($is_create);
    }

    $is_edit = $map['isEdit'];
    if ($is_edit !== null) {
      $query->withIsEdit($is_edit);
    }

    return $query;
  }

  protected function buildCustomSearchFields() {
    return array(
      id(new PhabricatorSearchThreeStateField())
        ->setLabel(pht('Create'))
        ->setKey('isCreate')
        ->setOptions(
          pht('Show All'),
          pht('Hide Create Forms'),
          pht('Show Only Create Forms')),
      id(new PhabricatorSearchThreeStateField())
        ->setLabel(pht('Edit'))
        ->setKey('isEdit')
        ->setOptions(
          pht('Show All'),
          pht('Hide Edit Forms'),
          pht('Show Only Edit Forms')),
    );
  }

  protected function getDefaultFieldOrder() {
    return array();
  }

  protected function getURI($path) {
    return '/transactions/editengine/'.$this->getEngineKey().'/'.$path;
  }

  protected function getBuiltinQueryNames() {
    $names = array(
      'all' => pht('All Forms'),
      'create' => pht('Create Forms'),
      'modify' => pht('Edit Forms'),
    );

    return $names;
  }

  public function buildSavedQueryFromBuiltin($query_key) {
    $query = $this->newSavedQuery();
    $query->setQueryKey($query_key);

    switch ($query_key) {
      case 'all':
        return $query;
      case 'create':
        return $query->setParameter('isCreate', true);
      case 'modify':
        return $query->setParameter('isEdit', true);
    }

    return parent::buildSavedQueryFromBuiltin($query_key);
  }

  protected function renderResultList(
    array $configs,
    PhabricatorSavedQuery $query,
    array $handles) {
    assert_instances_of($configs, 'PhabricatorEditEngineConfiguration');
    $viewer = $this->requireViewer();
    $engine_key = $this->getEngineKey();

    $list = id(new PHUIObjectItemListView())
      ->setUser($viewer);
    foreach ($configs as $config) {
      $item = id(new PHUIObjectItemView())
        ->setHeader($config->getDisplayName());

      $id = $config->getID();
      if ($id) {
        $item->setObjectName(pht('Form %d', $id));
        $key = $id;
      } else {
        $item->setObjectName(pht('Builtin'));
        $key = $config->getBuiltinKey();
      }
      $item->setHref("/transactions/editengine/{$engine_key}/view/{$key}/");

      if ($config->getIsDefault()) {
        $item->addIcon('fa-plus', pht('Default'));
      }

      if ($config->getIsEdit()) {
        $item->addIcon('fa-pencil', pht('Edit Form'));
      }

      if ($config->getIsDisabled()) {
        $item->addIcon('fa-ban', pht('Disabled'));
      }

      $list->addItem($item);
    }

    return id(new PhabricatorApplicationSearchResultView())
      ->setObjectList($list);
  }
}

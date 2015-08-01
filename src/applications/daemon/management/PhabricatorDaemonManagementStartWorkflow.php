<?php

final class PhabricatorDaemonManagementStartWorkflow
  extends PhabricatorDaemonManagementWorkflow {

  protected function didConstruct() {
    $this
      ->setName('start')
      ->setSynopsis(
        pht(
          'Start the standard configured collection of Phabricator daemons. '.
          'This is appropriate for most installs. Use **%s** to '.
          'customize which daemons are launched.',
          'phd launch'))
      ->setArguments(
        array(
          array(
            'name' => 'keep-leases',
            'help' => pht(
              'By default, **%s** will free all task leases held by '.
              'the daemons. With this flag, this step will be skipped.',
              'phd start'),
          ),
          array(
            'name' => 'force',
            'help' => pht('Start daemons even if daemons are already running.'),
          ),
          array(
            'name' => 'foreground',
            'help' => pht('Start daemons in foreground.'),
          ),
          $this->getAutoscaleReserveArgument(),
        ));
  }

  public function execute(PhutilArgumentParser $args) {
    return $this->executeStartCommand(
      array(
        'keep-leases' => $args->getArg('keep-leases'),
        'force' => $args->getArg('force'),
        'foreground' => $args->getArg('foreground'),
        'reserve' => (float)$args->getArg('autoscale-reserve', 0.0),
      ));
  }

}

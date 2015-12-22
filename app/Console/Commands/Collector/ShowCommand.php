<?php

namespace AbuseIO\Console\Commands\Collector;

use AbuseIO\Console\Commands\AbstractListCommand;
use AbuseIO\Collectors\Factory as CollectorFactory;
use Carbon;

class ShowCommand extends AbstractListCommand
{

    /**
     * The console command name.
     * @var string
     */
    protected $signature = 'collector:show
                            {--filter= : Use the name to show collector details }
    ';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Shows the details of an collector';

    /**
     * The headers of the table
     * @var array
     */
    protected $headers = [ 'Collector' ];

    /**
     * The fields of the table / database row
     * @var array
     */
    protected $fields = [ 'Collector' ];

    /**
     * Execute the console command.
     *
     * @return boolean
     */
    public function hydrateCollectorWithFields($collectors)
    {
        $objects = [];

        foreach($collectors as $field => $value) {
            if(is_bool($value)) {
                $value = castBoolToString($value);
            }
            $objects[] =
                [
                    ucfirst($field),
                    $value,
                ];
        }

        return $objects;

    }

    /**
     * {@inheritdoc }
     */
    protected function transformListToTableBody($list)
    {
        return $list;
    }

    /**
     * {@inheritdoc }
     */
    protected function findWithCondition($filter)
    {
        $collector = ucfirst($filter);
        $collector = config("collectors.{$collector}.collector");

        return $this->hydrateCollectorWithFields($collector);
    }

    /**
     * {@inheritdoc }
     */
    protected function findAll()
    {
        return [ ];
    }

    /**
     * {@inheritdoc }
     */
    protected function getAsNoun()
    {
        return "collector";
    }
}
